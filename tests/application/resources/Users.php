<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';

/**
* Users resource for testing
*/
class ResourceUsers extends ResourceBase {

	public function get() {
		return new HttpResponse(HTTP_OK, "Users list");
	}
}
