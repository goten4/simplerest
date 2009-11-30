<?php

/** @resource */
class ResourceProduct extends Resource {

	/**
	 * @get
	 * @uri /product/:id
	 */
	public function get($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Show product");
	}

	/**
	 * @post
	 * @uri /product
	 */
	public function post($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Create product");
	}

	/**
	 * @put
	 * @uri /product
	 */
	public function put($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Update product");
	}

	/**
	 * @delete
	 * @uri /product/:id
	 */
	public function delete($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Delete product");
	}
}
