<?php

namespace Core;

use Closure;

class Routes
{
	private static function performRouteCheck(string $method, string $route): bool
	{
		if ($_SERVER['REQUEST_METHOD'] !== $method)
			return false;
		if (explode('?', $GLOBALS['Http'])[0] !== $route)
			return false;
		return true;
	}
	
	public static function get(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::performRouteCheck('GET', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	public static function post(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::performRouteCheck('POST', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	public static function put(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::performRouteCheck('PUT', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	public static function patch(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::performRouteCheck('PATCH', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	public static function delete(string $route, string $action = '', Closure $closure = null)
	{
		if (!self::performRouteCheck('DELETE', $route))
			return;
		
		if (!$closure)
			self::call($action);
		else
			$closure();
		die();
	}
	
	private static function options()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS')
			return;
		header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
		//if you need special headers
		//header('Access-Control-Allow-Headers: x-requested-with');
		http_response_code(200);
		die();
	}
	
	private static function catchAll()
	{
		Http::sendJson(['Error' => '404 not found'], 404);
		die();
	}
	
	public static function create()
	{
		self::options();
		require '../routes/api.php';
		self::catchAll();
	}
	
	private static function call($action)
	{
		$action = explode('@', $action);
		$action[0] = 'App\\Controllers\\' . $action[0];
		
		$obj = new $action[0]();
		call_user_func([$obj, $action[1]]);
	}
}
