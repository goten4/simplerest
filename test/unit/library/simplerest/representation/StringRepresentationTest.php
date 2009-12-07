<?php

class StringRepresentationTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function getContentShouldRetrieveTheStringGivenToTheConstructor()
    {
        $representation = new StringRepresentation("Hello guys and girls !");
        $this->assertEquals("Hello guys and girls !", $representation->getContent());
    }
}
