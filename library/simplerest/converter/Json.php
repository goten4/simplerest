<?php

/**
* Json encoding / decoding class
*/
class Json
{
	protected static function hasAnIntegerRangeForKeys($var)
	{
	    return count(array_diff_key($var, range(0, count($var) - 1))) == 0;
	}
	
	protected static function isVector($var)
	{
		return is_array($var) && self::hasAnIntegerRangeForKeys($var);
	}

	protected static function isAssociative($var)
	{
		return is_array($var) && !self::hasAnIntegerRangeForKeys($var);
	}

	protected static function isEmptyArray($var)
	{
		return is_array($var) && empty($var);
	}

	public static function encode($valueToEncode)
	{
		if (is_object($valueToEncode)) {
			return $valueToEncode->toJson();
		}
		elseif (self::isEmptyArray($valueToEncode)) {
			return "[]";
		}
		elseif (self::isVector($valueToEncode)) {
			$jsonString = "[";
			foreach ($valueToEncode as $key => $value) {
				$jsonString .= self::encode($value) . ",";
			}
			return substr_replace($jsonString, "]", -1);
		}
		elseif (self::isAssociative($valueToEncode)) {
			$jsonString = "{";
			foreach ($valueToEncode as $key => $value) {
				$jsonString .= json_encode("$key") . ":";
				$jsonString .= self::encode($value) . ",";
			}
			return substr_replace($jsonString, "}", -1);
		}
	    return json_encode($valueToEncode);
	}
	
	public static function decode($valueToDecode)
	{
	    return json_decode($valueToDecode, true);
	}
}
