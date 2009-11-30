<?php

/**
 * Products resource for testing.
 * Not declared as a resource so it won't be loaded
 */
class ProductsResource extends Resource {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Products list");
	}
}
