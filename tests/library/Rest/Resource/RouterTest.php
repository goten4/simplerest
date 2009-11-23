<?php
require_once('Rest/Resource/Router.php');

class ResourceRouterTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     * @expectedException RestException
     */
    public function newRouterWithNullResourcesPathShouldThrowException() {
        $router = new ResourceRouter(null);
    }
    
    /** @test */
    public function newRouterWithCorrectResourcesPathShouldLoadResources() {
        $router = new ResourceRouter(TEST_BASE_PATH . '/application/resources');
        $this->assertTrue(class_exists('ResourceUsers'));
        $this->assertTrue(class_exists('ResourceUser'));
        $this->assertTrue(class_exists('ResourceProducts'));
        $this->assertTrue(class_exists('ResourceProduct'));
    }

    /** @test */
    public function routingAnUnknownUriShouldReturnNull() {
        $router = new ResourceRouter(TEST_BASE_PATH . '/application/resources');
		$request = new HttpRequest(array('REQUEST_URI' => "/unknownUri", 'REQUEST_METHOD' => HttpMethods::GET));
        $this->assertNull($router->route($request));
    }
    
    /** @test */
    public function routingUsersUriShouldReturnUsersResource() {
        $router = new ResourceRouter(TEST_BASE_PATH . '/application/resources');
		$request = new HttpRequest(array('REQUEST_URI' => "/users", 'REQUEST_METHOD' => HttpMethods::GET));
        $resource = $router->route($request);
        $this->assertTrue(is_a($resource, "ResourceUsers"));
    }
}
