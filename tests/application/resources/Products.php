<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* Products resource for testing
*/
class ResourceProducts extends ResourceBase {

	public function get($request) {
		return new HttpResponse(HTTP_OK, "Products list");
	}
}
