<?php

namespace Core;

use JetBrains\PhpStorm\NoReturn;

class Kernel
{
	#[NoReturn] public static function web()
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
		
		Http::received_input();
		Routes::create();
	}
}
