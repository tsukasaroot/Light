<?php

namespace Core;

class Token
{
	private bool $activated;
	private array $token_list;
	private \mysqli $driver;
	private Database $database;
	const TABLE = 'tokens';
	
	public function __construct()
	{
		$this->activated = $GLOBALS['authToken'] ?? false;
		if (!$this->activated)
			return;
		$this->database = new Database(1);
		$this->driver = $this->database->getSql();
		$table = self::TABLE;
		
		if ($this->driver->query("SHOW TABLES LIKE '$table'")->num_rows !== 1) {
			$sql = <<<EOF
			CREATE TABLE $table (
			    token VARCHAR(128) PRIMARY KEY UNIQUE NOT NULL,
			    created_at bigint(11) NOT NULL
			)
			EOF;
			if (!$this->driver->query($sql)) {
				echo "Error upon creating $table: " . $this->driver->error . "\n";
			}
		}
	}
	
	public function checkToken(string|null $token): bool
	{
		if (!$this->activated)
			return false;
		if (!$token) {
			Http::sendJson(['error' => 'Token empty']);
			die();
		}
		$table = self::TABLE;
		$result = $this->driver->query("SELECT created_at FROM $table WHERE token=$token");
		
		if ($result->num_rows === 1) {
			$date = $result->fetch_assoc();
			if ($date['created_at'] < strtotime('-30 days')) {
				Http::sendJson(['error' => 'Token outdated, please renew it.']);
				die();
			}
		}
		return true;
	}
	
	public function renewToken()
	{
	
	}
}