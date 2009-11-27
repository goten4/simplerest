<?php

class HttpResponseTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function testHttpResponseWithResponseCodeAndContent() {
	    $response = new HttpResponse(HttpResponseCodes::HTTP_OK, "Resource found");
	    $this->assertEquals(HttpResponseCodes::HTTP_OK, $response->getResponseCode());
	    $this->assertEquals("Resource found", $response->getContent());
    }

    /** @test */
    public function testHttpResponseWithResponseCodeOnly() {
        $response = new HttpResponse(HttpResponseCodes::HTTP_NOT_FOUND);
	    $this->assertEquals(HttpResponseCodes::HTTP_NOT_FOUND, $response->getResponseCode());
	    $this->assertEquals("404 Not Found", $response->getContent());
    }
}
