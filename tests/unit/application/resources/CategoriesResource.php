<?php

/**
 * Categories resource for testing
 * @resource
 * @uri /categories
 */
class CategoriesResource extends Resource
{
	/**
	 * @get
	 * @uri index
	 * @uri /categories-list
	 * @uri /liste-des-categories
	 */
	public function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Categories list");
	}
}
