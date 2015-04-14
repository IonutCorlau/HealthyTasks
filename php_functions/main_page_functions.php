<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class User {

    public $firstName;
    public $id;

    function __construct($id) {
        require 'db_connect.php';
        $query = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
        $row = mysqli_fetch_assoc($query);

        $this->id = $id;
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
        $this->userName = $row['userName'];
        $this->email = $row['email'];
        $this->creationTime = $row['creationTime'];
    }

}

function sendContact($contactText) {
    require_once ( '/../plugins/phpmailer/class.phpmailer.php' );

    /* $query = "INSERT INTO contact (comment) VALUES ('" . $contactText . "')";
      mysql_query($query) or die("Error : " . mysql_error()); */

    $Mail = new PHPMailer();
    $ToEmail = 'healthy.tasks@gmail.com';

    $user = new User($_SESSION['userId']);



    $MessageHTML = "<b>You received the following message using contact page.</b> <br><br> First name: " . $user->firstName . "<br>Last name: " . $user->lastName . "<br>Username: " . $user->userName . "<br>Member since: " . $user->creationTime . "<br><br>Contact text:<br><br>\"" . $contactText ."\"";
    $MessageTEXT = "<b>You received the following message using contact page.</b> <br><br> First name: " . $user->firstName . "<br>Last name: " . $user->lastName . "<br>Username: " . $user->userName . "<br>Member since: " . $user->creationTime . "<br><br>Contact text:<br><br>\"" . $contactText . "\"";
    ;

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

function editProfile($firstNameEdit, $lastNameEdit, $userNameEdit, $emailEdit) {
    require 'db_connect.php';
    $userId = $_SESSION['userId'];
    $user = new User($userId);
    $modified = false;

    if ($user->firstName != $firstNameEdit) {
        
        $query = mysqli_query($connect, "UPDATE users SET firstName='$firstNameEdit' WHERE id='$userId'");
        if ($query) {
           
            $modified = true;
        } else {
            echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
        
    }
    
    if ($user->lastName != $lastNameEdit) {
       
        $query = mysqli_query($connect, "UPDATE users SET lastName='$lastNameEdit' WHERE id='$userId'");
        if ($query) {
             $modified = true;
        } else {
            echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
        
    }
    
     if ($user->userName != $userNameEdit) {
       
        $query = mysqli_query($connect, "UPDATE users SET userName='$userNameEdit' WHERE id='$userId'");
        if ($query) {
             $modified = true;
        } else {
            echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
        
    }
    
    if ($user->email != $emailEdit) {
      
       
        $query = mysqli_query($connect, "UPDATE users SET email='$emailEdit' WHERE id='$userId'");
        if ($query) {
             $modified = true;
        } else {
            echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
        
    }
    
    if ($modified == false) {
       
            echo "<script>swal('No changes in the profile informations', 'No filed has been modified', 'warning');</script>";
            
        }
        else{
             echo "<script>
                $(document).ready(function() {
                swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
            });
            </script>";
        }

      
}
?>

