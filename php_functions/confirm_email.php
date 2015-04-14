<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirm mail</title>
         <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>

        <script src="/healthytasks/plugins/jquery/jquery-2.1.3.min.js"></script>

        <script src="/healthytasks/plugins/sweet_alert/sweet-alert.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/sweet_alert/sweet-alert.css">

    </head>
</html>

<?php

require_once ('account_functions.php');
require_once ('db_connect.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($token == md5(session_id())) {
        
        
        $date = date("Y-m-d",time());
        $query = "INSERT INTO users (firstName,lastName,username,email,password,creationTime) VALUES ('" . $_SESSION['firstName'] . "','" . $_SESSION['lastName'] . "','" . $_SESSION['userName'] . "','" . $_SESSION['email'] . "','" . $_SESSION['password'] . "','". $date.  "')";
        $result = mysqli_query($connect , $query) or die("Error : " . mysql_error());
        
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
        session_regenerate_id();
    } else {
        echo $_SESSION['userName'];
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
