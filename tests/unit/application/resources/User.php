<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* User resource for testing
*/
class ResourceUser extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HTTP_OK, "Show user");
	}

	protected function post($request) {
		return new HttpResponse(HTTP_OK, "Create user");
	}

	protected function put($request) {
		return new HttpResponse(HTTP_OK, "Update user");
	}

	protected function delete($request) {
		return new HttpResponse(HTTP_OK, "Delete user");
	}
}
