<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';

class HttpResponseTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function testHttpResponseWithResponseCodeAndContent() {
	    $response = new HttpResponse(HTTP_OK, "Resource found");
	    $this->assertEquals(HTTP_OK, $response->getResponseCode());
	    $this->assertEquals("Resource found", $response->getContent());
    }

    /** @test */
    public function testHttpResponseWithResponseCodeOnly() {
        $response = new HttpResponse(HTTP_NOT_FOUND);
	    $this->assertEquals(HTTP_NOT_FOUND, $response->getResponseCode());
	    $this->assertEquals("404 Not Found", $response->getContent());
    }
}
