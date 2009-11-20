<?php

// [Informational 1xx]
define("HTTP_CONTINUE", 100);
define("HTTP_SWITCHING_PROTOCOLS", 101);
// [Successful 2xx]
define("HTTP_OK", 200);
define("HTTP_CREATED", 201);
define("HTTP_ACCEPTED", 202);
define("HTTP_NONAUTHORITATIVE_INFORMATION", 203);
define("HTTP_NO_CONTENT", 204);
define("HTTP_RESET_CONTENT", 205);
define("HTTP_PARTIAL_CONTENT", 206);
// [Redirection 3xx]
define("HTTP_MULTIPLE_CHOICES", 300);
define("HTTP_MOVED_PERMANENTLY", 301);
define("HTTP_FOUND", 302);
define("HTTP_SEE_OTHER", 303);
define("HTTP_NOT_MODIFIED", 304);
define("HTTP_USE_PROXY", 305);
define("HTTP_UNUSED", 306);
define("HTTP_TEMPORARY_REDIRECT", 307);
// [Client Error 4xx]
define("errorCodesBeginAt", 400);
define("HTTP_BAD_REQUEST", 400);
define("HTTP_UNAUTHORIZED ", 401);
define("HTTP_PAYMENT_REQUIRED", 402);
define("HTTP_FORBIDDEN", 403);
define("HTTP_NOT_FOUND", 404);
define("HTTP_METHOD_NOT_ALLOWED", 405);
define("HTTP_NOT_ACCEPTABLE", 406);
define("HTTP_PROXY_AUTHENTICATION_REQUIRED", 407);
define("HTTP_REQUEST_TIMEOUT", 408);
define("HTTP_CONFLICT", 409);
define("HTTP_GONE", 410);
define("HTTP_LENGTH_REQUIRED", 411);
define("HTTP_PRECONDITION_FAILED", 412);
define("HTTP_REQUEST_ENTITY_TOO_LARGE", 413);
define("HTTP_REQUEST_URI_TOO_LONG", 414);
define("HTTP_UNSUPPORTED_MEDIA_TYPE", 415);
define("HTTP_REQUESTED_RANGE_NOT_SATISFIABLE", 416);
define("HTTP_EXPECTATION_FAILED", 417);
// [Server Error 5xx]
define("HTTP_INTERNAL_SERVER_ERROR", 500);
define("HTTP_NOT_IMPLEMENTED", 501);
define("HTTP_BAD_GATEWAY", 502);
define("HTTP_SERVICE_UNAVAILABLE", 503);
define("HTTP_GATEWAY_TIMEOUT", 504);
define("HTTP_VERSION_NOT_SUPPORTED", 505);
	
/**
 * ResponseCodes provides named constants for
 * HTTP protocol status codes. Written for the
 * Recess PHP Framework (http://www.recessframework.org/)
 * 
 * @author Kris Jordan <krisjordan@gmail.com>
 * @copyright 2008, 2009 Kris Jordan
 * @package Recess PHP Framework
 * @license MIT
 * @link http://www.recessframework.org/
 */
class HttpResponseCodes {
	
    private static $messages = array(
	    // [Informational 1xx]
	    100=>'100 Continue',
	    101=>'101 Switching Protocols',
	    // [Successful 2xx]
	    200=>'200 OK',
	    201=>'201 Created',
	    202=>'202 Accepted',
	    203=>'203 Non-Authoritative Information',
	    204=>'204 No Content',
	    205=>'205 Reset Content',
	    206=>'206 Partial Content',
	    // [Redirection 3xx]
	    300=>'300 Multiple Choices',
	    301=>'301 Moved Permanently',
	    302=>'302 Found',
	    303=>'303 See Other',
	    304=>'304 Not Modified',
	    305=>'305 Use Proxy',
	    306=>'306 (Unused)',
	    307=>'307 Temporary Redirect',
	    // [Client Error 4xx]
	    400=>'400 Bad Request',
	    401=>'401 Unauthorized',
	    402=>'402 Payment Required',
	    403=>'403 Forbidden',
	    404=>'404 Not Found',
	    405=>'405 Method Not Allowed',
	    406=>'406 Not Acceptable',
	    407=>'407 Proxy Authentication Required',
	    408=>'408 Request Timeout',
	    409=>'409 Conflict',
	    410=>'410 Gone',
	    411=>'411 Length Required',
	    412=>'412 Precondition Failed',
	    413=>'413 Request Entity Too Large',
	    414=>'414 Request-URI Too Long',
	    415=>'415 Unsupported Media Type',
	    416=>'416 Requested Range Not Satisfiable',
	    417=>'417 Expectation Failed',
	    // [Server Error 5xx]
	    500=>'500 Internal Server Error',
	    501=>'501 Not Implemented',
	    502=>'502 Bad Gateway',
	    503=>'503 Service Unavailable',
	    504=>'504 Gateway Timeout',
	    505=>'505 HTTP Version Not Supported'
    );

	public static function getMessageForCode($code) {
		return self::$messages[$code];
	}
	
	public static function isError($code) {
		return is_numeric($code) && $code >= HTTP_BAD_REQUEST;
	}
	
	public static function canHaveBody($code) {
		return
			// True if not in 100s
			($code < HTTP_CONTINUE || $code >= HTTP_OK)
			&& // and not 204 NO CONTENT
			$code != HTTP_NO_CONTENT
			&& // and not 304 NOT MODIFIED
			$code != HTTP_NOT_MODIFIED;
	}
}

