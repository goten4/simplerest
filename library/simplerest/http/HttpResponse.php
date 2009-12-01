<?php

/**
 * HTTP response
 * 
 * @package	simplerest.http
 * @author	Emmanuel Bouton
 */
class HttpResponse
{
    protected $_status = HttpStatus::HTTP_OK;
    protected $_headers = array();
    protected $_content = null;

	public function addHeader($header)
	{
		$this->headers[] = $header;
	}
	
	public function getHeaders()
	{
	    return $this->_headers;
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
}
