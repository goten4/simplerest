<?php
require_once 'PHPUnit/Framework.php';
define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));
define('TEST_BASE_PATH', realpath(dirname(__FILE__)));
set_include_path( get_include_path() . PATH_SEPARATOR . LIBRARY_PATH );
