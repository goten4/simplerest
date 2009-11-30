<?php

/**
 * Autoloader singleton
 * 
 * @package	simplerest
 * @author Emmanuel Bouton
 */
class Autoloader {

	/**
	* Singleton instance
	* 
	* Marked only as protected to allow extension of the class. To extend,
	* simply override {@link getInstance()}.
	* 
	* @var Autoloader
	*/
	protected static $_instance = null;

    /** Map class names to files */
    protected $_filesMap = array();

    /** List of found resources */
    protected $_resources = array();


	/**
	* Constructor
	* Instantiate using {@link getInstance()}; Autoloader is a singleton object
	* 
	* @return void
	*/
	protected function __construct() {
	}

	/**
	* Enforce singleton; disallow cloning
	* 
	* @return void
	*/
	private function __clone() {
	}

	/**
	* Singleton instance
	* 
	* @return Autoloader
	*/
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	* Init method
	* 
	* @param string|array Path or Array of paths
	* @return Autoloader
	*/
	public static function init($paths) {
		$autoloader = self::getInstance();
		if (is_array($paths)) {
			$autoloader->addBasePaths($paths);
		} else {
			$autoloader->addBasePath($paths);
		}
		//$autoloader->debug();
		return $autoloader;
	}
	
	public function debug() {
		print_r($this->_filesMap);
	}

    /**
     * Call {@link addBasePath($path)} for all paths of the given array
     * 
     * @param array $paths
     * @return void
     */
	public function addBasePaths($paths) {
		foreach ($paths as $path) {
			$this->addBasePath($path);
		}
	}

    /**
     * Browse recursively a path and store found php files in the filesMap
     * 
     * @param string $path
     * @return void
     */
	public function addBasePath($path) {
		$dirIterator = new RecursiveDirectoryIterator($path);
		$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			$extension = pathinfo($file, PATHINFO_EXTENSION);
			if ("php" == $extension || "inc" == $extension) {
                $fileContent = file_get_contents($file);
                $classFound = preg_match('/(?<head>(\r?\n.*)*)\r?\n(abstract)?\s*(class|interface)\s+(?<name>\w+)/', $fileContent, $matches);
				if ($classFound) {
					$className = $matches['name'];
					$this->_filesMap[strtolower($className)] = $file->getRealpath();
					if (strpos($matches['head'], "* @resource") && !in_array($className, $this->_resources)) {
						$this->_resources[] = $className;
					}
				}
			}
		}
	}

    /**
     * Get the file path of the given class name
     * 
     * @return string
     */
    public function getFilePath($className) {
		$key = strtolower($className);
        return ( array_key_exists($key, $this->_filesMap) ? $this->_filesMap[$key] : null );
    }

	/**
	 * Get the resources list found in the browsed directories
	 * 
	 * @return array
	 */
	public function getResources() {
		return $this->_resources;
	}
}

function __autoload($className) {
    $autoloader = Autoloader::getInstance();
    $path = $autoloader->getFilePath($className);
    if ($path != null && file_exists($path)) {
        require_once $path;
        if (class_exists($className)) {
            return;
        }
    }
}
