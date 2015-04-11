<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

require_once 'db_connect.php';

class User{
    public $firstName;
    public $id;
    
    function __construct($id) {
        
        $query = mysql_query("SELECT * FROM users WHERE id='$id'");
        $row = mysql_fetch_assoc($query);
        
        $this->id=$id;
        $this->firstName=$row['firstName'];
        $this->lastName=$row['lastName'];
        $this->userName=$row['userName'];
        $this->email=$row['email'];
        $this->creationTime=$row['creationTime'];
    }
}

function sendContact($contactText){
    require_once ( '/../plugins/phpmailer/class.phpmailer.php' );
    
    $query = "INSERT INTO contact (comment) VALUES ('" . $contactText . "')";
    mysql_query($query) or die("Error : " . mysql_error());
   
    $Mail = new PHPMailer();
    $ToEmail = 'healthy.tasks@gmail.com';
    
    $user = new User($_SESSION['userId']);
   
    
    
    $MessageHTML = "<b>You received the following message using contact page.</b> <br><br> First name: ".$user->firstName. "<br>Last name: ". $user->lastName."<br>Username: ". $user->userName."<br>Member since: " .$user->creationTime."<br><br>Contact text:<br><br>\"". $contactText ."\"";
    $MessageTEXT = "<b>You received the following message using contact page.</b> <br><br> First name: ".$user->firstName. "<br>Last name: ". $user->lastName."<br>Username: ". $user->userName."<br>Member since: " .$user->creationTime."<br><br>Contact text:<br><br>\"". $contactText ."\"";;
    
    include('send_mail.php');
    $Mail->Subject = 'Healty Tasks Personal Assistant - Contact form';
    
    $Mail->AddAddress($ToEmail); 
    $Mail->isHTML(TRUE);
    $Mail->Body = $MessageHTML;
    $Mail->AltBody = $MessageTEXT;
    $Mail->Send();
    $Mail->SmtpClose();
    
     if ($Mail->IsError()) { 
        echo "<script>swal('Error in sending the mail!', 'The mail was not sent. Please try again!', 'error');</script>";
        echo "<script>alert('Error');</alert>";
        return FALSE;
    } else {

        echo "<script>swal('Message Registered', 'An email was sent to Healthy Tasks team ', 'success');</script>";
        return TRUE;
    }

    $send = SendMail($ToEmail, $MessageHTML, $MessageTEXT);
    if ($send == 0) {
        echo "<script>swal('Error in sending the mail!', 'The mail was not sent. Please try again!', 'error');</script>";
    }
    die;
}
    


?>

