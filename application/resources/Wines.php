<?php

/**
* Users resource
*/
class ResourceWines extends ResourceBase {

	protected function get($request) {
		return new HttpResponse(HTTP_OK, "Wines list");
	}
}
