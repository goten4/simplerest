<?php

/**
* Routing class for resources
*/
class ResourceRouter
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
            $this->_generateMapForHttpMethod($resource, $httpMethod);
		}
	}
	
	protected function _generateMapForHttpMethod($resource, $httpMethod)
	{
		$methodName = strtolower($httpMethod);

        $reflection = new ReflectionClass($resource);
		$method = $reflection->getMethod($methodName);
		$docComment = $method->getDocComment();
		if (preg_match_all('/@uri\s+(?<uri>\/\S*)/s', $docComment, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$uri = $this->_stripSlash($match['uri']);
				$this->_uriMap[$httpMethod][$uri] = $resource;
			}
		}
		else {
			$defaultUri = $this->_getDefaultUri($resource);
			$this->_uriMap[$httpMethod][$defaultUri] = $resource;
		}
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
			    $resource = $this->_uriMap[$method][$uri];
				return new $resource();
			}
		}
		return null;
	}
}
