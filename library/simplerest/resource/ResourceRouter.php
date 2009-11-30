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

    /**
     * Constructor
     * 
     * @param array $resources Array of all referenced resources class names
     */
	function __construct($resources)
	{
		foreach ($resources as $resource) {
			$this->_generateMap($resource);
		}
	}
	
	public function debug($msg = "")
	{
	    echo "$msg\n";
	    print_r($this->_uriMap);
	}
	
	protected function _addToUriMap($httpMethod, $map)
	{
        if (array_key_exists($httpMethod, $this->_uriMap)) {
            $this->_uriMap[$httpMethod] = array_merge($this->_uriMap[$httpMethod], $map);
        } else {
            $this->_uriMap[$httpMethod] = $map;
        }
	}

	protected function _generateMap($resource)
	{		
		if (!class_exists($resource)) {
			return;
		}

        $mapFromClassDocComment = $this->_getUriMapFromClassDocComment($resource);
        
		$reflection = new ReflectionClass('HttpMethods');
		$httpMethods = $reflection->getConstants();
		foreach ($httpMethods as $httpMethod) {
            $mapFromMethodDocComment = $this->_getUriMapFromMethodDocComment($resource, $httpMethod);
            $this->_addToUriMap($httpMethod, $mapFromClassDocComment);
            $this->_addToUriMap($httpMethod, $mapFromMethodDocComment);
		}
	}
	
	protected function _getUriMapFromClassDocComment($resource)
	{
	    $reflection = new ReflectionClass($resource);
		return $this->_getUriMapFromDocComment($resource, $reflection->getDocComment());
	}
	
	protected function _getUriMapFromMethodDocComment($resource, $httpMethod)
	{
		$methodName = strtolower($httpMethod);
        $reflection = new ReflectionClass($resource);
		$method = $reflection->getMethod($methodName);
		return $this->_getUriMapFromDocComment($resource, $method->getDocComment());
	}
	
	protected function _getUriMapFromDocComment($resource, $docComment)
	{
	    $map = array();
		if (preg_match_all('/@uri\s+(?<uri>\/\S*)/s', $docComment, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$uri = $this->_stripSlash($match['uri']);
				$map[$uri] = $resource;
			}
		}
		return $map;
	}
	
	protected function _stripSlash($uri)
	{
		if ($uri[strlen($uri) - 1] == '/') {
			$uri = substr($uri, 0, -1);
		}
		return $uri;
	}
	
	/**
	 * Route the request to the corresponding resource
	 * 
	 * @return a Resource object or null if not found
	 */
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
