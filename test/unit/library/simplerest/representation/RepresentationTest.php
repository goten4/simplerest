<?php

class MockRepresentation extends Representation
{
    protected function write()
    {
        echo "Hello world !";
    }
}


class RepresentationTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function getContentShouldRetrieveContentWrittenInStandardOutput()
    {
        $representation = new MockRepresentation();
        $this->assertEquals("Hello world !", $representation->getContent());
    }

    /** @test */
    public function getContentShouldNotWriteContentToStandardOutput()
    {
        ob_start();
        $representation = new MockRepresentation();
        $representation->getContent();
        $this->assertEquals("", ob_get_contents());
        ob_end_clean();
    }
}
