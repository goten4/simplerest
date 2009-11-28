<?php

/**
 * Class for loading resources files
 * 
 * @package	simplerest.resource
 * @author	Emmanuel Bouton
 */
class ResourceFile {

	/**
	 * Loads the given resource class
	 * 
	 * @param string $path
	 * @throws RestException When invalid path is given or when the resource class could not be loaded
	 * @return string The name of the loaded resource class
	 */
	public static function load($path) {

		if (!self::_isValidPhpFile($path))
			throw new RestException("Could not load resource file : invalid path !");

		$class = "Resource" . basename($path, ".php");
		require_once $path;
		if (!class_exists($class) || !is_subclass_of($class, "ResourceBase"))
			throw new RestException("Could not load resource file : resource class definition not found !");
		
		return $class;
	}
	
	/**
	 * Checks if the given path is a valid php file
	 * 
	 * @param string $path
	 * @return bool
	 */
	protected static function _isValidPhpFile($path) {

		if (null == $path)
			return false;
		
		if (self::_isNotSecure($path))
			return false;
		
		if (!is_file($path))
			return false;
		
		if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) != "php")
			return false;
		
		return true;
	}

    /**
     * Checks if the given path contains exploits
     *
     * @param  string $path
     * @return bool
     */
    protected static function _isNotSecure($path) {
        return preg_match('/[^a-z0-9\\/\\\\_.:-]/i', $path);
    }
}
