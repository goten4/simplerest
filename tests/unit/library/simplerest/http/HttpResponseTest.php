<?php

class HttpResponseTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function testHttpResponseWithStatusAndContent() {
	    $response = new HttpResponse();
		$response->setStatus(HttpStatus::HTTP_OK);
		$response->setContent("Resource found");
	    $this->assertEquals(HttpStatus::HTTP_OK, $response->getStatus());
	    $this->assertEquals("Resource found", $response->getContent());
    }

    /** @test */
    public function testHttpResponseWithStatusOnly() {
        $response = new HttpResponse();
		$response->setStatus(HttpStatus::HTTP_NOT_FOUND);
	    $this->assertEquals(HttpStatus::HTTP_NOT_FOUND, $response->getStatus());
	    $this->assertNull($response->getContent());
    }
}
