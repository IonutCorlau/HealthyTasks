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

class Task {

    public $id;

    function __construct($id) {
        require 'db_connect.php';
        $query = mysqli_query($connect, "SELECT * FROM tasks WHERE id='$id'");
        $row = mysqli_fetch_assoc($query);

        $this->id = $id;
        $this->userId = $row['userId'];
        $this->name = $row['name'];
        $this->category = $row['category'];
        $this->description = $row['description'];
        $this->time = $row['time'];
        $this->location = $row['location'];
        $this->duration = $row['duration'];
        $this->importance = $row['importance'];
        $this->reminderInput = $row['reminderInput'];
        $this->reminderTime = $row['reminderTime'];
    }

}

class HealthProfile {

    public $id;

    function __construct($id) {
        require 'db_connect.php';
        $query = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$id'");
        $row = mysqli_fetch_assoc($query);
        
        $this->id = $row['id'];
        $this->userId = $row['userId'];
        $this->height = $row['height'];
        $this->weight = $row['weight'];
        $this->age = $row['age'];
        $this->gender = $row['gender'];
        $this->activityLevel = $row['activityLevel'];
        $this->calories = $row['calories'];
        
    }

}

function sendContact($contactText, $ratingInput) {

    require_once ( '/../plugins/phpmailer/class.phpmailer.php' );
    require ('db_connect.php');

    $user = new User($_SESSION['userId']);

    $query = "INSERT INTO contacts (userId ,comment, rating) VALUES ('$user->id','$contactText', '$ratingInput')";
    mysqli_query($connect, $query) or die("Error : " . mysql_error());

    $Mail = new PHPMailer();
    $ToEmail = 'healthy.tasks@gmail.com';

    $MessageHTML = "<b>You received the following message using contact page.</b> <br><br> First name: "
            . $user->firstName . "<br>Last name: " . $user->lastName . "<br>Username: " . $user->userName .
            "<br>Member since: " . $user->creationTime . "<br>Rating: " . $ratingInput . " from " . "5" . " <br><br>Contact text:<br><br>\"" . $contactText . "\"";
    $MessageTEXT = "<b>You received the following message using contact page.</b> <br><br> First name: "
            . $user->firstName . "<br>Last name: " . $user->lastName . "<br>Username: " . $user->userName .
            "<br>Member since: " . $user->creationTime . "<br>Rating: " . $ratingInput . " from " . "5" . " <br><br>Contact text:<br><br>\"" . $contactText . "\"";


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
        //header('Location: main_page.php');
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
    require_once '/../plugins/image_resize/resize-class.php';

    $userId = $_SESSION['userId'];
    $user = new User($userId);
    $modified = false;
    $isImage = false;
    $modifiedImage = false;

    if ($_FILES['uploadAvatarBtn']['name'] != null) {

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

        $queryDuplicateUsername = mysqli_query($connect, "SELECT * FROM users WHERE username='$userNameEdit'");
        if ($queryDuplicateUsername) {
            $countUsername = mysqli_num_rows($queryDuplicateUsername);
            if ($countUsername > 0) {
                echo "<script>swal('Someone already has that username', 'Try another? No modifications were found.', 'warning');</script>";
                exit();
            } else {
                $query = mysqli_query($connect, "UPDATE users SET userName='$userNameEdit' WHERE id='$userId'");
                if ($query) {
                    $modified = true;
                } else {
                    echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                    die('Invalid query: ' . mysqli_error($connect));
                }
            }
        } else {
            die('Invalid query: ' . mysqli_error($connect));
        }
    }

    if ($user->email != $emailEdit) {

        $queryDuplicateEmail = mysqli_query($connect, "SELECT * FROM users WHERE email='$emailEdit'");
        if ($queryDuplicateEmail) {
            $countEmail = mysqli_num_rows($queryDuplicateEmail);
            if ($countEmail > 0) {
                echo "<script>swal('Someone already has that email address', 'Try another? No modifications were found.', 'warning');</script>";
                exit();
            } else {
                $query = mysqli_query($connect, "UPDATE users SET email='$emailEdit' WHERE id='$userId'");
                if ($query) {
                    $modified = true;
                } else {
                    echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                    die('Invalid query: ' . mysqli_error($connect));
                }
            }
        } else {
            die('Invalid query: ' . mysqli_error($connect));
        }
    }

    if ($modified == false) {
        if ($modifiedImage == false) {

            echo "<script>swal('No changes in the profile informations', 'No filed or avatar has been modified', 'warning');</script>";
        } else {
            if ($modifiedImage == true) {
                if ($isImage == false) {
                    echo "<script>swal('Please upload an image file', 'The file that you uploaded is not an image format', 'warning');</script>";
                } else {
                    if ($_FILES['uploadAvatarBtn']['size'] > 3000000) {
                        echo "<script>swal('Image exceeds 3 megabytes', 'Please upload a smaller image', 'warning');</script>";
                    } else {
                        $image = new resize($_FILES['uploadAvatarBtn']['tmp_name'], 150, $pathDir);
                        $dbImageName = basename($image->src, '.' . 'tmp');
                        $imageExtension = "." . explode('.', $_FILES['uploadAvatarBtn']['name'], 2)[1];

                        $query = mysqli_query($connect, "UPDATE users SET avatar='$pathDir$dbImageName$imageExtension' WHERE id='$userId'") or die("<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>Invalid query: " . mysqli_error($connect));


                        $crispy = new resize($_FILES['uploadAvatarBtn']['tmp_name'], 150, $pathDir);
                        $src = $crispy->resizeImage();
                        echo "<script>
                                    $(document).ready(function() {
                                    swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                                    function(){window.location.href = ''; });
                                    });
                        </script>";


                        /* if ($query) {

                          $crispy = new resize($_FILES['uploadAvatarBtn']['tmp_name'], 150, $pathDir);
                          $src = $crispy->resizeImage();

                          echo "<script>
                          $(document).ready(function() {
                          swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                          function(){window.location.href = 'http://localhost/healthytasks/main_page.php'; });
                          });
                          </script>";
                          }

                          else {
                          echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                          die('Invalid query: ' . mysqli_error($connect));
                          } */
                    }
                }
            }
        }
    } else {
        if ($modified == true) {
            if ($modifiedImage == false) {
                echo "<script>
                $(document).ready(function() {
                swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                function(){window.location.href = ''; });
            });
            </script>";
            } else {
                if ($modifiedImage == true) {
                    if ($isImage == false) {
                        echo "<script>
                    $(document).ready(function() {
                    swal({title: 'Profile updated without image',text: 'Please upload an image file. The file that you uploaded is not an image format',type: 'warning' },
                    function(){window.location.href = ''; });
                 });
            </script>";
                    } else {
                        if ($isImage == true) {

                            $query = mysqli_query($connect, "UPDATE users SET avatar='$pathFile' WHERE id='$userId'");
                            if ($query) {

                                move_uploaded_file($imageResized, $pathFile);

                                echo "<script>
                        $(document).ready(function() {
                        swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                        function(){window.location.href = ''; });
                     });
                    </script>";
                            } else {
                                echo "<script>swal('Error', 'The profile has not been updated, error occurred ', 'error');</script>";
                                die('Invalid query: ' . mysqli_error($connect));
                            }
                        }
                    }
                }
            }
        }
    }
}

