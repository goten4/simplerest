<?php
require_once 'HttpUnit.php';

class SimpleRestTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function requestToUnknownUriShouldReturn404()
    {
		$httpUnit = new HttpUnit("http://localhost.simplerest");
		list($status,$content) = $httpUnit->get("/unknownuri");
		$this->assertEquals(HttpStatus::HTTP_NOT_FOUND, $status);
    }

    /** @test */
    public function requestToWinesUriShouldReturnWineList()
    {
		$httpUnit = new HttpUnit("http://localhost.simplerest");
		list($status,$content) = $httpUnit->get("/wines");
		$this->assertEquals(HttpStatus::HTTP_OK, $status);
		$this->assertContains("Margaux", $content);
		$this->assertContains("Petrus", $content);
		$this->assertContains("Conti", $content);
    }
}
