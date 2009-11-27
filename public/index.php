<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define path to library directory
defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library path is on include_path
set_include_path(implode(PATH_SEPARATOR, array(LIBRARY_PATH, get_include_path())));

// Autoload library and application files
require_once 'simplerest/Autoloader.php';
Autoloader::init(array(LIBRARY_PATH, APPLICATION_PATH));

// Create application, request and run
$application = new SimpleRestApplication(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configuration/application.ini'
);
$application->setResourcesPath(APPLICATION_PATH . '/resources');
$request = new HttpRequest($_SERVER);
$response = $application->run($request);
header(
	$_SERVER["SERVER_PROTOCOL"] . " " . 
	HttpResponseCodes::getMessageForCode($response->getResponseCode())
);
header('Content-type: text/html');
echo $response->getContent();
