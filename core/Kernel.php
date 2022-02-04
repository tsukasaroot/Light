<?php

namespace Core;

class Kernel
{
	public static function web()
	{
		if (empty($_SERVER['REQUEST_METHOD'])) {
			echo 'nope';
			die();
		}
		$request = $_SERVER['REQUEST_URI'];
		
		$GLOBALS['Http'] = $request;
		
		$env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/../.env');
		
		foreach ($env as $k => $v) {
			$GLOBALS['Database'][$k] = $v;
		}
		
		Http::receivedInput();
		Routes::create();
	}
}
