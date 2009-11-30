<?php

/**
 * Categories resource for testing
 * @resource
 */
class ResourceCategories extends Resource
{
	/**
	 * @get
	 * @uri index
	 * @uri /categories
	 * @uri /categories-list
	 * @uri /liste-des-categories
	 */
	public function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Categories list");
	}
}
