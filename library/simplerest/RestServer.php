<?php
////////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2009 Jacob Wright
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Constants used in RestServer Class.
 */
class RestFormat
{

	const PLAIN = 'text/plain';
	const HTML = 'text/html; charset=UTF-8';
	const AMF = 'applicaton/x-amf';
	const JSON = 'application/json';
}

/**
 * Description of RestServer
 *
 * @author jacob
 */
class RestServer
{
	public $url;
	public $method;
	public $format;
	
	protected $mode = 'debug';
	protected $map = array();
	protected $errorClasses = array();
	protected $cached = false;

	/**
	 * The constructor.
	 * 
	 * @param string $mode The mode, either debug or production
	 */
	public function  __construct($mode = 'debug')
	{
		$this->mode = $mode;
		
		if ($mode == 'production') {
			if (function_exists('apc_fetch')) {
				$map = apc_fetch('urlMap');
			} elseif (file_exists(dirname(__FILE__) . '/urlMap.cache')) {
				$map = unserialize(file_get_contents(dirname(__FILE__) . '/urlMap.cache'));
			}
			if ($map && is_array($map)) {
				$this->map = $map;
				$this->cached = true;
			}
		}
	}

	public function  __destruct()
	{
		if ($this->mode == 'production' && !$this->cached) {
			if (function_exists('apc_store')) {
				apc_store('urlMap', $this->map);
			} else {
				file_put_contents(dirname(__FILE__) . '/urlMap.cache', serialize($this->map));
			}
		}
	}

	public function refreshCache()
	{
		$this->map = array();
		$this->cached = false;
	}

	
	public function handle()
	{
		$this->url = $this->getPath();
		$this->method = $this->getMethod();
		$this->format = $this->getFormat();
		
		if ($this->method == 'PUT' || $this->method == 'POST') {
			$this->data = $this->getData();
		}

		$call = $this->findUrl();

		if ($call) {
			$obj = $call[0];
			if (is_string($obj)) {
				if (class_exists($obj)) {
					$obj = new $obj();
				} else {
					throw new Exception("Class $obj does not exist");
				}
			}
			$obj->service = $this;
			
			$method = $call[1];

			$params = $call[2];

			$result = call_user_method_array($method, $obj, $params);
			if ($result !== null) {
				$this->sendData($result);
			}
		} else {
			$this->handleError(404);
		}
	}

	public function addClass($class, $basePath = '')
	{
		if (!$this->cached) {
			if (is_string($class) && !class_exists($class)){
				throw new Exception('Invalid method or class');
			} elseif (!is_string($class) && !is_object($class)) {
				throw new Exception('Invalid method or class; must be a classname or object');
			}

			if ($basePath[0] == '/') {
				$basePath = substr($basePath, 1);
			}
			if ($basePath[strlen($basePath) - 1] != '/') {
				$basePath .= '/';
			}

			$this->generateMap($class, $basePath);
		}
	}
	
	public function addErrorClass($class)
	{
		$this->errorClasses[] = $class;
	}
	
	public function handleError($statusCode)
	{
		$method = "handle$statusCode";
		foreach ($this->errorClasses as $class) {
			if (is_object($class)) {
	            $reflection = new ReflectionObject($class);
	        } elseif (class_exists($class)) {
	            $reflection = new ReflectionClass($class);
			}
			
			if ($reflection->hasMethod($method))
			{
				$obj = is_string($class) ? new $class() : $class;
				$obj->$method();
				return;
			}
		}
		
		$this->setStatus($statusCode);
		$this->sendData(array('error' => $statusCode . ' ' . $this->codes[$statusCode]));
	}

	protected function findUrl()
	{
		$urls = $this->map[$this->method];
		if (!$urls) return null;
		
		foreach ($urls as $url => $call) {
			if (!strstr($url, ':')) {
				if ($url == $this->url) {
					return $call;
				}
			} else {
				$regex = preg_replace('/\\\:([^\/]+)/', '(?P<$1>[^/]+)', preg_quote($url));
				if (preg_match(":^$regex$:", $this->url, $matches)) {
					$args = $call[2];
					$params = array();
					foreach ($matches as $arg => $match) {
						if (isset($args[$arg])) {
							$params[$args[$arg]] = $match;
						}
					}
					ksort($params);
					$call[2] = $params;
					return $call;
				}
			}
		}
	}

