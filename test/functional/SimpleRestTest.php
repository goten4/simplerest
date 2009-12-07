<?php
require_once 'HttpUnit.php';

class SimpleRestTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		$this->httpUnit = new HttpUnit("http://localhost.simplerest");
	}

    /** @test */
    public function requestToUnknownUriShouldReturn404()
    {
		list($status,$content) = $this->httpUnit->get("/unknownuri");
		$this->assertEquals(HttpStatus::HTTP_NOT_FOUND, $status);
    }

    /** @test */
    public function requestToWinesUriShouldReturnWineList()
    {
		list($status,$content) = $this->httpUnit->get("/wines");
		$this->assertEquals(HttpStatus::HTTP_OK, $status);
		$this->assertContains("<li>Château Margaux (Margaux - Red)</li>", $content);
		$this->assertContains("<li>Château Petrus (Pomerol - Red)</li>", $content);
		$this->assertContains("<li>Domaine de la Romanée Conti (Romanée Conti - Red)</li>", $content);
    }

    /** @test */
    public function requestToJsonWinesUriShouldReturnJsonWineList()
    {
		list($status,$content) = $this->httpUnit->get("/wines.json");
		$map = Json::decode($content);
		$expectedMap = array(
			array("name"=>"Château Margaux","area"=>"Margaux","color"=>"Red"),
			array("name"=>"Château Petrus","area"=>"Pomerol","color"=>"Red"),
			array("name"=>"Domaine de la Romanée Conti","area"=>"Romanée Conti","color"=>"Red")
			);
		$this->assertEquals(HttpStatus::HTTP_OK, $status);
		$this->assertSame($expectedMap, $map);
    }
}
