<?php

class Test extends PHPUnit_Framework_TestCase {

    /** @test */
    public function myTest() {
		if (include('vars.php')) {
			echo 'OK';
		}
		else {
			echo 'KO';
		}
	}
}
