<?php

/** RestApplication */
require_once 'Rest/Application.php';
require_once 'Rest/Exception.php';

class RestApplicationTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        // Store original include_path
        $this->includePath = get_include_path();
        $this->application = new RestApplication('testing');
        $this->iniOptions = array();
    }

    public function tearDown()
    {
        foreach ($this->iniOptions as $key) {
            ini_restore($key);
        }
    }

    /** @test */
    public function constructorShouldSetsEnvironment()
    {
        $this->assertEquals('testing', $this->application->getEnvironment());
    }

    /** @test */
    public function constructorShouldSetOptionsWhenProvided()
    {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertEquals($options, $application->getOptions());
    }

    /** @test */
    public function hasOptionShouldReturnFalseWhenOptionNotPresent()
    {
        $this->assertFalse($this->application->hasOption('foo'));
    }

    /** @test */
    public function hasOptionShouldReturnTrueWhenOptionPresent()
    {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function getOptionShouldReturnNullWhenOptionNotPresent()
    {
        $this->assertNull($this->application->getOption('foo'));
    }

    /** @test */
    public function getOptionShouldReturnOptionValue()
    {
        $options = array(
            'foo' => 'bar',
            'bar' => 'baz',
        );
        $application = new RestApplication('testing', $options);
        $this->assertEquals($options['foo'], $application->getOption('foo'));
    }

    /** @test */
    public function passingIncludePathOptionShouldModifyIncludePath()
    {
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
    public function passingPhpSettingsShouldSetsIniValues()
    {
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
    public function passingPhpSettingsAsArrayShouldConstructDotValuesAndSetRelatedIniValues()
    {
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
    public function passingInvalidOptionsArgumentToConstructorShouldRaiseException()
    {
        $application = new RestApplication('testing', new stdClass());
    }

    /** @test */
    public function passingStringIniConfigPathOptionToConstructorShouldLoadOptions()
    {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.ini');
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingStringXmlConfigPathOptionToConstructorShouldLoadOptions()
    {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig.xml');
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingArrayOptionsWithConfigKeyShouldLoadOptions()
    {
        $application = new RestApplication('testing', array('bar' => 'baz', 'config' => dirname(__FILE__) . '/config/appconfig.ini'));
        $this->assertTrue($application->hasOption('foo'));
        $this->assertTrue($application->hasOption('bar'));
    }

    /**
     * @test
     * @expectedException RestException
     */
    public function passingInvalidStringOptionToConstructorShouldRaiseException()
    {
        $application = new RestApplication('testing', dirname(__FILE__) . '/config/appconfig');
    }

    /** @test */
    public function passingZendConfigToConstructorShouldLoadOptions()
    {
        $config = new Zend_Config_Ini(dirname(__FILE__) . '/config/appconfig.ini', 'testing');
        $application = new RestApplication('testing', $config);
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function passingArrayOptionsToConstructorShouldLoadOptions()
    {
        $config = new Zend_Config_Ini(dirname(__FILE__) . '/config/appconfig.ini', 'testing');
        $application = new RestApplication('testing', $config->toArray());
        $this->assertTrue($application->hasOption('foo'));
    }

    /** @test */
    public function optionsShouldRetainOriginalCase()
    {
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
    public function setOptionsShouldProperlyMergeTwoConfigFileOptions()
    {
        $application = new RestApplication('production', dirname(__FILE__) . '/config/appconfig-1.ini');
        $options = $application->getOptions();
        $this->assertEquals(array('config', 'includePaths'), array_keys($options));
    }

    /** @test */
    public function hasOptionShouldTreatOptionKeysAsCaseInsensitive()
    {
        $application = new RestApplication('production', array(
            'fooBar' => 'baz',
        ));
        $this->assertTrue($application->hasOption('FooBar'));
    }

    /** @test */
    public function getOptionShouldTreatOptionKeysAsCaseInsensitive()
    {
        $application = new RestApplication('production', array(
            'fooBar' => 'baz',
        ));
        $this->assertEquals('baz', $application->getOption('FooBar'));
    }

	/** @test */
	public function runWithCorrectUriInRequestShouldCallAssociatedResource()
	{
		$_SERVER['REQUEST_URI'] = "/user";
		$this->application->run();
	}
}

