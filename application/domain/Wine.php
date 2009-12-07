<?php
require_once 'Zend/Json.php';

/**
* Wine class
*/
class Wine
{
	protected $_name;
	protected $_area;
	protected $_color;
	
	function __construct($name, $area, $color) {
		$this->_name  = $name;
		$this->_area  = $area;
		$this->_color = $color;
	}
	
	public function setName($name) { $this->_name = $name; }
	public function getName() { return $this->_name; }
	
	public function setArea($area) { $this->_area = $area; }
	public function getArea() { return $this->_area; }
	
	public function setColor($color) { $this->_color = $color; }
	public function getColor() { return $this->_color; }
	
	public function toJson()
	{
	    $map = array();
		$map["name"] = $this->getName();
		$map["area"] = $this->getArea();
		$map["color"] = $this->getColor();
		return Json::encode($map);
	}
}
