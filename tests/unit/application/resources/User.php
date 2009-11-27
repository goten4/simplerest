<?php

/**
* User resource for testing
*/
class ResourceUser extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Show user");
	}

	protected function post($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Create user");
	}

	protected function put($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Update user");
	}

	protected function delete($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Delete user");
	}
}
