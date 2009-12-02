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
    public function whenRequestHasNoAcceptHeaderConstructorShouldInitContentTypeToHTML()
    {
        $response = new HttpResponse(new HttpRequest());
	    $this->assertEquals('text/html', $response->getContentType());
    }

    /** @test */
    public function whenRequestHasAcceptHeaderConstructorShouldInitContentTypeToTheGivenAcceptHeader()
    {
        $request = new HttpRequest(array('HTTP_ACCEPT' => 'application/xml'));
        $response = new HttpResponse($request);
	    $this->assertEquals('application/xml', $response->getContentType());
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
