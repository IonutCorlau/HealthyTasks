<?php
require_once 'db_connect.php';
databaseConnect();

session_start();



if(isset($_GET['token']) && (isset($_SESSION['tokenKey'])) && (isset($_SESSION['tokenKey']))){
    $token = $_GET['token'];
    $tokenKey = $_SESSION['tokenKey'];
    $time = $_SESSION['timeStamp'];
    
    $queryToken =  mysql_query("SELECT * FROM users WHERE md5($tokenKey+id)='$token'");
    $row= mysql_fetch_array($queryToken);
    $count = mysql_num_rows($queryToken);
    if($count == false){
        
        echo "<h2>Invalid token</h2>";
    }
    
    else{
       echo $row['email'];
    }
    
    if(time()-$time>6000){
        echo "<script type='text/javascript'>alert('Your link expired!');</script>";
        include 'forget_password.php';
        session_destroy();
        session_unset();
    }
    
    
    
}
    
    
?>