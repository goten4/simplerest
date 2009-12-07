<?php

/**
 * @resource
 * @uri /user
 */
class UserResource extends Resource {

	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Show user");
		return null;
	}

	protected function post() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Create user");
		return null;
	}

	protected function put() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Update user");
		return null;
	}

	protected function delete() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Delete user");
		return null;
	}
}
