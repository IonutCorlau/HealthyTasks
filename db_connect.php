<?php
    
function databaseConnect(){
    $server = "localhost";
    $database = "personal assistant";
    $username = "root";
    $password = "";
    
    
    $connect= mysql_connect($server,$username,$password) or die("Failed to connect to MySQL: ". mysql_error() );
    $db = mysql_select_db($database) or die("Failed to connect to MySQL: " . mysql_error());
    

    
    if (mysqli_connect_errno($connect)){ 
        echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
        
    } 
    
function register($firstname, $lastname, $username, $email, $password){

    
    $queryDuplicateUsername=mysql_query("SELECT * FROM users WHERE username='$username'");
    $countUsername=mysql_num_rows($queryDuplicateUsername);
    
    
    $queryDuplicateEmail=mysql_query("SELECT * FROM users WHERE email='$email'");
    $countEmail=mysql_num_rows($queryDuplicateEmail);

    if($countUsername > 0){ 
        echo "<script type='text/javascript'>alert('Username already taken!');</script>";
        
    }
    if($countEmail > 0){
        echo "<script type='text/javascript'>alert('Email already introduced!');</script>";
        
    }
    else{
        $query = "INSERT INTO users (firstName,lastName,username,email,password) VALUES ('$firstname','$lastname','$username','$email','$password')";
        $result = mysql_query($query) or die ( "Error : ". mysql_error() );
        header('Location: main_page.php');
                                
    }
}
}
   
function login($username, $password){
    $query =  mysql_query("SELECT * FROM users WHERE username='$username'");
    $count =  mysql_num_rows($query);
    
    if($count != 0){
        $row=mysql_fetch_assoc($query);
        $dbusername=$row['username'];
        $dbpassword=$row['password'];
       
        if($username==$dbusername && $password==$dbpassword){
            header('Location: main_page.php');
            exit;
        }
        else{
            echo "<script type='text/javascript'>alert('Incorrect password!');</script>";           
        }
    }

    else{
        echo "<script type='text/javascript'>alert('User not exist!');</script>";
    }
    
}

function forgetPassword($forgetPass){
   $queryUsername = mysql_query("SELECT * FROM users WHERE username='$forgetPass'");
   $queryEmail = mysql_query("SELECT * FROM users WHERE email='$forgetPass'");
   
   $countUsername = mysql_num_rows($queryUsername);
   $countEmail = mysql_num_rows($queryEmail);
   
   if($countUsername == 1){
       $row =  mysql_fetch_array($queryUsername);
       $email = $row['email'];
       $id = $row['id'];
       recoverPasswordMail($email,$id);
   }
   else
        if($countEmail == 1){
            $email = $forgetPass;
            recoverPasswordMail($email,$id);
        }
        else{
            echo "<script type='text/javascript'>alert('Username or email not found!');</script>";
        }
}

function recoverPasswordMail($email,$id){
  require_once ( 'phpmailer/class.phpmailer.php' ); 
  
  session_start();
  $tokenKey=rand(1000,10000);
  $_SESSION['tokenKey'] = $tokenKey;
  $_SESSION['timeStamp'] = time();
  $token = md5($tokenKey+$id);
 
  
  $Mail = new PHPMailer();
  $ToEmail = 'ionut.corlau@gmail.com';
 
  $MessageHTML = 
  $MessageTEXT = "http://localhost/healthytasks/reset_password.php?token=$token ";
   
  $Mail->IsSMTP(); // Use SMTP
  $Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
  $Mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
  $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
  $Mail->SMTPSecure  = "tls"; //Secure conection
  $Mail->Port        = 587; // set the SMTP port
  $Mail->Username    = 'healthy.tasks@gmail.com'; // SMTP account username
  $Mail->Password    = 'lola2006'; // SMTP account password
  $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
  $Mail->CharSet     = 'UTF-8';
  $Mail->Encoding    = '8bit';
  $Mail->Subject     = 'Healty Personal Assistant - Reset password mail';
  $Mail->ContentType = 'text/html; charset=utf-8\r\n';
  $Mail->From        = 'healthy.tasks@gmail.com';
  $Mail->FromName    = 'Healthy Tasks';
  $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
  $Mail->SMTPDebug   = FALSE;

  $Mail->AddAddress( $ToEmail ); // To:
  $Mail->isHTML( TRUE );
  $Mail->Body    = $MessageHTML;
  $Mail->AltBody = $MessageTEXT;
  $Mail->Send();
  $Mail->SmtpClose();
  
  
  

  if ( $Mail->IsError() ) { // ADDED - This error checking was missing
      echo "<script type='text/javascript'>alert('Error');</script>";
      return FALSE;
  }
  else {
    echo "<script type='text/javascript'>alert('Mail sent!');</script>";
    return TRUE;
  }

$send = SendMail( $ToEmail, $MessageHTML, $MessageTEXT );
if($send == 0){
   echo "<script type='text/javascript'>alert('Error in sending mail. THe mail was not send!');</script>"; 
}
die;
}



 ?>
