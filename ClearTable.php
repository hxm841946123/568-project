<?php
$servername = "localhost:3306";
$username = "root";
$password = "1234567890";
$dbname = "History_Data";
$stock = array("YAHOY", "GOOG", "MSFT", "FB", "CCF", "BIDU", "SINA", "VZ", "T", "ATVI");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// delete history tables
foreach ($stock as $tmp) {
	if(!$conn->query("drop table $tmp")) {
		echo "Delete old ".$tmp." table failed:".$conn->error."\n";
	}
}
$conn->close();
$dbname = "Real_Data";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// delete realtime tables
foreach ($stock as $tmp) {
	if(!$conn->query("drop table $tmp")) {
		echo "Delete old ".$tmp." table failed:".$conn->error."\n";
	}
}
$conn->close();
?>