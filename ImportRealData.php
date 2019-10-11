<?php
error_reporting(0);
$servername = "localhost:3306";
$username = "root";
$password = "1234567890";
$stock = array("YAHOY", "GOOG", "MSFT", "FB", "CCF", "BIDU", "SINA", "VZ", "T", "ATVI");
// Import real time data
$dbname = "Real_Data";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
foreach ($stock as $tmp) {
    $sql = "CREATE TABLE $tmp (
		Rea_Date DATETIME,
		Open_Price DECIMAL(10, 6) NOT NULL,
		High_Price DECIMAL(10, 6) NOT NULL,
		Low_Price DECIMAL(10, 6) NOT NULL,
		Close_Price DECIMAL(10, 6) NOT NULL,
		Volume DECIMAL(20, 0) NOT NULL
	)";
    // check if the table exists
    $result = $conn->query("SELECT * FROM $tmp");
    // if not exist, create new table
    if (!$result){
        if ($conn->query($sql) === TRUE) {
            echo $tmp."Table created successfully \n";
        } else {
            echo "Error creating".$tmp." table: " . $conn->error. "\n";
        }
    }
    $csv_path="./real_data/$tmp.csv";
    $infile = fopen($csv_path, "r");
    // Ignore first row
    $data = fgets($infile, 4096);
    // echo $data;
    while ($data = fgets($infile, 4096)) {
        $dataArr = explode(",", $data);
        $sql = "INSERT INTO $tmp (Rea_Date, Open_Price, High_Price, Low_Price, Close_Price, Volume)
			SELECT '$dataArr[1]','$dataArr[3]','$dataArr[4]','$dataArr[5]','$dataArr[6]','$dataArr[8]'
			FROM DUAL
			WHERE NOT EXISTS(
				SELECT *
				FROM $tmp
				WHERE $tmp.Rea_Date = '$dataArr[1]')";
        if ($conn->query($sql) === TRUE) {
            // echo "Import ".$tmp." history data successfully\n";
        } else {
            echo "Error import ".$tmp.": ".$conn->error."\n";
        }
    }
    echo "Import ".$tmp." real data complete\n";
}
$conn->close();
?>