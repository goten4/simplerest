<?php

/**
 * @resource
 * @uriPrefix /user
 */
class ResourceUser extends Resource {

	/**
	 * @get
	 * @uri :id
	 */
	public function get($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Show user");
	}

	/**
	 * @post
	 */
	public function post($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Create user");
	}

	/**
	 * @put
	 */
	public function put($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Update user");
	}

	/**
	 * @delete
	 * @uri :id
	 */
	public function delete($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Delete user");
	}
}
