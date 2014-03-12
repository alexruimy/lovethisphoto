<?php

// MySQL public functions 

class db
{

	private $host;
	private $username;
	private $password;
	private $db;


	public function __construct($db,$host="localhost",$username="root",$password="") 
	{
		mysql_connect($host,$username,$password);
		mysql_select_db($db);

	}

	//update
	public function u($table,$data,$where=null,$limit=null) 
	{
		$q = "UPDATE `" . $this->e($table) . "` SET ";
		$rc = 0;
		foreach ($data as $key=>$val) {
			$rc++;
			$key = $this->e($key);
			$val = $this->e($val);
			$q.= "`{$key}` = \"{$val}\"";
			if ($rc != count($data)) $q.= ", ";
		}

		if (is_array($where)) {
			$q.= " WHERE ";
			$rc = 0;
			foreach ($where as $key=>$val) {
				$rc++;
				$key = $this->e($key);
				$val = $this->e($val);
				$q.= "`{$key}` = \"{$val}\"";
				if ($rc != count($where)) $q.= " AND ";
			}
		}

		if ($limit) {
			$limit = $this->e($limit);
			$q.= " LIMIT {$limit}";
		}

		if ($this->q($q)) return true;

	}

	//insert
	public function i($table,$data,$ignore=false) 
	{
		$ig = ($ignore) ? "IGNORE" : "";
		$q = "INSERT {$ig} INTO `" . $this->e($table) . "` SET ";
		$rc = 0;
		foreach ($data as $key=>$val) {
			$rc++;
			$key = $this->e($key);
			$val = $this->e($val);
			$q.= "`{$key}` = \"{$val}\"";
			if ($rc != count($data)) $q.= ", ";
		}

		if ($this->q($q)) return mysql_insert_id();
	}

	//delete
	public function d($table,$where=null,$limit=null) 
	{
		$table = $this->e($table);
		$limit = $this->e($limit);

		$q = "DELETE FROM `$table` ";
		if (is_array($where)) {
			$q.= "WHERE ";
			$rc = 0;
			foreach ($where as $key=>$val) {
				$rc++;
				$key = $this->e($key);
				$val = $this->e($val);
				$q.= "`{$key}` = \"{$val}\"";
				if ($rc != count($where)) $q.= " AND ";
			}
		}

		if ($limit) $q.= " LIMIT {$limit}";

		return $this->q($q);
	//return $q;
	}

	public function q($q) 
	{
		return mysql_query($q) or die(mysql_error());
	}

	public function n($q) 
	{
		$r = mysql_query($q);
		return mysql_num_rows($r);
	}

	public function a($q) 
	{
		$r = mysql_query($q) or die(mysql_error());
		while ($row = mysql_fetch_assoc($r)) {
			$output[] = $row;
		}
		return $output;
	}

	public function e($str) 
	{
		return mysql_real_escape_string($str);
	}

}