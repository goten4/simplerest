<?php
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Config/Xml.php';
require_once 'simplerest/Autoloader.php';

/**
 * Rest Application
 *
 * @package	simplerest
 * @author	Emmanuel Bouton
 */
class RestApplication
{
    /**
     * Application environment
     * 
     * @var string
     */
    protected $_environment;

    /**
     * Flattened (lowercase) option keys
     * 
     * @var array
     */
    protected $_optionKeys = array();

    /**
     * Options for RestApplication
     * 
     * @var array
     */
    protected $_options = array();

	/**
	 * The autoloader instance
	 * 
	 * @var Autoloader
	 */
	protected $_autoloader;


    /**
     * Constructor
     *
     * Initialize application. Potentially initializes include_paths, PHP 
     * settings, and bootstrap class.
     * 
     * @param  string                   $environment 
     * @param  string|array|Zend_Config $options String path to configuration file, or array/Zend_Config of configuration options
     * @throws RestException When invalid options are provided
     * @return void
     */
    public function __construct($environment, $options = null)
    {
	    if (!defined('LIBRARY_PATH')) {
	        throw new RestException('LIBRARY_PATH must be defined');
	    }
        $this->_environment = (string) $environment;
		$this->_autoloader = Autoloader::init(LIBRARY_PATH);
		
        if (null !== $options) {
            if (is_string($options)) {
                $options = $this->_loadConfig($options);
            }
            elseif ($options instanceof Zend_Config) {
                $options = $options->toArray();
            }
            elseif (!is_array($options)) {
                throw new RestException('Invalid options provided; must be location of config file, a config object, or an array');
            }

	        if (!empty($options['autoloader'])) {
				$this->_autoloader->addBasePaths($options['autoloader']);
	        }

            $this->setOptions($options);
        }
    }

    /**
     * Retrieve current environment
     * 
     * @return string
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * Set application options
     * 
     * @param  array $options 
     * @return RestApplication
     */
    public function setOptions(array $options)
    {
        if (!empty($options['config'])) {
            if (is_array($options['config'])) {
                $_options = array();
                foreach ($options['config'] as $tmp) {
                    $_options = $this->mergeOptions($_options, $this->_loadConfig($tmp));
                }
                $options = $this->mergeOptions($_options, $options);
            } else {
                $options = $this->mergeOptions($this->_loadConfig($options['config']), $options);
            }
        }
        
        $this->_options = $options;

        $options = array_change_key_case($options, CASE_LOWER);

        $this->_optionKeys = array_keys($options);

        if (!empty($options['phpsettings'])) {
            $this->setPhpSettings($options['phpsettings']);
        }
        
        if (!empty($options['includepaths'])) {
            $this->setIncludePaths($options['includepaths']);
        }
        
        return $this;
    }

    /**
     * Retrieve application options (for caching)
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Is an option present?
     * 
     * @param  string $key 
     * @return bool
     */
    public function hasOption($key)
    {
        return in_array(strtolower($key), $this->_optionKeys);
    }

    /**
     * Retrieve a single option
     * 
     * @param  string $key 
     * @return mixed
     */
    public function getOption($key)
    {
        if ($this->hasOption($key)) {
            $options = $this->getOptions();
            $options = array_change_key_case($options, CASE_LOWER);
            return $options[strtolower($key)];
        }
        return null;
    }

    /**
     * Merge options recursively
     * 
     * @param  array $array1 
     * @param  mixed $array2 
     * @return array
     */
    public function mergeOptions(array $array1, $array2 = null)
    {
        if (is_array($array2)) {
            foreach ($array2 as $key => $val) {
                if (is_array($array2[$key])) {
                    $array1[$key] = (array_key_exists($key, $array1) && is_array($array1[$key]))
                                  ? $this->mergeOptions($array1[$key], $array2[$key]) 
                                  : $array2[$key];
                } else {
                    $array1[$key] = $val;
                }
            }
        }
        return $array1;
    }

    /**
     * Set PHP configuration settings
     * 
     * @param  array $settings 
     * @param  string $prefix Key prefix to prepend to array values (used to map . separated INI values)
     * @return RestApplication
     */
    public function setPhpSettings(array $settings, $prefix = '')
    {
        foreach ($settings as $key => $value) {
            $key = empty($prefix) ? $key : $prefix . $key;
            if (is_scalar($value)) {
                ini_set($key, $value);
            }
            elseif (is_array($value)) {
                $this->setPhpSettings($value, $key . '.');
            }
        }
        
        return $this;
    }

    /**
     * Set include path
     * 
     * @param  array $paths 
     * @return RestApplication
     */
    public function setIncludePaths(array $paths)
    {
        $path = implode(PATH_SEPARATOR, $paths);
        set_include_path($path . PATH_SEPARATOR . get_include_path());
        return $this;
    }

    /**
     * Load configuration file of options
     * 
     * @param  string $file
     * @throws RestException When invalid configuration file is provided 
     * @return array
     */
    protected function _loadConfig($file)
    {
        $environment = $this->getEnvironment();
        $suffix      = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        
        switch ($suffix) {
            case 'ini':
                try {
                    $config = new Zend_Config_Ini($file, $environment);
                } catch (Zend_Config_Exception $e) {
                    return array();
                }
                break;
                
            case 'xml':
                $config = new Zend_Config_Xml($file, $environment);
                break;

            case 'php':
            case 'inc':
                $config = include $file;
                if (!is_array($config)) {
                    throw new RestException('Invalid configuration file provided; PHP file does not return array value');
                }
                return $config;
                break;

            default:
                throw new RestException('Invalid configuration file provided; unknown config type');
        }
        
        return $config->toArray();
    }

    /**
     * Run the application
     * 
     * @return void
     */
    public function run()
    {
		$request = new HttpRequest($_SERVER, $_REQUEST);
        $resources = $this->_autoloader->getResources();
		$router = new ResourceRouter($resources);
		$resource = $router->route($request);
		if (null == $resource) {
			$response = new HttpResponse($request, HttpStatus::HTTP_NOT_FOUND);
		}
		else {
		    $response = $resource->callMethod($request);
		}
		$response->send();
    }
}
