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
set_include_path(implode(PATH_SEPARATOR, array(APPLICATION_PATH, LIBRARY_PATH, get_include_path())));

// Create application, request and run
require 'simplerest/RestApplication.php';
$application = new RestApplication(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configuration/application.ini'
);
$application->run();
