<?php
require_once 'simplerest/Autoloader.php';

/**
 * @runTestsInSeparateProcesses
 */
class AutoloaderTest extends PHPUnit_Framework_TestCase {

    /**
	 * @test
	 * @group autoload
	 */
    public function getInstanceShouldReturnAutoloaderSingleton() {
		$this->assertTrue(is_a(Autoloader::getInstance(),'Autoloader'));
    }

    /**
	 * @test
	 * @group autoload
	 */
	public function initWithValidPathShouldLoadPhpFilesWithClassDefinition() {
		$autoloader = Autoloader::init(TEST_BASE_PATH . '/application/resources');
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/ProductResource.php',
			$autoloader->getFilePath('ProductResource')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/ProductsResource.php',
			$autoloader->getFilePath('ProductsResource')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/UserResource.php',
			$autoloader->getFilePath('UserResource')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/UsersResource.php',
			$autoloader->getFilePath('UsersResource')
		);
	}
	
    /**
	 * @test
	 * @group autoload
	 */
	public function classesInAutoloaderBasePathShouldBeAutoloaded() {
		$autoloader = Autoloader::init(TEST_BASE_PATH . '/application/classes');
		$this->assertTrue(class_exists('Tools'));
		$this->assertTrue(class_exists('Penguin'));
	}
	
    /**
	 * @test
	 * @group autoload
	 */
	public function initWithArrayOfPathsShouldLoadPhpFilesOfAllThePaths() {
		$paths = array(TEST_BASE_PATH, LIBRARY_PATH);
		$autoloader = Autoloader::init($paths);
		$this->assertTrue(class_exists('Tools'));
		$this->assertTrue(class_exists('Penguin'));
		$this->assertTrue(class_exists('UserResource'));
		$this->assertTrue(class_exists('ProductsResource'));
		$this->assertTrue(class_exists('HttpMethods'));
		$this->assertTrue(class_exists('Resource'));
		$this->assertTrue(class_exists('RestApplication'));
		$this->assertTrue(interface_exists('Payment'));
	}
	
    /**
	 * @test
	 * @group autoload
	 */
	public function resourcesInAutoloaderBasePathShouldBeRecognisedByAnnotation() {
		$autoloader = Autoloader::init(TEST_BASE_PATH . '/application/resources');
		$resources = $autoloader->getResources();
		sort($resources);
		$this->assertSame(array('CategoriesResource', 'ProductResource', 'UserResource', 'UsersResource'), $resources);
	}
}