	protected function generateMap($class, $basePath = '')
	{
		if (is_object($class)) {
            $reflection = new ReflectionObject($class);
        } elseif (class_exists($class)) {
            $reflection = new ReflectionClass($class);
		}

		$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

		foreach ($methods as $method) {
			$doc = $method->getDocComment();
			if (preg_match_all('/@url\s+(GET|POST|PUT|DELETE|HEAD|OPTIONS)[ \t]*\/?(\S*)/s', $doc, $matches, PREG_SET_ORDER)) {

				$params = $method->getParameters();
				
				foreach ($matches as $match) {
					$httpMethod = $match[1];
					$url = $basePath . $match[2];
					if ($url[strlen($url) - 1] == '/') {
						$url = substr($url, 0, -1);
					}
					$call = array($class, $method->getName());
					if (strstr($url, ':')) {
						$args = array();
						foreach ($params as $param) {
							$args[$param->getName()] = $param->getPosition();
						}
						$call[] = $args;
					}

					$this->map[$httpMethod][$url] = $call;
				}
			}
		}
	}

	public function getPath()
	{
		$path = substr($_SERVER['REQUEST_URI'], 1);
		if ($path[strlen($path) - 1] == '/') {
			$path = substr($path, 0, -1);
		}
		return $path;
	}
	
	public function getMethod()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method == 'POST' && $_GET['method'] == 'PUT') {
			$method = 'PUT';
		} elseif ($method == 'POST' && $_GET['method'] == 'DELETE') {
			$method = 'DELETE';
		}
		return $method;
	}
	
	public function getFormat()
	{
		$format = RestFormat::PLAIN;
		$accept = explode(',', $_SERVER['HTTP_ACCEPT']);
		if (in_array(RestFormat::AMF, $accept) || $_GET['format'] == 'amf') {
			$format = RestFormat::AMF;
		} elseif (in_array(RestFormat::JSON, $accept)) {
			$format = RestFormat::JSON;
		}
		return $format;
	}
	
	public function getData()
	{
		$data = file_get_contents('php://input');
		
		if ($this->format == RestFormat::AMF) {
			require_once 'Zend/Amf/Parse/InputStream.php';
			require_once 'Zend/Amf/Parse/Amf3/Deserializer.php';
			$stream = new Zend_Amf_Parse_InputStream(substr($data, 1));
			$deserializer = new Zend_Amf_Parse_Amf3_Deserializer($stream);
			$data = $deserializer->readTypeMarker();
		} else {
			$data = json_decode($data);
		}
		
		return $data;
	}
	

	public function sendData($data)
	{
		header('Content-Type: ' . $this->format);

		if ($this->format == RestFormat::AMF) {
			require_once 'Zend/Amf/Parse/OutputStream.php';
			require_once 'Zend/Amf/Parse/Amf3/Serializer.php';
			$stream = new Zend_Amf_Parse_OutputStream();
			$serializer = new Zend_Amf_Parse_Amf3_Serializer($stream);
			$serializer->writeTypeMarker($data);
			$data = $stream->getStream();
		} else {
			$data = json_encode($data);
		}

		echo $data;
	}

	public function setStatus($code)
	{
		$code = $this->codes[strval($code)];
		header("{$_SERVER['SERVER_PROTOCOL']} $code");
	}


	private $codes = array(
		'100' => 'Continue',
		'200' => 'OK',
		'201' => 'Created',
		'202' => 'Accepted',
		'203' => 'Non-Authoritative Information',
		'204' => 'No Content',
		'205' => 'Reset Content',
		'206' => 'Partial Content',
		'300' => 'Multiple Choices',
		'301' => 'Moved Permanently',
		'302' => 'Found',
		'303' => 'See Other',
		'304' => 'Not Modified',
		'305' => 'Use Proxy',
		'307' => 'Temporary Redirect',
		'400' => 'Bad Request',
		'401' => 'Unauthorized',
		'402' => 'Payment Required',
		'403' => 'Forbidden',
		'404' => 'Not Found',
		'405' => 'Method Not Allowed',
		'406' => 'Not Acceptable',
		'409' => 'Conflict',
		'410' => 'Gone',
		'411' => 'Length Required',
		'412' => 'Precondition Failed',
		'413' => 'Request Entity Too Large',
		'414' => 'Request-URI Too Long',
		'415' => 'Unsupported Media Type',
		'416' => 'Requested Range Not Satisfiable',
		'417' => 'Expectation Failed',
		'500' => 'Internal Server Error',
		'501' => 'Not Implemented',
		'503' => 'Service Unavailable'
	);
}
