<?php

namespace Core;
use Closure;
use JetBrains\PhpStorm\NoReturn;

class Routes
{
	private static function perform_route_check(string $method, string $route): bool
	{
		if ($_SERVER['REQUEST_METHOD'] !== $method)
			return false;
		if ($GLOBALS['Http'] !== $route)
			return false;
		return true;
	}
	public static function get(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::perform_route_check('GET', $route))
			return;

		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	public static function post(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::perform_route_check('POST', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	#[NoReturn] public static function catch_all()
	{
		http_response_code(404);
		echo '<strong style="font-size: xxx-large">404 not found</strong>';
		die();
	}
	
	#[NoReturn] public static function create()
	{
		require '../routes/web.php';
		self::catch_all();
	}
	
	private static function call($action)
	{
		$action = explode('@', $action);
		$action[0] = 'App\\Controllers\\' . $action[0];
		
		$obj = new $action[0]();
		call_user_func([$obj, $action[1]]);
	}
}