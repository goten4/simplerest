<?php

/**
 * HTTP response
 * 
 * @package	Rest.Http
 * @author	Emmanuel Bouton
 */
class HttpResponse {

    protected $_responseCode;
    protected $_headers = array();
    protected $_content;

    /**
     * Constructor
     * @param int HTTP Response Code
     * @param string Response Content
     * @return void
     */
     public function __construct($responseCode, $content = null) {
		$this->_responseCode = $responseCode;
		$this->_content = ( isset($content) ? $content : HttpResponseCodes::getMessageForCode($responseCode) );
	}

	public function addHeader($header) {
		$this->headers[] = $header;
	}
	
	public function getHeaders() {
	    return $this->_headers;
	}
	
	public function getContent() {
	    return $this->_content;
	}
	
	public function getResponseCode() {
	    return $this->_responseCode;
	}
}
