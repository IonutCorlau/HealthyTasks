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
}
function register($firstname, $lastname, $username, $email, $password){
    
    
    $queryDuplicateUsername=mysql_query("SELECT * FROM users WHERE username='$username'");
    $countUsername=mysql_num_rows($queryDuplicateUsername);
    
    
    $queryDuplicateEmail=mysql_query("SELECT * FROM users WHERE email='$email'");
    $countEmail=mysql_num_rows($queryDuplicateEmail);
    
    if($countUsername > 0){ 
         echo "<script>swal('Someone already has that username', 'Try another?', 'warning');</script>";  
         
    }
    else
    if($countEmail > 0){
        echo "<script>swal('Someone already has that email', 'Try another?', 'warning');</script>";
        
       
    }
    else{
        $query = "INSERT INTO users (firstName,lastName,username,email,password) VALUES ('$firstname','$lastname','$username','$email','$password')";
        $result = mysql_query($query) or die ( "Error : ". mysql_error() );
        echo "<script>swal('You recevied with a validation link', 'Please validate the link in order to acces your account!', 'success');</script>";
        //header('Location: main_page.php');
                                
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
            echo "<script>swal('Incorrect password', 'Try again!', 'error');</script>";         
        }
    }

    else{
        echo "<script>swal('Account does not exist ', 'Try again!', 'error');</script>"; 
    }
    
}

function forgetPassword($forgetPass){
 
   $queryUsername = mysql_query("SELECT * FROM users WHERE username='$forgetPass'");
   $queryEmail = mysql_query("SELECT * FROM users WHERE email='$forgetPass'");
   
   $countUsername = mysql_num_rows($queryUsername);
   $countEmail = mysql_num_rows($queryEmail);
  
   $rowUsermane =  mysql_fetch_array($queryUsername);
   $rowEmail = mysql_fetch_array($queryEmail);
   if($countUsername == 1){
      
       $email = $rowUsermane['email'];
       $id = $rowUsermane['id'];
       $_SESSION['id']=$id;
       recoverPasswordMail($email,$id);
   }
   else
        if($countEmail == 1){
            $email = $rowEmail['email'];
            $id = $rowEmail['id'];
            $_SESSION['id']=$id;
            recoverPasswordMail($email,$id);
        }
        else{
             echo "<script>swal('Username or email not found', 'Please try again!', 'error');</script>";
        }
}

function recoverPasswordMail($email,$id){
  require_once ( 'phpmailer/class.phpmailer.php' ); 
  
  
  
  session_start();
  $tokenKey=rand(1000,10000);
  $_SESSION['tokenKey'] = $tokenKey;
  $_SESSION['timeStamp'] = time();
  $token = md5($tokenKey+$id);
  $_SESSION['token'] = $token;
 
  $queryName = mysql_query("SELECT username FROM users WHERE email='$email'");
  $rowName = mysql_fetch_array($queryName);
  $firstName = $rowName['firstName'];
  $lastName = $rowName['lastName'];
    
  $Mail = new PHPMailer();
  $ToEmail = 'ionut.corlau@gmail.com';
 
  $MessageHTML = "Hello $firstName, <br><br> <p> You have requested to reset yout forgotten password for your Healthy Tasks account.</p> <br> <a href='http://localhost/healthytasks/php_functions/reset_password.php?token=$token'> Click here to reset tour forgotten password </a><br> The link will be valid 24 hours from time of receiving the mail. <br><br> Thank you, <br> Healthy Tasks team <br> <a href='mailto:healthy.tasks@gmail.com?subject=Contact password'>healthy.tasks@gmail.com</a> ";
  $MessageTEXT = "<a href='http://localhost/healthytasks/php_functions/reset_password.php?token=$token'> Click here! </a>";
   
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
      echo "<script>swal('Error in sending the mail!', 'The mail was not sent. Please try again!', 'error');</script>";
      return FALSE;
  }
  else {
    echo "<script>swal('We\'ve sent an email to you', 'Click the link in the email to reset your password. The link will expire in 24 hours!', 'success');</script>";
    return TRUE;
    
  }

$send = SendMail( $ToEmail, $MessageHTML, $MessageTEXT );
if($send == 0){
   echo "<script>swal('Error in sending the mail!', 'The mail was not sent. Please try again!', 'error');</script>";
}
die;
}

function resetPassword($newPassword, $token){
    $tokenKey = $_SESSION['tokenKey'];
    
   $queryReset =  mysql_query("SELECT * FROM users WHERE md5($tokenKey+id)='$token'");
   $row= mysql_fetch_array($queryReset); 
   
   $id = $row['id'];
  
   $queryResetUpdate = mysql_query("UPDATE users SET password='$newPassword' WHERE id='$id'");
   if($queryResetUpdate){
       echo "<script>
        swal({  title: 'Your password has been successfully updated!',   text: 'Go to main page in 3 seconds.',   timer: 3000,   showConfirmButton: false });
        window.setTimeout(changeLink,3000);
        function changeLink(){
         window.location.href = '../main_page.php';
        }
       </script>";
       
  
   }
       else{
           die('Invalid query: ' . mysql_error());
       }
    
}
?> 
