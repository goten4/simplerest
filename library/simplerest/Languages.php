<?php

/**
 * Provides constants for Languages
 * 
 * @author Emmanuel Bouton
 * @package simplerest
 */
abstract class Languages
{
	const AR = 'ar';
	const EN = 'en';
	const EO = 'eo';
	const ES = 'es';
	const FR = 'fr';
	const IT = 'it';
	const JA = 'ja';
	const KO = 'ko';
	const NL = 'nl';
	const PL = 'pl';
	const PT = 'pt';
	const RU = 'ru';
	const SL = 'sl';
	const SK = 'sk';
	const TR = 'tr';
	const ZH = 'zh';

	private static $_labels = array(
		self::AR => 'العربية',
		self::EN => 'english',
		self::EO => 'esperanto',
		self::ES => 'español',
		self::FR => 'français',
		self::IT => 'italiano',
		self::JA => '日本語',
		self::KO => '한국어',
		self::NL => 'nederlands',
		self::PL => 'polski',
		self::PT => 'português',
		self::RU => 'pусский',
		self::SK => 'slovenčina',
		self::SL => 'slovenščina',
		self::TR => 'türkçe',
		self::ZH => '中文'
	);
	
	public static function getLabel($language)
	{
		return self::$_labels[$language];
	}
	
	public static function isKnownLanguage($language)
	{
	    return array_key_exists($language, self::$_labels);
	}
}
