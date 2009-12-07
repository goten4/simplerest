<?php

/**
 * Users resource for testing
 * @resource
 * @uri /users
 */
class UsersResource extends Resource {

	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Users list");
		return null;
	}
}
