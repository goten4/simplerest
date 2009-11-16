<?php
require_once 'Rest/Application.php';
 
class ApplicationTest extends PHPUnit_Framework_TestCase {

    public function testRecordingEnvironment()
    {
		$application = new RestApplication("development");
		$this->assertNotNull($application);
        $this->assertEquals("development", $application->getEnvironment());
    }
}
?>