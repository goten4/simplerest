<?php

/**
 * Http Request
 * @author Emmanuel Bouton
 */
class HttpRequest {

    /**
     * Local copy of $_SERVER variable
     * @var array
     */
    protected $_server;

    /**
     * Constructor
     * @param array $_SERVER variable
     * @return void
     */
    function __construct ($server)
    {
        $this->_server = $server;
    }

    /**
     * Get the URI of the request
     * @return string
     */
    public function getUri()
    {
        return $this->_server["REQUEST_URI"];
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
