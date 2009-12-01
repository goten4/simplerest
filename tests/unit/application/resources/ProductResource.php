<?php

/** @resource */
class ProductResource extends Resource {

	/**
	 * @get
	 * @uri /product/:id
	 */
	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Show product");
		return null;
	}

	/**
	 * @post
	 * @uri /product
	 */
	protected function post() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Create product");
		return null;
	}

	/**
	 * @put
	 * @uri /product
	 */
	protected function put() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Update product");
		return null;
	}

	/**
	 * @delete
	 * @uri /product/:id
	 */
	protected function delete() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Delete product");
		return null;
	}
}
