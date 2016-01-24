<?php

namespace Libs;

/**
* Singleton
*/
class Session
{
	const UNSERIALIZE = true;
	
	private function __construct() {}

	public static function init()
	{
		session_start();
	}

	public static function set($key, $value = false)
	{
		$_SESSION[$key] = is_object($value) ? serialize($value) : $value;
	}

	public static function get($key, $unserialize = false)
	{
		if ($unserialize && isset($_SESSION[$key]))
			return unserialize($_SESSION[$key]);

		return $_SESSION[$key] ?? null;
	}

	public static function destroy()
	{
		session_destroy();
	}
}