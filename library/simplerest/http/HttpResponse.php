<?php

/**
 * HTTP response
 * 
 * @package	simplerest.http
 * @author	Emmanuel Bouton
 */
class HttpResponse
{
    protected $_status;
    protected $_headers = array();
    protected $_content;
    protected $_request;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct($request)
    {
        // Default values
        $acceptHeader = $request->getHeader('HTTP_ACCEPT');
        $defaultContentType = ( null == $acceptHeader ? MimeTypes::getMimeType(Formats::HTML) : $acceptHeader );
        $this->setContentType($defaultContentType);
        $this->_status = HttpStatus::HTTP_OK;
        $this->_content = null;
        $this->_request = $request;
    }

	public function addHeader($name, $value)
	{
		$this->_headers[$name] = $value;
	}
	
	public function getHeaders()
	{
	    return $this->_headers;
	}
	
	public function getHeader($name)
	{
	    return $this->_headers[$name];
	}
	
	public function setContentType($contentType)
	{
	    $this->addHeader(HttpHeaders::CONTENT_TYPE, $contentType);
	}
	
	public function getContentType()
	{
	    return $this->getHeader(HttpHeaders::CONTENT_TYPE);
	}
	
	public function setContent($content)
	{
	    $this->_content = $content;
	}
	
	public function getContent()
	{
	    return $this->_content;
	}
	
	public function setStatus($status)
	{
	    $this->_status = $status;
	}
	
	public function getStatus()
	{
	    return $this->_status;
	}
	
	public function getStatusHeader()
	{
	    return $this->_request->getHeader('SERVER_PROTOCOL') . " " . $this->_status . " " . HttpStatus::getMessage($this->_status);
	}
}
