<?php

/**
* Products resource for testing
**/
class ResourceProducts extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Products list");
	}
}
