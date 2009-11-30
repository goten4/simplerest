<?php

class TestResource extends Resource {}

class ResourceTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->resource = new TestResource();
	}

	private function _assertHttpCode($httpCode, $response) {
		$this->assertNotNull($response);
		$this->assertEquals($httpCode, $response->getResponseCode());
	}

	private function _assert405($response) {
		$this->_assertHttpCode(HttpResponseCodes::HTTP_METHOD_NOT_ALLOWED, $response);
	}

    /** @test */
    public function callToBadMethodShouldReturn400() {
        $request = new HttpRequest(array('REQUEST_METHOD' => 'BAD_METHOD'));
		$response = $this->resource->callMethod($request);
		$this->_assertHttpCode(HttpResponseCodes::HTTP_BAD_REQUEST, $response);
    }

    /** @test */
    public function optionsMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::OPTIONS));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function getMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::GET));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function headMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::HEAD));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function postMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::POST));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function putMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::PUT));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function deleteMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::DELETE));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function traceMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::TRACE));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }

    /** @test */
    public function connectMethodShouldReturn405() {
        $request = new HttpRequest(array('REQUEST_METHOD' => HttpMethods::CONNECT));
		$response = $this->resource->callMethod($request);
		$this->_assert405($response);
    }
}
