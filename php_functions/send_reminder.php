<?php

function sendReminder() {
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    echo $root;
    require  "$root\..\plugins\phpmailer\class.phpmailer.php" ;
    require "$root/db_connect.php";
    
        $query = mysqli_query($connect,"SELECT reminderTime from tasks");
        $reminderArray = array();
        
        while($reminder = mysqli_fetch_assoc($query)){
            $reminderArray[] = $reminder;
        }
        echo $reminderArray[0];
        
        $Mail = new PHPMailer();
        $ToEmail = 'ionut.corlau@gmail.com';
        $MessageHTML = "bla";
        $MessageTEXT = "bla";

        require_once('send_mail.php');
        $Mail->Subject = 'Healty Tasks Personal Assistant - TaskReminder';

        $Mail->AddAddress($ToEmail);
        $Mail->isHTML(TRUE);
        $Mail->Body = $MessageHTML;
        $Mail->AltBody = $MessageTEXT;
        $Mail->Send();
        $Mail->SmtpClose();
       
    
   
   
}
    
    

    
    

?>

