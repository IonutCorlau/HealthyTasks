<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Confirm mail</title>
	     
        <script src="../js/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="../css/sweet-alert.css">
        
</head>
</html>

<?php
require_once 'db_connect.php';
databaseConnect();


if(isset($_GET['token'])){
    $token = $_GET['token'];
    
    if($token == md5(session_id())){
       
        $query = "INSERT INTO users (firstName,lastName,username,email,password) VALUES ('".$_SESSION['first\Name']."','".$_SESSION['lastName']."','".$_SESSION['userName']."','".$_SESSION['email']."','".$_SESSION['password']."')";
        $result = mysql_query($query) or die ( "Error : ". mysql_error() );
      
    }
    else{
        echo "<script>swal('Your link is invalid!', 'Please try to create an account again!', 'error');</script>";
    }
    
}

?>
