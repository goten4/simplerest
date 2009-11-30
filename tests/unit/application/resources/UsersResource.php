<?php

/**
 * Users resource for testing
 * @resource
 * @uri /users
 */
class UsersResource extends Resource {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Users list");
	}
}
