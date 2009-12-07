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
		return Zend_Json::encode($map);
	}
}

class JsonRepresentationTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function getContentShouldRetrieveJsonRepresentationOfTheGivenArray()
    {
        $map = array("key1" => "value1", "key2" => 2);
		$jsonRepresentation = new JsonRepresentation($map);
		$this->assertEquals("{\"key1\":\"value1\",\"key2\":2}", $jsonRepresentation->getContent());
    }

    /** @test */
    public function getContentShouldRetrieveJsonRepresentationOfTheGivenObject()
    {
        $user = new User("Emmanuel", "Bouton");
		$jsonRepresentation = new JsonRepresentation($user);
		$this->assertEquals("{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}", $jsonRepresentation->getContent());
    }

    /** @test */
    public function getContentShouldRetrieveJsonRepresentationOfTheGivenArrayOfObjects()
    {
        $users = array();
		$users["user1"] = new User("Emmanuel", "Bouton");
		$users["user2"] = new User("Samuel", "Rosa");
		$jsonRepresentation = new JsonRepresentation($users);
		$this->assertContains("{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}", $jsonRepresentation->getContent());
    }
}
