<?php

/**
 * Formats
 * 
 * @package simplerest.http
 * @author  Emmanuel Bouton
 */
class Formats
{
	const HTML = 'html';
	const XML  = 'xml';
	const JSON = 'json';
	const JS   = 'js';
	const CSS  = 'css';
	const RSS  = 'rss';
	const YAML = 'yml';
	const ATOM = 'atom';
	const TEXT = 'text';
	const PNG  = 'png';
	const JPG  = 'jpg';
	const GIF  = 'gif';
	const PDF  = 'pdf';
	const DOC  = 'doc';
	const XLS  = 'xls';
	const CSV  = 'csv';
	
	public static function getList()
	{
	    $reflection = new ReflectionClass('Formats');
		return $reflection->getConstants();
	}
}
