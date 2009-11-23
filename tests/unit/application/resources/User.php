<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* User resource for testing
*/
class ResourceUser extends ResourceBase {

	public function get($request) {
		return new HttpResponse(HTTP_OK, "Show user");
	}

	public function post($request) {
		return new HttpResponse(HTTP_OK, "Create user");
	}

	public function put($request) {
		return new HttpResponse(HTTP_OK, "Update user");
	}

	public function delete($request) {
		return new HttpResponse(HTTP_OK, "Delete user");
	}
}
