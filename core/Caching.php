<?php

namespace Core;

use Memcache;

class Caching
{
	private Memcache $memcached;
	public bool $status = false;
	
	public function __destruct()
	{
		// TODO: Implement __destruct() method.
	}
	
	public function __construct()
	{
		$this->memcached = new Memcache();
		if (!$this->memcached->addServer($GLOBALS['MEMCACHED_HOST'], $GLOBALS['MEMCACHED_PORT'])) {
			//Http::sendJson(['error' => 'Connection failed to Memcache server'], 500);
			return;
		}
		
		/*$this->memcached->add('test', 'success');
		$test = $this->memcached->get('test');
		if ($test !== 'success') {
			//Http::sendJson(['error' => 'Memcache test result not retrieve successfully'], 500);
			return;
		}
		if (!$this->memcached->delete('test')) {
			//Http::sendJson(['error' => "Memcache couldn't delete correctly the test value"], 500);
			return;
		}*/
		$this->status = true;
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
	
	public function get(array $array=null, string $key=null): array
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
	
	public function delete(array $array=null, string $key=null)
	{
		if ($array)
		{
			foreach ($array as $item) {
				$this->memcached->delete($item);
			}
		}
		
		if ($key)
			$this->memcached->delete($key);
	}
	
	public function append(array $array, string $key, string $value)
	{
		$this->memcached->append();
	}
}