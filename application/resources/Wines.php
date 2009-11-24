<?php
require_once 'Rest/Http/Response.php';
require_once 'Rest/Http/ResponseCodes.php';
require_once 'Rest/Resource/Base.php';

/**
* Users resource
*/
class ResourceWines extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HTTP_OK, "Wines list");
	}
}
