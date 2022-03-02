<?php

namespace Core;

use Memcache;
use Redis;

class Caching
{
	private Memcache $memcached;
	private Redis $redis;
	
	public bool $memcache_status = false;
	public bool $redis_status = false;
	
	public function __destruct()
	{
		// TODO: Implement __destruct() method.
	}
	
	public function __construct()
	{
		if (isset($GLOBALS['MEMCACHED_HOST']) && $GLOBALS['MEMCACHED_HOST']) {
			$this->memcached = new Memcache();
			if ($this->memcached->addServer($GLOBALS['MEMCACHED_HOST'], $GLOBALS['MEMCACHED_PORT'])) {
				$this->memcache_status = true;
			}
		}
		
		if (isset($GLOBALS['REDIS_HOST']) && $GLOBALS['REDIS_HOST']) {
			$this->redis = new Redis();
			if ($this->redis->connect($GLOBALS['REDIS_HOST'], intval($GLOBALS['REDIS_PORT']))) {
				if ($GLOBALS['REDIS_PASSWORD']) {
					$this->redis->auth($GLOBALS['REDIS_PASSWORD']);
				}
				$this->redis_status = true;
			}
		}
	}
	
	public function add(array $array = null, string $key = null, string $value = null): bool
	{
		$success = false;
		
		if ($array) {
			foreach ($array as $k => $item) {
				$success = $this->memcached->add($k, $item);
			}
		}
		
		if ($key && $value) {
			$success = $this->memcached->add($key, $value);
		}
		
		return $success;
	}
	
	public function get(array $array = null, string $key = null): array
	{
		$result_array = [];
		
		if ($array) {
			foreach ($array as $item) {
				$result_array[$item] = $this->memcached->get($item);
			}
		}
		
		if ($key)
			$result_array[$key] = $this->memcached->get($key);
		
		return $result_array;
	}
	
	public function delete(array $array = null, string $key = null)
	{
		if ($array) {
			foreach ($array as $item) {
				$this->memcached->delete($item);
			}
		}
		
		if ($key)
			$this->memcached->delete($key);
	}
	
	public function flush()
	{
		$this->memcached->flush();
	}
}