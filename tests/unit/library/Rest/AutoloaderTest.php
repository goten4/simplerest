<?php
require_once 'Rest/Autoloader.php';

class AutoloaderTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function getInstanceShouldReturnAutoloaderSingleton() {
		$this->assertTrue(is_a(Autoloader::getInstance(),'Autoloader'));
    }

	/** @test */
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
	
	/** @test */
	public function classesInAutoloaderBasePathShouldBeAutoloaded() {
		$autoloader = Autoloader::init(TEST_BASE_PATH . '/application/resources');
		$this->assertTrue(class_exists('ResourceUser'));
		$this->assertTrue(class_exists('ResourceUsers'));
		$this->assertTrue(class_exists('ResourceProduct'));
		$this->assertTrue(class_exists('ResourceProducts'));
	}
}