function addTask($userId, $taskName, $taskCategory, $taskDescription, $taskDate, $taskLocation, $taskDuration, $taskImportance, $taskReminder) {
    require 'db_connect.php';

    date_default_timezone_set('UTC');
    $unixDeadline = strtotime($taskDate);
    $unixDate = strtotime($taskDuration); //get the unix time of the current day + task duration
    $unixDay = strtotime(date('Y-m-d')); //get the unix time of the current day
    $taskDurationMilisecond = $unixDate - $unixDay;
    $taskReminderSend = $unixDeadline - $taskReminder;

    if ($unixDeadline != null) {
        $queryDuplicateTask = mysqli_query($connect, "SELECT * FROM tasks WHERE time='$unixDeadline'");
        $countTaskDuplicate = mysqli_num_rows($queryDuplicateTask);
    }
    if ($countTaskDuplicate > 0) {
        echo "<script>swal('You already have a task', 'At that time you already have a task programmed', 'warning');</script>";
    } else {

        $query = mysqli_query($connect, "INSERT INTO tasks (userId, name, category, description, time, location, duration, importance, reminderInput, reminderTime  ) VALUES ( '$userId', '$taskName', '$taskCategory', '$taskDescription', '$unixDeadline', '$taskLocation','$taskDurationMilisecond', '$taskImportance','$taskReminder','$taskReminderSend')");
        if ($query) {
            echo "<script>
                            $(document).ready(function() {
                            swal({title: 'Task added',text: 'The task has been registered successfully',type: 'success' },
                            function(){window.location.href = ''; });
                         });
                        </script>";
        } else {
            echo "<script>swal('Error', 'The task has not been added, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
    }


//or die("Error : " . mysqli_error($connect));
}

function computeCalories($userId, $height, $weight, $age, $gender, $activityLevel) {
    require 'db_connect.php';
    
    echo $height;

    if ($gender == 'Female') {
        $BMR = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
    } else if ($gender == 'Male') {
        $BMR = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
    }

    if ($activityLevel == 'Sedentary') {
        $calories = $BMR + $BMR * 0.2;
    } else if ($activityLevel == 'Light') {
        $calories = $BMR + $BMR * 0.3;
    } else if ($activityLevel == 'Medium') {
        $calories = $BMR + $BMR * 0.4;
    } else if ($activityLevel == 'Heavy') {
        $calories = $BMR + $BMR * 0.5;
    }
    
    $userId = $_SESSION['userId'];
    
    
    $queryUserId = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$userId'");
    $count = mysqli_num_rows($queryUserId);
    
    
   
    
 
        if ($count == 0) {
            
            $query = mysqli_query($connect, "INSERT INTO health_profile (userId, height, weight, age, gender, activityLevel, calories) VALUES ('$userId', '$height', '$weight', '$age', '$gender', '$activityLevel', '$calories')");
            if ($query) {
                echo "<script>
                                $(document).ready(function() {
                                swal({title: 'Profile updated',text: 'Health profile successfully updated ',type: 'success' },
                                function(){window.location.href = ''; });
                             });
                            </script>";
            } else {
                echo "<script>swal('Error', 'The values were not recorded, error occurred ', 'error');</script>";
                die('Invalid query: ' . mysqli_error($connect));
            }
        } else {
            $query = mysqli_query($connect, "UPDATE health_profile SET height='$height', weight='$weight', age='$age', gender='$gender', activityLevel='$activityLevel', calories='$calories' WHERE userId='$userId'");
            if($query){
                echo "<script>
                                $(document).ready(function() {
                                swal({title: 'Profile updated',text: 'Health profile successfully updated ',type: 'success' },
                                function(){window.location.href = ''; });
                             });
                            </script>";
            } else {
                echo "<script>swal('Error', 'The values were not recorded, error occurred ', 'error');</script>";
                die('Invalid query: ' . mysqli_error($connect));
            }

            }
    
        
    
}
?>


