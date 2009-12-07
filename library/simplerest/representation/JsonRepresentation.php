<?php
require_once 'Zend/Json.php';

/**
* JSON Representation class
*/
class JsonRepresentation extends StringRepresentation
{
    function __construct($input)
	{
		$jsonInput = Zend_Json::encode($input);
        $this->setInput($jsonInput);
    }
}
