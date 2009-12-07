<?php

/**
 * Products resource for testing.
 * Not declared as a resource so it won't be loaded
 */
class ProductsResource extends Resource {

	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Products list");
		return null;
	}
}
