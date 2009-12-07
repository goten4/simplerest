<?php

class MimeTypeTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function xmlMimeTypeShouldBeApplicationXml()
    {
        $this->assertEquals("application/xml", MimeTypes::getMimeType(Formats::XML));
    }

    /** @test */
    public function pngMimeTypeShouldBeImagePng()
    {
        $this->assertEquals("image/png", MimeTypes::getMimeType(Formats::PNG));
    }

    /** @test */
    public function applicationXhtmlFormatShouldBeHtml()
    {
        $this->assertEquals(Formats::HTML, MimeTypes::getFormat('application/xhtml+xml'));
    }

    /** @test */
    public function textPlainFormatShouldBeText()
    {
        $this->assertEquals(Formats::TEXT, MimeTypes::getFormat('text/plain'));
    }
}
