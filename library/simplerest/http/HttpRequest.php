<?php

/**
 * HTTP request
 * 
 * @package	simplerest.http
 * @author	Emmanuel Bouton
 */
class HttpRequest
{
    /**
     * Local copy of $_SERVER variable
     * @var array
     */
    protected $_server;

    /**
     * Local copy of $_REQUEST variable
     * @var array
     */
    protected $_request;

	/**
	 * URI cleaned from query string and extension format
	 * @var string
	 */
	protected $_uri = null;
	
	/**
	 * Format of the request (get from the accept header or from the extension of the uri)
	 * @var HttpFormat
	 */
	protected $_format = null;

    /**
     * Constructor
     * @param array $_SERVER variable
     * @param array $_REQUEST variable
     * @return void
     */
    function __construct($server = null, $request = null)
	{
        $this->_server  = (null == $server ? $_SERVER : $server);
        $this->_request = (null == $request ? $_REQUEST : $request);
		$this->_parseUri();
    }

	protected function _parseUri()
	{
	    if (array_key_exists('REQUEST_URI', $this->_server)) {
			$this->_uri = $this->_stripQueryString($this->_server["REQUEST_URI"]);
			if ($extensionPosition = strrpos($this->_uri, '.')) {
				$extension = strtolower(substr($this->_uri, $extensionPosition+1));
				$reflection = new ReflectionClass('HttpFormats');
				$httpFormats = $reflection->getConstants();
				if (in_array($extension, $httpFormats)) {
					$this->_uri = substr($this->_uri, 0, $extensionPosition);
					$this->_format = $extension;
				}
			}
		}
	}

	protected function _stripQueryString($uri)
	{
		$result = explode('?', $uri);
		return $result[0];
	}

    /**
     * Get the URI of the request
     * @return string
     */
    public function getUri()
	{
        return $this->_uri;
    }

    /**
     * Get the Format requested
     * @return HttpFormat
     */
    public function getFormat()
	{
        return $this->_format;
    }

    /**
     * Get the URI of the request
     * @return string
     */
    public function getMethod()
	{
        return $this->_server["REQUEST_METHOD"];
    }
}
