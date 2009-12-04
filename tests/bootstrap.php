<?php
require_once 'PHPUnit/Framework.php';
define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));
define('TEST_BASE_PATH', realpath(dirname(__FILE__) . '/unit'));
define('FUNCTIONAL_TEST_BASE_PATH', realpath(dirname(__FILE__) . '/functional'));
define('APPLICATION_PATH', TEST_BASE_PATH . '/application');
set_include_path( get_include_path() . PATH_SEPARATOR . LIBRARY_PATH . PATH_SEPARATOR . FUNCTIONAL_TEST_BASE_PATH );
require_once 'simplerest/Autoloader.php';
Autoloader::init(array(LIBRARY_PATH,APPLICATION_PATH));
