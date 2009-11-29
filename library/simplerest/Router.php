<?php

/**
* Routing class
*/
class Router
{
    /**
     * URI Mapping
     * 
     * @var array
     */
    protected $_uriMap = array();

	function __construct($resources)
	{
		foreach ($resources as $resource) {
			$this->_generateMap($resource);
		}
	}
	
	protected function _generateMap($resource)
	{		
		if (!class_exists($resource)) {
			return;
		}

		$reflection = new ReflectionClass('HttpMethods');
		$httpMethods = $reflection->getConstants();
		foreach ($httpMethods as $httpMethod) {
			$this->_uriMap[$httpMethod] = $this->_generateMapForHttpMethod($resource, $httpMethod);
		}
	}
	
	protected function _generateMapForHttpMethod($resource, $httpMethod)
	{
		$methodName = strtolower($httpMethod);
		$call = array($resource, $methodName);
		$map = array();

        $reflection = new ReflectionClass($resource);
		$method = $reflection->getMethod($methodName);
		$doc = $method->getDocComment();
		if (preg_match_all('/@uri\s+(?<uri>\/\S*)/s', $doc, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$uri = $this->_stripSlash($match['uri']);
				$map[$uri] = $call;
			}
		}
		else {
			$defaultUri = $this->_getDefaultUri($resource);
			$map[$defaultUri] = $call;
		}
		return $map;
	}
	
	protected function _getDefaultUri($resource)
	{
		$isPrefixedByResource = preg_match('/(Resource)?(?<baseName>\w+)/', $resource, $matches);
		$baseName = ( $isPrefixedByResource ? $matches['baseName'] : $resource );
		return '/' . strtolower($baseName);
	}

	protected function _stripSlash($uri)
	{
		if ($uri[strlen($uri) - 1] == '/') {
			$uri = substr($uri, 0, -1);
		}
		return $uri;
	}
	
	public function route($request)
	{
		$uri = $this->_stripSlash($request->getUri());
		$method = $request->getMethod();
		if (array_key_exists($method, $this->_uriMap)) {
			if (array_key_exists($uri, $this->_uriMap[$method])) {
				return $this->_uriMap[$method][$uri];
			}
		}
		return null;
	}
}
