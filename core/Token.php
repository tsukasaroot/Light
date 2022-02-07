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
		$this->driver = $this->database->get_sql();
		$table = self::TABLE;
		
		if ($this->driver->query("SHOW TABLES LIKE '$table'")->num_rows !== 1) {
			$sql = <<<EOF
			CREATE TABLE $table (
			    token VARCHAR(128) NOT NULL,
			    created_at bigint(11) NOT NULL
			)
			EOF;
			if (!$this->driver->query($sql)) {
				echo "Error upon creating $table: " . $this->driver->error . "\n";
			}
		}
	}
	
	public function create_token(string $token)
	{
		if (!$this->activated)
			return;
	}
	
	public function check_token()
	{
	
	}
}