<?php

/**
 * Mime types
 * 
 * @package simplerest.http
 * @author  Emmanuel Bouton
 */
class MimeTypes
{
    protected static $_mapFormatToMime;
    protected static $_mapMimeToFormat;

    public static function init()
    {
		self::$_mapFormatToMime = array(
		                Formats::HTML => array('text/html', 'application/xhtml+xml'),
		                Formats::XML  => array('application/xml', 'text/xml', 'application/x-xml'),
		                Formats::JSON => array('application/json', 'text/x-json','application/jsonrequest'),
		                Formats::JS   => array('text/javascript', 'application/javascript', 'application/x-javascript'),
		                Formats::CSS  => 'text/css',
		                Formats::RSS  => 'application/rss+xml',
		                Formats::YAML => array('application/x-yaml', 'text/yaml'),
		                Formats::ATOM => 'application/atom+xml',
		                Formats::TEXT => 'text/plain',
		                Formats::PNG  => 'image/png',
		                Formats::JPG  => 'image/jpeg', 'image/pjpeg',
		                Formats::GIF  => 'image/gif',
		                Formats::CSV  => 'text/csv');
		self::$_mapMimeToFormat = self::_revertMap(self::$_mapFormatToMime);
    }
    
    public static function _revertMap($map)
    {
        $revertedMap = array();
        foreach ($map as $format => $mimes) {
            if (is_array($mimes)) {
                foreach ($mimes as $mime) {
                    $revertedMap[$mime] = $format;
                }
            }
            else {
                $revertedMap[$mimes] = $format;
            } 
        }
        return $revertedMap;
    }
    
    public static function getMimeType($format)
    {
        if (is_array(self::$_mapFormatToMime[$format])) {
            return self::$_mapFormatToMime[$format][0];
        }
        return self::$_mapFormatToMime[$format];
    }
    
    public static function getFormat($mimeType)
    {
        return self::$_mapMimeToFormat[$mimeType];
    }
}
MimeTypes::init();
