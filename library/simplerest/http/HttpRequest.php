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
	 * @var Format
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
		if (null == $this->_format) {
		    $format = $this->_getFormatFromAcceptHeader();
		    $this->_format = ( $format ? $format : Formats::HTML );
		}
    }

	protected function _parseUri()
	{
	    if (array_key_exists('REQUEST_URI', $this->_server)) {
			$this->_uri = $this->_stripQueryString($this->_server['REQUEST_URI']);
			if ($extensionPosition = strrpos($this->_uri, '.')) {
				$extension = strtolower(substr($this->_uri, $extensionPosition+1));
				if (in_array($extension, Formats::getList())) {
					$this->_uri = substr($this->_uri, 0, $extensionPosition);
					$this->_format = $extension;
				}
			}
		}
	}

	protected function _getFormatFromAcceptHeader()
	{
		return MimeTypes::getFormat($this->getHeader('HTTP_ACCEPT'));
	}

	protected function _stripQueryString($uri)
	{
		$result = explode('?', $uri);
		return $result[0];
	}

    /**
     * Retrieve a header from the request
     * @return string
     */
    public function getHeader($name)
    {
        $header = null;
		if (array_key_exists($name, $this->_server)) {
			$header = $this->_server[$name];
		}
		return $header;
    }

    /**
     * Retrieve a parameter from the request
     * @return string
     */
    public function getParameter($name)
    {
        $parameter = null;
		if (array_key_exists($name, $this->_request)) {
			$parameter = $this->_request[$name];
		}
		return $parameter;
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
     * @return Format
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
        return $this->_server['REQUEST_METHOD'];
    }
}
