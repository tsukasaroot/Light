<?php

use Core\Database;

class Migrator
{
	private Database $database;
	private \mysqli $driver;
	
	public function __construct()
	{
		$this->database = new Database(1);
		$this->driver = $this->database->get_sql();
	}
	
	public function do_migration()
	{
		/* TODO create migrations from migration file */
	}
	
	public function drop_a_table()
	{
		/* TODO drop a table before migration if written  */
	}
}