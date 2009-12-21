<?php

class LanguagesTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function getLabelShouldReturnTheLabelInTheSpecifiedLanguage()
    {
        $this->assertEquals("العربية", Languages::getLabel(Languages::AR));
        $this->assertEquals("english", Languages::getLabel(Languages::EN));
        $this->assertEquals("esperanto", Languages::getLabel(Languages::EO));
        $this->assertEquals("español", Languages::getLabel(Languages::ES));
        $this->assertEquals("français", Languages::getLabel(Languages::FR));
        $this->assertEquals("italiano", Languages::getLabel(Languages::IT));
        $this->assertEquals("日本語", Languages::getLabel(Languages::JA));
        $this->assertEquals("한국어", Languages::getLabel(Languages::KO));
        $this->assertEquals("nederlands", Languages::getLabel(Languages::NL));
        $this->assertEquals("polski", Languages::getLabel(Languages::PL));
        $this->assertEquals("português", Languages::getLabel(Languages::PT));
        $this->assertEquals("pусский", Languages::getLabel(Languages::RU));
        $this->assertEquals("slovenčina", Languages::getLabel(Languages::SK));
        $this->assertEquals("slovenščina", Languages::getLabel(Languages::SL));
        $this->assertEquals("türkçe", Languages::getLabel(Languages::TR));
        $this->assertEquals("中文", Languages::getLabel(Languages::ZH));
    }
    
    /** @test */
    public function isKnownLanguageShouldReturnFalseForUnknownLanguage()
    {
        $this->assertFalse(Languages::isKnownLanguage('unknownLanguage'));
    }
    
    /** @test */
    public function isKnownLanguageShouldReturnTrueForKnownLanguages()
    {
        $this->assertTrue(Languages::isKnownLanguage('fr'));
        $this->assertTrue(Languages::isKnownLanguage('en'));
        $this->assertTrue(Languages::isKnownLanguage('eo'));
        $this->assertTrue(Languages::isKnownLanguage('es'));
        $this->assertTrue(Languages::isKnownLanguage('fr'));
        $this->assertTrue(Languages::isKnownLanguage('it'));
        $this->assertTrue(Languages::isKnownLanguage('ja'));
        $this->assertTrue(Languages::isKnownLanguage('ko'));
        $this->assertTrue(Languages::isKnownLanguage('nl'));
        $this->assertTrue(Languages::isKnownLanguage('pl'));
        $this->assertTrue(Languages::isKnownLanguage('pt'));
        $this->assertTrue(Languages::isKnownLanguage('ru'));
        $this->assertTrue(Languages::isKnownLanguage('sk'));
        $this->assertTrue(Languages::isKnownLanguage('sl'));
        $this->assertTrue(Languages::isKnownLanguage('zh'));
    }
}
