<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* Product resource for testing
*/
class ResourceProduct extends ResourceBase {

	public function get($request) {
		return new HttpResponse(HTTP_OK, "Show product");
	}

	public function post($request) {
		return new HttpResponse(HTTP_OK, "Create product");
	}

	public function put($request) {
		return new HttpResponse(HTTP_OK, "Update product");
	}

	public function delete($request) {
		return new HttpResponse(HTTP_OK, "Delete product");
	}
}
