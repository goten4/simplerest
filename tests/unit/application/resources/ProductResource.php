<?php

/** @resource */
class ProductResource extends Resource {

	/**
	 * @get
	 * @uri /product/:id
	 */
	protected function get($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Show product");
	}

	/**
	 * @post
	 * @uri /product
	 */
	protected function post($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Create product");
	}

	/**
	 * @put
	 * @uri /product
	 */
	protected function put($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Update product");
	}

	/**
	 * @delete
	 * @uri /product/:id
	 */
	protected function delete($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Delete product");
	}
}
