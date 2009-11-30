<?php

/**
* Users resource
*/
class ResourceWines extends Resource {

	protected function get($request) {
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Wines list");
	}
}
