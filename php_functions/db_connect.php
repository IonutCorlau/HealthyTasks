<?php

$server = "localhos";
$database = "personal assistant";
$username = "root";
$password = "";


$connect = mysql_connect($server, $username, $password) or die("Failed to connect to MySQL: " . mysql_error());
$db = mysql_select_db($database) or die("Failed to connect to MySQL: " . mysql_error());



if (mysqli_connect_errno($connect)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

