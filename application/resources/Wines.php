<?php

/**
* Users resource
*/
class ResourceWines extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Wines list");
	}
}
