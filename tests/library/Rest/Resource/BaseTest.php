<?php
require_once 'Rest/Resource/Base.php';

class TestResource extends ResourceBase {}

class ResourceBaseTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->resource = new TestResource();
	}

	private function _assert405($response) {
		$this->assertNotNull($response);
		$this->assertEquals(HTTP_METHOD_NOT_ALLOWED, $response->getResponseCode());
	}

    /** @test */
    public function optionsMethodShouldReturn405() {
		$response = $this->resource->options();
		$this->_assert405($response);
    }

    /** @test */
    public function getMethodShouldReturn405() {
		$response = $this->resource->get();
		$this->_assert405($response);
    }

    /** @test */
    public function headMethodShouldReturn405() {
		$response = $this->resource->head();
		$this->_assert405($response);
    }

    /** @test */
    public function postMethodShouldReturn405() {
		$response = $this->resource->post();
		$this->_assert405($response);
    }

    /** @test */
    public function putMethodShouldReturn405() {
		$response = $this->resource->put();
		$this->_assert405($response);
    }

    /** @test */
    public function deleteMethodShouldReturn405() {
		$response = $this->resource->delete();
		$this->_assert405($response);
    }

    /** @test */
    public function traceMethodShouldReturn405() {
		$response = $this->resource->trace();
		$this->_assert405($response);
    }

    /** @test */
    public function connectMethodShouldReturn405() {
		$response = $this->resource->connect();
		$this->_assert405($response);
    }
}
