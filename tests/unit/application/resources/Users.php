<?php

/**
* Users resource for testing
*/
class ResourceUsers extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Users list");
	}
}
