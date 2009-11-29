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
			TEST_BASE_PATH . '/application/resources/Product.php',
			$autoloader->getFilePath('ResourceProduct')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/Products.php',
			$autoloader->getFilePath('ResourceProducts')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/User.php',
			$autoloader->getFilePath('ResourceUser')
		);
		$this->assertEquals(
			TEST_BASE_PATH . '/application/resources/Users.php',
			$autoloader->getFilePath('ResourceUsers')
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
		$this->assertTrue(class_exists('ResourceUser'));
		$this->assertTrue(class_exists('ResourceProducts'));
		$this->assertTrue(class_exists('HttpMethods'));
		$this->assertTrue(class_exists('ResourceBase'));
		$this->assertTrue(class_exists('SimpleRestApplication'));
		$this->assertTrue(interface_exists('Payment'));
	}
	
    /**
	 * @test
	 * @group autoload
	 */
	public function resourcesInAutoloaderBasePathShouldBeRecognisedByAnnotation() {
		$autoloader = Autoloader::init(TEST_BASE_PATH . '/application/resources');
		$resources = $autoloader->getResources();
		asort($resources);
		$this->assertSame(array('ResourceCategories', 'ResourceProduct', 'ResourceUser', 'ResourceUsers'), $resources);
	}
}
