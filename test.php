<?php
// Define path to library directory
defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/library'));
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/tests/unit/application'));

// Ensure library path is on include_path
set_include_path(implode(PATH_SEPARATOR, array(LIBRARY_PATH, get_include_path())));

// Autoload library and application files
//require_once 'simplerest/Autoloader.php';
//Autoloader::init(array(LIBRARY_PATH, APPLICATION_PATH));

class HttpRequest
{
	protected $server;
	protected $request;
	
    function __construct($server, $request)
    {
        $this->server = $server;
        $this->request = $request;
    }

	public function getServer() { return $this->server; }
	public function setServer($server) { $this->server = $server; }
	public function getRequest() { return $this->request; }
	public function setRequest($request) { $this->request = $request; }
	
	public function toJson()
	{
		$map = array();
		$map['server'] = $this->server;
		$map['request'] = $this->request;
	    return json_encode($map);
	}
}

require_once 'Zend/Json.php';
$httpRequest1 = new HttpRequest(array('REQUEST_URI' => '/wines'), array('toto' => 'tata'));
$httpRequest2 = new HttpRequest(array('REQUEST_URI' => '/wines'), array('tutu' => 'titi'));
$map = array($httpRequest1, $httpRequest2);
echo Zend_Json::encode($httpRequest1)."\n";
echo Zend_Json::encode($map, true)."\n";
echo Zend_Json::encode(array("loulou" => "toto", "lala" => "tata"))."\n";
