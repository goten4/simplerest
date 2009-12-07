<?php

class ResourceRouterTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function callWithUnknownUriShouldReturnNull()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/unknownUri", 'REQUEST_METHOD' => HttpMethods::GET));
		$router = new ResourceRouter(array());
	    $this->assertNull($router->route($request));
	}

    /** @test */
    public function callWithDefaultUsersUriShouldRouteToUsersResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/users", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('UsersResource', 'CategoriesResource');
		$router = new ResourceRouter($resources);
		$resource = $router->route($request);
		$this->assertTrue(is_a($resource, 'UsersResource'));
    }

    /** @test */
    public function callWithCategoriesUriWithEndedSlashShouldRouteToCategoriesResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/categories/", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('CategoriesResource');
		$router = new ResourceRouter($resources);
		$resource = $router->route($request);
		$this->assertTrue(is_a($resource, 'CategoriesResource'));
    }

	/** @test */
	public function callWithAnnotationUriOnCategoriesGetShouldRouteToCategoriesResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/liste-des-categories", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('CategoriesResource');
		$router = new ResourceRouter($resources);
		$resource = $router->route($request);
		$this->assertTrue(is_a($resource, 'CategoriesResource'));

		$request = new HttpRequest(array('REQUEST_URI' => "/categories-list", 'REQUEST_METHOD' => HttpMethods::GET));
		$call = $router->route($request);
		$this->assertTrue(is_a($resource, 'CategoriesResource'));
	}
}
