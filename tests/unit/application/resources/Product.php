<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* Product resource for testing
*/
class ResourceProduct extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HTTP_OK, "Show product");
	}

	protected function post($request) {
		return new HttpResponse(HTTP_OK, "Create product");
	}

	protected function put($request) {
		return new HttpResponse(HTTP_OK, "Update product");
	}

	protected function delete($request) {
		return new HttpResponse(HTTP_OK, "Delete product");
	}
}
