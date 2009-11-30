<?php

/**
 * Users resource for testing
 * @resource
 */
class ResourceUsers extends Resource {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Users list");
	}
}
