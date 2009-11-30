<?php

/**
 * Users resource
 * @resource
 * @uri /wines
 * @uri /wines-list
 * @uri /liste-des-vins
 */
class WinesResource extends Resource
{
	protected function get($request)
	{
		return new HttpResponse(HttpResponseCodes::HTTP_OK, "Wines list");
	}
}
