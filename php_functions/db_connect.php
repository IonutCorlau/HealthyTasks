<?php

$server = "localhost";
$database = "personal assistant";
$dbUsername = "root";
$dbPassword = "";
$connect = mysqli_connect($server, $dbUsername, $dbPassword) or die("Failed to connect to MySQL: " . mysql_error());
$db = mysqli_select_db($connect,$database) or die("Failed to connect to MySQL: " . mysql_error());
mysqli_set_charset($connect, 'utf8');
if (mysqli_connect_errno($connect)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

