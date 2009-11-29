<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function callWithUnknownUriShouldReturnNull()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/unknownUri", 'REQUEST_METHOD' => HttpMethods::GET));
		$router = new Router(array());
	    $this->assertNull($router->route($request));
	}

    /** @test */
    public function callWithDefaultUsersUriShouldRouteToUsersResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/users", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('ResourceUsers');
		$router = new Router($resources);
		$call = $router->route($request);
		$this->assertSame(array('ResourceUsers', 'get'), $call);
    }

    /** @test */
    public function callWithCategoriesUriWithEndedSlashShouldRouteToCategoriesResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/categories/", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('ResourceCategories');
		$router = new Router($resources);
		$call = $router->route($request);
		$this->assertSame(array('ResourceCategories', 'get'), $call);
    }

	/** @test */
	public function callWithAnnotationUriOnCategoriesGetShouldRouteToCategoriesResource()
	{
		$request = new HttpRequest(array('REQUEST_URI' => "/liste-des-categories", 'REQUEST_METHOD' => HttpMethods::GET));
		$resources = array('ResourceCategories');
		$router = new Router($resources);
		$call = $router->route($request);
		$this->assertSame(array('ResourceCategories', 'get'), $call);

		$request = new HttpRequest(array('REQUEST_URI' => "/categories-list", 'REQUEST_METHOD' => HttpMethods::GET));
		$call = $router->route($request);
		$this->assertSame(array('ResourceCategories', 'get'), $call);
	}
}
