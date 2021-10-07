<?php

namespace App\Helpers;

class Arr
{
	public static function isAssoc(array $array)
	{
		if(!is_array($array) || $array == [])
		{
			return false;
		}

		return array_key_exists($array) != range(0, count($array) - 1);
	}

	public static function dump($data)
	{
		if(is_string($data))
		{
			return str_split($data);
		}

		if(is_object($data))
		{
			return json_decode(json_encode($data), true);
		}

		return null;
	}

	public static function first($array)
	{
		return $array[array_keys($array)[0]];
	}

	public static function last($array)
	{
		return $array[array_keys($array)[count($array) - 1]];
	}

	public static function get(array $array, string $key, $default = NULL)
	{

		if (is_null($key)) {

			return $array;

		}

		if (isset($array[$key])) {

			return $array[$key];

		}

		foreach (explode('.', $key) as $segment) {

			if (!is_array($array) || !array_key_exists($segment, $array)) {

				return $default;

			}

			$array = $array[$segment];

		}

		return $array;

	}

}