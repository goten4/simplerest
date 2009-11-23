<?php
require_once('Rest/Resource/File.php');

/**
 * Router class for Resources
 *
 * @package Resource
 * @author  Emmanuel Bouton
 */
class ResourceRouter {

    /** Map URI to resources class */
    protected $_resourcesMap = array();

    /**
     * Constructor
     * 
     * @param string   path to resources
     * @return void
     */
    public function __construct($resourcesPath) {
        if (null == $resourcesPath)
            throw new RestException("Could not instanciate ResourceRouter object : Resource path is null !");
        
        $this->_loadResources($resourcesPath);
    }

	/**
	 * Load resources class found in the given resources path
	 * 
	 * @param string
	 * @return void
	 */
	protected function _loadResources($resourcesPath) {
		
		$dir_iterator = new RecursiveDirectoryIterator($resourcesPath);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			try {
				$class = ResourceFile::load($file);
				$this->_resourcesMap[strtolower($class)] = $class;
			} catch (RestException $e) {
				// Ignore non resource files
			}
		}
	}

    /**
     * Instanciate the resource which best matches the URI
     * 
     * @param HttpRequest
     * @return Resource
     */
    public function route($request) {
        $uriElements = explode('/', $request->getUri());
        $resourceClass = $this->_resourcesMap['resource' . strtolower($uriElements[1])];
        return ( null == $resourceClass ? null : new $resourceClass() );
    }
}

