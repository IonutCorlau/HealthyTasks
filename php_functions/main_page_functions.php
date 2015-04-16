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
 //require_once '/../plugins/sample_image/SampleImage.php';
$userId = $_SESSION['userId'];
$user = new User($userId);
$modified = false;
$isImage = false;
$modifiedImage = false;

if ($_FILES['uploadAvatarBtn']['name'] != null){
   
    $modifiedImage = true;
    $pathDir = "images/userAvatars/";
    $pathFile = $pathDir . $_FILES['uploadAvatarBtn']['name'];
   
    $imageFileType = pathinfo($pathFile, PATHINFO_EXTENSION);
    $checkSize = getimagesize($_FILES['uploadAvatarBtn']['tmp_name']);
        if ($checkSize !== false) {
            $isImage = true;
           
            
        } else {
        $isImage = false;
    }
}



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

if ($modified == false ) {
    if($modifiedImage == false){

        echo "<script>swal('No changes in the profile informations', 'No filed or avatar has been modified', 'warning');</script>";
    }
    else{
        if($modifiedImage == true){
            if($isImage == false){
                echo "<script>swal('Please upload an image file', 'The file that you uploaded is not an image format', 'warning');</script>";
            }else{//upload image format but not modify the fields
                if($_FILES['uploadAvatarBtn']['size']>1000000){
                    echo "<script>swal('Image exceeds one megabyte', 'Please upload a smaller image', 'warning');</script>";
                }else{
                $query = mysqli_query($connect, "UPDATE users SET avatar='$pathFile' WHERE id='$userId'");
                if($query){
                
                    move_uploaded_file( $_FILES['uploadAvatarBtn']['tmp_name'],$pathFile);
                   
                    echo "<script>
                    $(document).ready(function() {
                    swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                    function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
                    });
                        </script>";
                }
                else{
                    echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                    die('Invalid query: ' . mysqli_error($connect));
                }
            }
        }
    }

}

                }
else{
    if($modified == true){
        if($modifiedImage == false){
            echo "<script>
                $(document).ready(function() {
                swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
            });
            </script>";
            
        }else{
            if($modifiedImage == true){
                if($isImage == false){
                    echo "<script>
                    $(document).ready(function() {
                    swal({title: 'Profile updated without image',text: 'Please upload an image file. The file that you uploaded is not an image format',type: 'warning' },
                    function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
                 });
            </script>";
                }else{
                if($isImage == true){
                    if($_FILES['uploadAvatarBtn']['size']>1000000){
                        echo "<script>
                        $(document).ready(function() {
                            swal({title: 'Only form was updated. Image exceeds one megabyte',text: 'Please upload a smaller image',type: 'warning' },
                    function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
                    });
                    </script>";
                        
                    }
                    else{
                    $query = mysqli_query($connect, "UPDATE users SET avatar='$pathFile' WHERE id='$userId'");
                    if($query){
                        
                        move_uploaded_file($imageResized,$pathFile);
                        
                        echo "<script>
                        $(document).ready(function() {
                        swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                        function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
                     });
                    </script>";
                    }
                    else{
                        echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                        die('Invalid query: ' . mysqli_error($connect)); 
                    }
                }
                }
            }
        }
      
            
        
    }
    
                }
}}
        
        
        /*echo "<script>
                $(document).ready(function() {
                swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
            });
            </script>";
}
    else{
        if($modified == true && $isImage == false){
           echo "<script>swal('Please upload an image file', 'The file that you uploaded is not an image', 'warning');</script>";
        
    }
}
}
}*/
    

?>


