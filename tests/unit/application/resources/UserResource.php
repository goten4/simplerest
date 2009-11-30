<?php

/**
 * @resource
 * @uri /user
 */
class UserResource extends Resource {

	/**
	 * @get
	 * @uri :id
	 */
	protected function get($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Show user");
	}

	/**
	 * @post
	 */
	protected function post($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Create user");
	}

	/**
	 * @put
	 */
	protected function put($data) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Update user");
	}

	/**
	 * @delete
	 * @uri :id
	 */
	protected function delete($id) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Delete user");
	}
}
