<?php

namespace Core;

use http\Header;

class Http
{
	public static function receivedInput(): void
	{
		if (empty($_POST) && $json = file_get_contents('php://input')) {
			$json = json_decode($json, true);
			$_POST = $json;
		}
	}

	public static function sendJson(mixed $data, int $code = 200): void
	{
		$data['time'] = Bench::endTime($GLOBALS['start']);

		header('Content-Length: ' . strlen(json_encode($data)));
		header('Content-Type: application/json; charset=utf-8');

		http_response_code($code);

		echo json_encode($data);
	}
}
