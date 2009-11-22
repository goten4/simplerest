<?php
require_once 'Rest/Http/Response.php';

/**
* Base class for resources. Override the methods you want to implement.
*
* @package	Resource
* @author	Emmanuel Bouton
*/
abstract class ResourceBase {
	
	private function _notAllowed() {
		return new HttpResponse(HTTP_METHOD_NOT_ALLOWED);
	}

	public function options($params = array()) {
		return $this->_notAllowed();
	}

	public function get($params = array()) {
		return $this->_notAllowed();
	}

	public function head($params = array()) {
		return $this->_notAllowed();
	}

	public function post($params = array()) {
		return $this->_notAllowed();
	}

	public function put($params = array()) {
		return $this->_notAllowed();
	}

	public function delete($params = array()) {
		return $this->_notAllowed();
	}

	public function trace($params = array()) {
		return $this->_notAllowed();
	}

	public function connect($params = array()) {
		return $this->_notAllowed();
	}
}
