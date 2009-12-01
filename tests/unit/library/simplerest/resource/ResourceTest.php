<?php

class TestResource extends Resource {}

class ResourceTest extends PHPUnit_Framework_TestCase {

	private function _assertStatus($status, $response) {
		$this->assertNotNull($response);
		$this->assertEquals($status, $response->getStatus());
	}

	private function _assert405($response) {
		$this->_assertStatus(HttpStatus::HTTP_METHOD_NOT_ALLOWED, $response);
	}
	
	private function _newResource($method)
	{
		$request = new HttpRequest(array('REQUEST_METHOD' => $method));
		$response = new HttpResponse();
		return new TestResource($request, $response);
	}

    /** @test */
    public function callToBadMethodShouldReturn400() {
        $resource = $this->_newResource('BAD_METHOD');
		$response = $resource->callMethod();
		$this->_assertStatus(HttpStatus::HTTP_BAD_REQUEST, $response);
    }

    /** @test */
    public function optionsMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::OPTIONS);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function getMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::GET);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function headMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::HEAD);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function postMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::POST);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function putMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::PUT);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function deleteMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::DELETE);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function traceMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::TRACE);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }

    /** @test */
    public function connectMethodShouldReturn405() {
        $resource = $this->_newResource(HttpMethods::CONNECT);
		$response = $resource->callMethod();
		$this->_assert405($response);
    }
}
