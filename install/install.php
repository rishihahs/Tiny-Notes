<?php
require '../database/Database.php';

try {

// SQL Statement to create table
$sql = "CREATE TABLE notes (nid INT(10) UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, note TEXT NOT NULL, date INT(10) UNSIGNED NOT NULL, PRIMARY KEY (nid)) ENGINE = MyISAM";

// Establish a database connection
$connection = new Database();
$connection = $connection->getConnection();

// Execute the SQL
$connection->exec($sql);

echo "Installation complete, please delete this script.";

} catch (PDOException $e) {
	echo "<b>Error:</b> " . $e->getMessage();
}