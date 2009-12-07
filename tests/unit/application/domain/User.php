<?php

class User
{
	protected $_firstName;
	protected $_lastName;
	
    public function __construct($firstName, $lastName)
    {
        $this->_firstName = $firstName;
		$this->_lastName = $lastName;
    }

	public function toJson()
	{
	    $map = array();
		$map["firstName"] = $this->_firstName;
		$map["lastName"] = $this->_lastName;
		return json_encode($map);
	}
}
