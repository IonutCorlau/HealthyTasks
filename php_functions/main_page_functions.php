<?php

function sendContact($contactText){
    require_once ( 'plugins/phpmailer/class.phpmailer.php' );
    print_r($_SESSION);
    $Mail = new PHPMailer();
    $ToEmail = 'healthy.tasks@gmail.com';
    
    $MessageHTML = "<b>You received the following message using contact page.</b> <br><br> First name: ".$_SESSION['firstName']. "<br>Last name: ". $_SESSION['lastName']."<br>Username: ". $_SESSION['userName'] ;
    $MessageTEXT = $contactText;
    
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

