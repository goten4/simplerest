<?php

class HttpRequestTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function whenUriIsBasicConstructorShouldStoreIt()
    {
        $httpRequest = new HttpRequest(array("REQUEST_URI" => "/users"));
		$this->assertEquals("/users", $httpRequest->getUri());
    }

    /** @test */
    public function whenUriHasParametersConstructorShouldCleanIt()
    {
        $httpRequest = new HttpRequest(array("REQUEST_URI" => "/users/?age=33&height=180"));
		$this->assertEquals("/users/", $httpRequest->getUri());
    }

    /** @test */
    public function whenUriHasFormatExtensionConstructorShouldCleanItAndSetTheFormat()
    {
        $httpRequest = new HttpRequest(array("REQUEST_URI" => "/users.xml"));
		$this->assertEquals("/users", $httpRequest->getUri());
		$this->assertEquals(Formats::XML, $httpRequest->getFormat());
    }
}
