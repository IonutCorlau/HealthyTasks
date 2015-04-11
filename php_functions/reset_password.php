<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forget Password page</title>
        <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>
        
        <link rel="stylesheet" type="text/css" href="/healthytasks/css/account/forget_password_reset.css">
        <link rel="stylesheet" type="text/css" href="/healthytasks/css/account/forget_password.css">

        <script src="/healthytasks/plugins/jquery/jquery-2.1.3.min.js"></script>
        
        <script src="/healthytasks/plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="/healthytasks/plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>
        
      
        <script src="/healthytasks/plugins/jquery_fullbg/jquery.fullbg.js"></script>
        <script src="/healthytasks/plugins/jquery_fullbg/jquery.fullbg.min.js"></script>
        
        <script src="/healthytasks/plugins/password_meter/jquery.validate.password.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/password_meter/jquery.validate.password.css">

        <script src="/healthytasks/plugins/sweet_alert/sweet-alert.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/sweet_alert/sweet-alert.css">
        
        <script src="/healthytasks/js/account/my_functions.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8">

    </head>
</html>
<?php
require_once 'db_connect.php';
session_start();

if (isset($_GET['token']) && (isset($_SESSION['tokenKey']))) {

    $token = $_GET['token'];
    $tokenKey = $_SESSION['tokenKey'];


    $time = $_SESSION['timeStamp'];

    $queryToken = mysql_query("SELECT * FROM users WHERE md5($tokenKey+id)='$token'");
    $row = mysql_fetch_array($queryToken);
    $count = mysql_num_rows($queryToken);
    if ($count == false) {

        echo "<script>
                $(document).ready(function() {
                swal({ 
                    title: 'Invalid link',
                    text: 'Please enter again you username or email!',
                    type: 'warning' 
                },
                function(){
                  window.location.href = 'http://localhost/healthytasks/forget_password.php';
              });
            });
            </script>";
    } else {
        if (time() - $time > 86400) {
            //86400

            echo "<script>swal('Sorry, your link has expired', 'Please enter again your username or email!', 'error');</script>";
            include '/../forget_password.php';
        } else {

            include '/../forget_password_reset.php';
        }
    }
}
?>