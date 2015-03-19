
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
        if(time()-$time>10000){
     
             echo "<script type='text/javascript'>alert('Your link expired!');window.location = 'http://localhost/healthytasks/forget_password.php';</script>";

    }
    else{
        
        
        echo '<link rel="stylesheet" type="text/css" href="../css/forget_password_reset.css">
              <script src="../js/jquery-2.1.3.min.js"></script>
	      <script src="../js/jquery.validate.js"></script>
	      <script src="../js/validateJQueryPlugin.js"></script>
              <script src="../js/jquery.fullbg.js"></script>
              <script src="../js/jquery.fullbg.min"></script>';
        include '../forget_password_reset.php';   
        
       
        
        
    }
    }
    
    
}







    
    
?>