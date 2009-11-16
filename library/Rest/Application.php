<?php
/**
 * Rest Framework
 * 
 * @package	Rest
 * @author	Emmanuel Bouton
 * @version	$Id: $
 */
class RestApplication
{

    /**
     * Application environment
     * 
     * @var string
     */
    protected $_environment;

    /**
     * Constructor
     *
     * Initialize application.
     * 
     * @param  string                   $environment 
     * @param  string|array|Zend_Config $options String path to configuration file, or array/Zend_Config of configuration options
     * @throws Rest_Exception When invalid options are provided
     * @return void
     */
    public function __construct($environment, $options = null)
    {
		$this->_environment = (string) $environment;
    }

    /**
     * Retrieve current environment
     * 
     * @return string
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }
}
?>