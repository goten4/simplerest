<?php

/**
 * @resource
 * @uri /user
 */
class UserResource extends Resource {

	/**
	 * @get
	 * @uri :id
	 */
	protected function get() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Show user");
		return null;
	}

	/**
	 * @post
	 */
	protected function post() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Create user");
		return null;
	}

	/**
	 * @put
	 */
	protected function put() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Update user");
		return null;
	}

	/**
	 * @delete
	 * @uri :id
	 */
	protected function delete() {
		$this->setStatus(HttpStatus::HTTP_OK);
		$this->setContent("Delete user");
		return null;
	}
}
