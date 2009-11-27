<?php

class ResourceFileTest extends PHPUnit_Framework_TestCase {

    /**
	 * @test
     * @expectedException RestException
	 */
    public function loadingNullShouldRaiseException() {
		ResourceFile::load(null);
    }

    /**
	 * @test
     * @expectedException RestException
	 */
    public function loadingUnsecuredFileShouldRaiseException() {
		ResourceFile::load('bad<script>alert("coucou")</script>file.php');
    }

    /**
	 * @test
     * @expectedException RestException
	 */
    public function loadingDirectoryShouldRaiseException() {
		ResourceFile::load(TEST_BASE_PATH . '/application/resources/');
    }

    /**
	 * @test
     * @expectedException RestException
	 */
    public function loadingCsvUsersFileShouldRaiseException() {
		ResourceFile::load(TEST_BASE_PATH . '/application/resources/Users.csv');
    }

    /**
	 * @test
     * @expectedException RestException
	 */
	public function loadingPhpFileWithoutDefinitionOfAResourceBaseChildClassShouldRaiseException() {
		ResourceFile::load(TEST_BASE_PATH . '/application/resources/index.php');
	}

    /** @test */
	public function loadingUsersResourceFileShouldWorkAndReturnTheClassName() {
		$class = ResourceFile::load(TEST_BASE_PATH . '/application/resources/Users.php');
		$this->assertEquals("ResourceUsers", $class);
		$this->assertTrue(class_exists($class));
	}
}
