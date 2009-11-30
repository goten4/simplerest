#!/usr/bin/php

<?php
// Define path to library directory
defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/library'));
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/tests/unit/application'));

// Ensure library path is on include_path
set_include_path(implode(PATH_SEPARATOR, array(LIBRARY_PATH, get_include_path())));

// Autoload library and application files
require_once 'simplerest/Autoloader.php';
Autoloader::init(array(LIBRARY_PATH, APPLICATION_PATH));

$str = "BaseResource";
$isPrefixedByResource = preg_match('/(?<baseName>\w+)(Resource)?/', $str, $matches);
if ($isPrefixedByResource) {
	echo "Base trouvée : " . $matches['baseName'] . "\n";
} else {
	echo "Base non trouvée\n";
}

#$fileContent = file_get_contents("tests/unit/application/resources/Product.php");
#$classFound = preg_match('/(?<head>(\r?\n.*)*)\r?\n(abstract)?[[:blank:]]*(class|interface) (?<name>\w+)/', $fileContent, $matches);
#if ($classFound) {
#	echo "Classe trouvée : " . $matches['name'] . "\n";
#	if (strpos($matches['head'], "* @resource")) {
#		echo " => C'est une resource\n";
#	}
#} else {
#	echo "Classe non trouvée\n";
#}
