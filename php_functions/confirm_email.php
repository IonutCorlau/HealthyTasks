<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirm mail</title>


        <script src="../js/jquery-2.1.3.min.js"></script>

        <script src="../js/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="../css/sweet-alert.css">

    </head>
</html>

<?php
require_once 'db_connect.php';
databaseConnect();


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($token == md5(session_id())) {

        $query = "INSERT INTO users (firstName,lastName,username,email,password) VALUES ('" . $_SESSION['firstName'] . "','" . $_SESSION['lastName'] . "','" . $_SESSION['userName'] . "','" . $_SESSION['email'] . "','" . $_SESSION['password'] . "')";
        $result = mysql_query($query) or die("Error : " . mysql_error());
        session_regenerate_id();
        echo "<script>
                $(document).ready(function() {
                swal({ 
                    title: 'Account has been created',
                    text: 'Please Sign in',
                    type: 'success' 
                },
                function(){
                  window.location.href = 'http://localhost/healthytasks/sign_in.php';
              });
            });
            </script>";
    } else {
        echo "<script>
                $(document).ready(function() {
                swal({ 
                    title: 'Link expired',
                    text: 'Please register again and check mail!',
                    type: 'error' 
                },
                function(){
                  window.location.href = 'http://localhost/healthytasks/register.php';
              });
            });
            </script>";
    }
}
?>
