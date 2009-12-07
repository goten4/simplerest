<?php

class HttpResponseTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function constructorShouldInitStatusToOKAndContentToNull()
    {
        $response = new HttpResponse(new HttpRequest());
	    $this->assertEquals(HttpStatus::HTTP_OK, $response->getStatus());
	    $this->assertNull($response->getContent());
    }
    
    /** @test */
    public function constructorShouldStoreTheGivenStatus()
    {
        $response = new HttpResponse(new HttpRequest(), HttpStatus::HTTP_NOT_FOUND);
        $this->assertEquals(HttpStatus::HTTP_NOT_FOUND, $response->getStatus());
    }

    /** @test */
    public function whenRequestHasNoAcceptHeaderConstructorShouldInitContentTypeToHTML()
    {
        $response = new HttpResponse(new HttpRequest());
	    $this->assertEquals('text/html; charset=utf-8', $response->getContentType());
    }
    
    /** @test */
    public function getStatusHeaderShouldReturnAValidStatusHeader()
    {
        $response = new HttpResponse(new HttpRequest(array('SERVER_PROTOCOL' => 'HTTP/1.1')));
        $this->assertEquals('HTTP/1.1 200 OK', $response->getStatusHeader());
        $response->setStatus(HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertEquals('HTTP/1.1 500 Internal Server Error', $response->getStatusHeader());
    }
}
