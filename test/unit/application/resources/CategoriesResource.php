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
	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Categories list");
		return null;
	}
}
