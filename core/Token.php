<?php

namespace Core;

class Token
{
	private bool $activated;
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
	
	public function checkToken(string $token): void
	{
		$result = $this->performCheck($token);
		
		if ($result === null)
			die();
		$date = $result->fetch_assoc();
		if ($date['created_at'] < strtotime('-30 days')) {
			Http::sendJson(['error' => 'Token outdated, please renew it.'], 401);
			die();
		}
	}
	
	public function renewToken(string $token): void
	{
		if ($this->performCheck($token) === null)
			return;
		$table = self::TABLE;
		
		$this->driver->query("DELETE FROM $table WHERE token='$token'");
		
		$date = time();
		$token = uniqid(more_entropy: true);
		$sql = <<<EOF
			INSERT INTO tokens VALUES('$token',$date)
			EOF;
		if ($this->driver->query($sql)) {
			Http::sendJson(['success' => 'Token added with success', 'token' => $token]);
		} else {
			Http::sendJson(['error' => "Error happened when inserting into table token", 'error_msg' => $this->driver->error], 500);
		}
	}
	
	private function performCheck(string $token): \mysqli_result|null
	{
		if (!$this->activated)
			return null;
		if ($token === 'null') {
			Http::sendJson(['error' => 'Token empty'], 401);
			die();
		}
		
		$table = self::TABLE;
		$result = $this->driver->query("SELECT created_at FROM $table WHERE token='$token'");
		
		if ($result->num_rows !== 1) {
			Http::sendJson(['error' => "Token doesn't exist", 'error_msg' => $this->driver->error], 404);
			die();
		}
		
		return $result;
	}
}