<?php
require 'Settings.php';

class Database {

	private $connection;
	
	// Define contstants
	const TITLE = 1;
	const NOTE = 2;
	const DATE = 3;
	
	public function __construct() {
		// Set up the connection
		try {
		
		$host 				= db_host;
		$dbname 			= db_name;
		$dsn 				= "mysql:host=$host;dbname=$dbname";
		$this->connection 	= new PDO($dsn, db_username, db_password);
		
		} catch (PDOException $e) {
			echo "Cannot connect to database";
		}
	}
	
	public function getConnection() {
		return $this->connection;
	}
	
	public function add($title, $note) {
		try {
		// Count the number of notes
		$nquery = $this->connection->query("SELECT COUNT(nid) FROM notes");
		$nid;
		foreach ($nquery as $value)
			$nid = $value[0];
		$nid++;
		
		$values = array($nid, $title, $note, time());
		$count = $this->connection->exec("INSERT INTO notes (nid, title, note, date) VALUES ('$values[0]', '$values[1]', '$values[2]', '$values[3]')");
		
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		return $nid;
	}
	
	public function get($nid, $id) {
		$result;
		
		switch ($id) {
			case 1:
				$query = $this->connection->query("SELECT title FROM notes WHERE nid = '$nid'");
				foreach ($query as $value)
					$result = $value[0];
				break;
					
			case 2:
				$query = $this->connection->query("SELECT note FROM notes WHERE nid = '$nid'");
				foreach ($query as $value)
					$result = $value[0];
				break;
					
			case 3:
				$query = $this->connection->query("SELECT date FROM notes WHERE nid = '$nid'");
				foreach ($query as $value)
					$result = $value[0];
				$result = date('l - F j, Y', $result);
				break;
		
		}
		
		return $result;
	}
	
	public function __destruct() {
		$this->connection = null;
	}

}