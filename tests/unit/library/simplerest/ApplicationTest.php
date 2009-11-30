<?php

class RestApplicationTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->includePath = get_include_path();
		$this->request = new HttpRequest(array('REQUEST_URI' => "/users", 'REQUEST_METHOD' => HttpMethods::GET));
        $this->application = new RestApplication('testing', TEST_BASE_PATH . '/application/configuration/application.ini');
		//$this->application->setResourcesPath(TEST_BASE_PATH . '/application/resources');
        $this->iniOptions = array();
    }

    public function tearDown() {
        foreach ($this->iniOptions as $key) {
            ini_restore($key);
        }
    }

    /** @test */
    public function constructorShouldSetsEnvironment() {
        $this->assertEquals('testing', $this->application->getEnvironment());
        $this->assertTrue($this->application->hasOption('monoptionamoi'));
    }

    /** @test */
    public function constructorShouldSetOptionsWhenProvided() {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertEquals($options, $application->getOptions());
    }

    /** @test */
    public function constructorShouldAutoloadPathsSpecifiedInTheConfigurationAndFindTheClasses() {
		$this->assertTrue(class_exists('Tools'));
		$this->assertTrue(class_exists('Penguin'));
		$this->assertTrue(class_exists('UserResource'));
		$this->assertTrue(class_exists('ProductsResource'));
		$this->assertTrue(class_exists('HttpMethods'));
		$this->assertTrue(class_exists('Resource'));
		$this->assertTrue(class_exists('RestApplication'));
		$this->assertTrue(interface_exists('Payment'));
    }

    /** @test */
    public function hasOptionShouldReturnFalseWhenOptionNotPresent() {
        $this->assertFalse($this->application->hasOption('foo'));
    }

    /** @test */
    public function hasOptionShouldReturnTrueWhenOptionPresent() {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function getOptionShouldReturnNullWhenOptionNotPresent() {
        $this->assertNull($this->application->getOption('foo'));
    }

    /** @test */
    public function getOptionShouldReturnOptionValue() {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertEquals($options['foo'], $application->getOption('foo'));
    }

    /** @test */
    public function passingIncludePathOptionShouldModifyIncludePath() {
        $expected = dirname(__FILE__) . '/_files';
        $this->application->setOptions(array(
            'includePaths' => array(
                $expected,
            ),
        ));
        $test = get_include_path();
        $this->assertContains($expected, $test);
    }

    /** @test */
    public function passingPhpSettingsShouldSetsIniValues() {
        $this->iniOptions[] = 'y2k_compliance';
        $orig     = ini_get('y2k_compliance');
        $expected = $orig ? 0 : 1;
        $this->application->setOptions(array(
            'phpSettings' => array(
                'y2k_compliance' => $expected,
            ),
        ));
        $this->assertEquals($expected, ini_get('y2k_compliance'));
    }

    /** @test */
    public function passingPhpSettingsAsArrayShouldConstructDotValuesAndSetRelatedIniValues() {
        $this->iniOptions[] = 'date.default_latitude';
        $orig     = ini_get('date.default_latitude');
        $expected = '1.234';
        $this->application->setOptions(array(
            'phpSettings' => array(
                'date' => array(
                    'default_latitude' => $expected,
                ),
            ),
        ));
        $this->assertEquals($expected, ini_get('date.default_latitude'));
    }

    /**
     * @test
     * @expectedException RestException
     */
    public function passingInvalidOptionsArgumentToConstructorShouldRaiseException() {
        $application = new RestApplication('testing', new stdClass());
    }

    /** @test */
    public function passingStringIniConfigPathOptionToConstructorShouldLoadOptions() {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.ini');
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingStringXmlConfigPathOptionToConstructorShouldLoadOptions() {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.xml');
        $this->assertTrue($application->hasOption('foo'));
    }

	/** @test */
    public function passingStringPhpConfigPathOptionToConstructorShouldLoadOptions() {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.php');
        $this->assertTrue($application->hasOption('foo'));
    }

	/** @test */
    public function passingStringIncConfigPathOptionToConstructorShouldLoadOptions() {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.inc');
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingArrayOptionsWithConfigKeyShouldLoadOptions() {
        $application = new RestApplication('testing', array('bar' => 'baz', 'config' => dirname(__FILE__) . '/config/appconfig.ini'));
        $this->assertTrue($application->hasOption('foo'));
        $this->assertTrue($application->hasOption('bar'));
    }

    /**
     * @test
     * @expectedException RestException
     */
    public function passingInvalidStringOptionToConstructorShouldRaiseException() {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig');
    }

    /** @test */
    public function passingZendConfigToConstructorShouldLoadOptions() {
        $config = new Zend_Config_Ini(dirname(__FILE__) . '/config/appconfig.ini', 'testing');
        $application = new RestApplication('testing', $config);
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingArrayOptionsToConstructorShouldLoadOptions() {
        $config = new Zend_Config_Ini(dirname(__FILE__) . '/config/appconfig.ini', 'testing');
        $application = new RestApplication('testing', $config->toArray());
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function optionsShouldRetainOriginalCase() {
        $options = array(
            'pluginPaths' => array(
                'RestApplication_Test_Path' => dirname(__FILE__),
            ),
            'Resources' => array(
                'foo' => array(),
                'Bar' => array(
                    'baseUrl'             => '/foo',
                    'moduleDirectory'     => dirname(__FILE__),
                ),
            ),
        );
        $this->application->setOptions($options);
        $setOptions = $this->application->getOptions();
        $this->assertSame(array_keys($options), array_keys($setOptions));
    }

    /** @test */
    public function setOptionsShouldProperlyMergeTwoConfigFileOptions() {
        $application = new RestApplication('production', dirname(__FILE__) . '/config/appconfig-1.ini');
        $options = $application->getOptions();
		$keys = array_keys($options);
		sort($keys);
        $this->assertEquals(array('config', 'includePaths'), $keys);
    }

    /** @test */
    public function hasOptionShouldTreatOptionKeysAsCaseInsensitive() {
        $application = new RestApplication('production', array(
            'fooBar' => 'baz',
        ));
        $this->assertTrue($application->hasOption('FooBar'));
    }

    /** @test */
    public function getOptionShouldTreatOptionKeysAsCaseInsensitive() {
        $application = new RestApplication('production', array(
            'fooBar' => 'baz',
        ));
        $this->assertEquals('baz', $application->getOption('FooBar'));
    }

    /** @test */
    public function optionsCanHandleMultipleConfigFiles() {
        $application = new RestApplication('testing', array(
            'config' => array(
                dirname(__FILE__) . '/config/appconfig-3.ini',
                dirname(__FILE__) . '/config/appconfig-4.ini'
                )
            )
        );
        
        $this->assertEquals('baz', $application->getOption('foo'));
    }

    protected function _runApplication($uri, $method) {
        $request = new HttpRequest(array('REQUEST_URI' => $uri, 'REQUEST_METHOD' => $method));
		return $this->application->run($request);
    }
    
    protected function _assertResponse($response, $expectedCode, $expectedContent = null) {
        $this->assertEquals($expectedCode, $response->getResponseCode());
        if (null != $content) {
            $this->assertEquals($expectedContent, $response->getContent());
        }
    }

	/** @test */
	public function runWithUnknownUriInRequestShouldReturn404Error() {
		$response = $this->_runApplication("/unknownUri", HttpMethods::GET);
		$this->_assertResponse($response, HttpResponseCodes::HTTP_NOT_FOUND);
	}

	/** @test */
	public function runGetMethodWithCorrectBasicUriShouldReturn200() {
		$response = $this->_runApplication("/users", HttpMethods::GET);
		$this->_assertResponse($response, HttpResponseCodes::HTTP_OK, "Users list");

		$response = $this->_runApplication("/categories", HttpMethods::GET);
		$this->_assertResponse($response, HttpResponseCodes::HTTP_OK, "Categories list");

		$response = $this->_runApplication("/categories-list", HttpMethods::GET);
		$this->_assertResponse($response, HttpResponseCodes::HTTP_OK, "Categories list");

		$response = $this->_runApplication("/liste-des-categories", HttpMethods::GET);
		$this->_assertResponse($response, HttpResponseCodes::HTTP_OK, "Categories list");
	}
}
