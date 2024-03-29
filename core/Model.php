<?php

namespace Core;

use mysqli;

class Model
{
	private string $query;
	private mysqli|null $sql;
	protected string $table;
	protected int $db = 0;
	private Database $connect;
	
	/* __construct database connection and table name */
	public function __construct()
	{
		$this->connect = new Database($this->db);
		$this->sql = $this->connect->getSql();
		$this->sql->query('SET CHARACTER SET utf8');
	}
	
	public function select(string|array $args = '*'): static
	{
		if (is_array($args)) {
			$this->query = 'SELECT ' . implode(',', $args) . ' FROM ' . $this->table . ' ';
		} else {
			$this->query = 'SELECT ' . $args . ' FROM ' . $this->table . ' ';
		}
		return $this;
	}
	
	public function where(string|array $left, string $cond = '=', string|int $var = null): static
	{
		if (is_array($left)) {
			$buildQuery = http_build_query($left, null, ',');
			$buildQuery = str_replace(':', '=', $buildQuery);
			$buildQuery = str_replace(',', ' AND ', $buildQuery);
			$buildQuery = str_replace('%22', '"', $buildQuery);
			$buildQuery = str_replace('%27', "'", $buildQuery);
			
			if (str_contains($this->query, 'WHERE'))
				$this->query .= ' OR ' . $buildQuery . ' ';
			else
				$this->query .= 'WHERE ' . $buildQuery;
		} else {
			$this->query .= 'WHERE ' . $left . $cond . $var . ' ';
		}
		return $this;
	}
	
	public function get(): object|array|bool
	{
		$array = [];

		$r = $this->sql->query($this->query);
		while ($rows = $r->fetch_assoc()) {
			$array[] = $rows;
			unset($rows);
		}
		$r->free_result();
		return $array;
	}
	
	public function getRow(): object|array|null
	{
		$rs = $this->sql->query($this->query);
		return $rs?->fetch_assoc();
	}

	public function getVar($var): bool
	{
		$rs = $this->sql->query($this->query);
		$rs->fetch_assoc();
		return $rs->field_seek($var);
	}
	
	public function update(array|string $args): static
	{
		$this->query = "UPDATE $this->table SET ";
		if (is_array($args)) {
			$buildQuery = http_build_query($args, null, ',');
			$buildQuery = str_replace(':', '=', $buildQuery);
			$buildQuery = str_replace(',', ',', $buildQuery);
			$buildQuery = str_replace('%22', '"', $buildQuery);
			$buildQuery = str_replace('+', " ", $buildQuery);
			$buildQuery = str_replace('%27', "'", $buildQuery);
			$buildQuery = str_replace('%2B', "+", $buildQuery);
			$this->query .= $buildQuery . ' ';
			
		} else {
			$this->query .= $args . ' ';
		}
		return $this;
	}
	
	public function insert(array|string $args, string $cols = null): static
	{
		$this->query = "INSERT INTO $this->table ($cols) VALUES (";
		
		if (is_array($args)) {
			$buildQuery = http_build_query($args, null, ',');
			$buildQuery = str_replace(':', '=', $buildQuery);
			$buildQuery = str_replace(',', ',', $buildQuery);
			$buildQuery = str_replace('%22', '"', $buildQuery);
			$buildQuery = str_replace('+', " ", $buildQuery);
			$buildQuery = str_replace('%27', "'", $buildQuery);
			$buildQuery = str_replace('%2B', "+", $buildQuery);
			$this->query .= $buildQuery . ")";
		} else {
			$this->query .= $args . ")";
		}
		return $this;
	}
	
	public function execute(): bool
	{
		return $this->sql->query($this->query);
	}
}
