<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function encodeBooleanShouldConvertItToString()
    {
        $this->assertEquals("true", Json::encode(true));
    }

    /** @test */
    public function encodeIntegerShouldConvertItToString()
    {
        $this->assertEquals("18", Json::encode(18));
    }

    /** @test */
    public function encodeDecimalShouldConvertItToString()
    {
        $this->assertEquals("3.14", Json::encode(3.14));
    }

    /** @test */
    public function encodeStringShouldReturnItSurroundedWithQuotes()
    {
        $this->assertEquals("\"Hello World!\"", Json::encode("Hello World!"));
    }

	/** @test */
	public function encodeArrayShouldReturnACorrectJsonArray()
	{
	    $map = array("key1" => "value1", "key2" => array(1,2,3), "key3" => 3, 35.5);
		$expectedJsonString = "{\"key1\":\"value1\",\"key2\":[1,2,3],\"key3\":3,\"0\":35.5}";
		$this->assertEquals($expectedJsonString, Json::encode($map));
	}

	/** @test */
	public function encodeObjectShouldCallItsToJsonMethod()
	{
	    $user = new User("Emmanuel", "Bouton");
		$expectedJsonString = "{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}";
		$this->assertEquals($expectedJsonString, Json::encode($user));
	}
	
	/** @test */
	public function encodeAnEmptyArrayShouldReturnEmptyJsonArray()
	{
	    $this->assertEquals("[]", Json::encode(array()));
	}
	
	/** @test */
	public function encodeVectorOfObjectsShouldReturnACorrectJsonArray()
	{
	    $user1 = new User("Emmanuel", "Bouton");
		$user2 = new User("Samuel", "Rosa");
		$vector = array($user1, $user2);
		$expectedJsonString =
			"[{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}," .
			"{\"firstName\":\"Samuel\",\"lastName\":\"Rosa\"}]";
		$this->assertEquals($expectedJsonString, Json::encode($vector));
	}
	
	/** @test */
	public function encodeMapOfObjectsShouldReturnACorrectJsonMap()
	{
	    $user1 = new User("Emmanuel", "Bouton");
		$user2 = new User("Samuel", "Rosa");
		$vector = array("Manu" => $user1, "Sam" => $user2);
		$expectedJsonString =
			"{\"Manu\":{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}," .
			"\"Sam\":{\"firstName\":\"Samuel\",\"lastName\":\"Rosa\"}}";
		$this->assertEquals($expectedJsonString, Json::encode($vector));
	}
	
    /** @test */
    public function decodeJsonBooleanShouldReturnBooleanValue()
    {
        $this->assertTrue(Json::decode("true"));
    }

    /** @test */
    public function decodeJsonIntegerShouldReturnIntegerValue()
    {
        $this->assertEquals(18, Json::decode("18"));
    }

    /** @test */
    public function decodeJsonDecimalShouldReturnDecimalValue()
    {
        $this->assertEquals(3.14, Json::decode("3.14"));
    }

    /** @test */
    public function decodeJsonStringShouldReturnItWithoutQuotes()
    {
        $this->assertEquals("Hello World!", Json::decode("\"Hello World!\""));
    }

	/** @test */
	public function decodeJsonArrayShouldReturnTheCorrespondingPHPArray()
	{
		$jsonString = "{\"key1\":\"value1\",\"key2\":[1,2,3],\"key3\":3,\"0\":35.5}";
	    $expectedMap = array("key1" => "value1", "key2" => array(1,2,3), "key3" => 3, 35.5);
		$this->assertEquals($expectedMap, Json::decode($jsonString));
	}

	/** @test */
	public function decodeAnEmptyJsonArrayShouldReturnEmptyPhpArray()
	{
	    $this->assertEquals(array(), Json::decode("[]"));
	}
	
	/** @test */
	public function decodeJsonVectorShouldReturnACorrectPHPArray()
	{
	    $expectedArray = array(
			array("firstName"=>"Emmanuel", "lastName"=>"Bouton"),
			array("firstName"=>"Samuel", "lastName"=>"Rosa"));
		$jsonString =
			"[{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}," .
			"{\"firstName\":\"Samuel\",\"lastName\":\"Rosa\"}]";
		$this->assertEquals($expectedArray, Json::decode($jsonString));
	}

	/** @test */
	public function decodeMapJsonStringShouldReturnTheCorrespondingPHPArray()
	{
		$jsonString =
			"{\"Manu\":{\"firstName\":\"Emmanuel\",\"lastName\":\"Bouton\"}," .
			"\"Sam\":{\"firstName\":\"Samuel\",\"lastName\":\"Rosa\"}}";
		$expectedArray = array(
			"Manu" => array("firstName"=>"Emmanuel","lastName"=>"Bouton"),
			"Sam" => array("firstName"=>"Samuel","lastName"=>"Rosa"));
		$this->assertSame($expectedArray, Json::decode($jsonString));
	}
}
