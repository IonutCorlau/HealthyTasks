
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class User {

    public $firstName;
    public $id;

    function __construct($id) {
        require 'db_connect.php';
        $query = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'") or die('Invalid query: ' . mysqli_error($connect));
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
        $query = mysqli_query($connect, "SELECT * FROM tasks WHERE id='$id'") or die('Invalid query: ' . mysqli_error($connect));

        $row = mysqli_fetch_assoc($query);

        $this->id = $id;
        $this->userId = $row['userId'];
        $this->name = $row['name'];
        $this->category = $row['category'];
        $this->healthyActivity = $row['healthyActivity'];
        $this->description = $row['description'];

        if ($row['time'] != '') {
            $this->time = date("H:i", $row['time']) . ' ' . date("d-m-Y", $row['time']);
        } else {
            $this->time = "";
        }


        $this->location = $row['location'];
        if ($row['duration'] == 0) {
            $this->duration = "";
        } else {
            $this->duration = date("H:i", $row['duration']);
        }

        $this->importance = $row['importance'];

        if ($row['reminderInput'] > 0 && $row['reminderInput'] <= 3540) {
            $reminderReadable = date(" s", $row['reminderInput'] / 60) . ' ' . "Minutes";
        } else if ($row['reminderInput'] >= 3600 && $row['reminderInput'] <= 82800) {
            $reminderReadable = date(" i", $row['reminderInput'] / 60) . ' ' . "Hours";
        } else if ($row['reminderInput'] >= 86400 && $row['reminderInput'] <= 2592000) {
            $reminderReadable = date("d", $row['reminderInput']) - 1 . ' ' . "Days";
        } else if ($row['reminderInput'] == 0) {
            $reminderReadable = "";
        }
        $this->reminderInput = $reminderReadable;

        if ($row['calorieConsumption'] == 0) {
            $this->calories = "";
        } else {
            $this->calories = $row['calorieConsumption'];
        }
    }

}

class HealthProfile {

    public $id;

    function __construct($id) {
        require 'db_connect.php';
        $query = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$id'") or die('Invalid query: ' . mysqli_error($connect));
        $row = mysqli_fetch_assoc($query);




        $this->id = $row['id'];
        $this->userId = $row['userId'];
        $this->height = $row['height'];
        $this->weight = $row['weight'];
        $this->age = $row['age'];
        $this->gender = $row['gender'];
        //$this->activityLevel = $row['activityLevel'];
        $this->calories = $row['calories'];
    }

}

class DailyCalories {

    public $id;

    function __construct($id, $currentDate) {
        require 'db_connect.php';
        $userId = $_SESSION['userId'];
        date_default_timezone_set('UTC');

        $dateStart = strtotime(date("m/d/Y"));
        $dateEnd = strtotime(date("m/d/Y")) + 86399;


        $queryGetConsumptionToday = mysqli_query($connect, "SELECT calorieConsumption FROM tasks WHERE category='Health' AND finishTime BETWEEN '$dateStart' AND '$dateEnd' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
        $row = mysqli_num_rows($queryGetConsumptionToday);
        if ($row > 0) {

            $sumCalories = 0;

            while ($rowCalorieSum = mysqli_fetch_assoc($queryGetConsumptionToday)) {
                $resultCalorieSum[] = $rowCalorieSum;
            }


            foreach ($resultCalorieSum as $sum) {
                $sumCalories = $sumCalories + $sum['calorieConsumption'];
            }
            $this->calorieTarget = $sumCalories;
        } else {
            $this->calorieTarget = 0;
        }
        //
        $query = mysqli_query($connect, "SELECT * FROM daily_calories WHERE userId='$id' AND unixDay='$currentDate'") or die('Invalid query: ' . mysqli_error($connect));
        $row = mysqli_fetch_assoc($query);
        $queryGetBMR = mysqli_query($connect, "SELECT calories FROM health_profile WHERE userId='$id'") or die('Invalid query: ' . mysqli_error($connect));
        $queryResultBMR = mysqli_fetch_assoc($queryGetBMR);

        $this->id = $row['id'];
        $this->calorieEat = $row['calorieEat'];

        $this->calorieBMR = $queryResultBMR['calories'];
        $this->calorieBurned = $row['calorieBurned'];
        $this->unixDay = $row['unixDay'];
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
        //header('Location: index.php');
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

            echo "<script>swal('No changes in the profile informations', 'No field or profile image has been modified', 'warning');</script>";
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
                           
                                   //swal('Profile updated', 'Your personal info have been updated successfully', 'success');
                                  
                              
                    swal('Profile updated', 'User profile successfully updated ', 'success');
                    $(document).click(function(e) {
                        window.location.href = '';
                     });
   
                  </script>";





                        /* if ($query) {

                          $crispy = new resize($_FILES['uploadAvatarBtn']['tmp_name'], 150, $pathDir);
                          $src = $crispy->resizeImage();

                          echo "<script>
                          $(document).ready(function() {
                          swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                          function(){window.location.href = 'http://localhost/healthytasks/index.php'; });
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
                //$(document).ready(function() {
               // swal({title: 'Profile updated',text: 'Your personal info have been updated successfully',type: 'success' },
                //function(){window.location.href = ''; });
                //alert('bla');
                
                              
                    swal('Profile updated', 'User profile successfully updated ', 'success');
                    $(document).click(function(e) {
                        window.location.href = '';
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
                        function(){window.location.href = ''; 
                       
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

function addTask($userId, $taskName, $taskCategory, $taskActivity, $taskDescription, $taskDate, $taskLocation, $taskDuration, $taskImportance, $taskReminder) {
    require 'db_connect.php';

    date_default_timezone_set('UTC');
    $unixDeadline = strtotime($taskDate);
    $unixDate = strtotime($taskDuration); //get the unix time of the current day + task duration
    $unixDay = strtotime(date('Y-m-d')); //get the unix time of the current day
    $taskDurationSeconds = $unixDate - $unixDay;
    $taskReminderSend = $unixDeadline - $taskReminder;
    $finishTime = $unixDeadline + $taskDurationSeconds;

    $heathProfile = new HealthProfile($userId);


    if ($unixDeadline != 0 && $unixDeadline < time() + 10800) {
        echo "<script>swal('Wrong time', 'You cannot program tasks in the past. Please select a date from the future', 'warning');</script>";
    } else {
        if (!empty($taskActivity) && $taskDurationSeconds != 0 && empty($heathProfile->weight)) {
            echo "<script>swal('Please complete health profile ', 'In order to compute calories consumption we need to know your weight', 'warning');</script>";
        } else

        if ((!empty($taskActivity)) && $taskDurationSeconds == 0) {
            echo "<script>swal('Please complete duration of the activity', 'In order to add a healthy activity you should specify this informations', 'warning');</script>";
        } else {

            if ($unixDeadline != null) {
                $queryDuplicateTask = mysqli_query($connect, "SELECT * FROM tasks WHERE time='$unixDeadline'");
                $countTaskDuplicate = mysqli_num_rows($queryDuplicateTask);
            }
            if ($countTaskDuplicate > 0) {
                echo "<script>swal('You already have a task', 'At that time you already have a task programmed', 'warning');</script>";
            } else {
                if (!empty($taskActivity)) {
                    $calorieConsumptionActivity = computeCaloriesActivity($taskActivity, $taskDurationSeconds, $heathProfile->weight);
                } else {
                    $calorieConsumptionActivity = 0;
                }

                $query = mysqli_query($connect, "INSERT INTO tasks (userId, name, category,healthyActivity, description, time, location, duration, finishTime, importance, reminderInput, reminderTime, calorieConsumption  ) VALUES ( '$userId', '$taskName', '$taskCategory', '$taskActivity', '$taskDescription', '$unixDeadline', '$taskLocation','$taskDurationSeconds', '$finishTime', '$taskImportance','$taskReminder','$taskReminderSend', '$calorieConsumptionActivity')");
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
    }
}

function computeCalories($userId, $height, $weight, $age, $gender) {
    require 'db_connect.php';


    /* if ($gender == 'Female') {
      $BMR = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
      } else if ($gender == 'Male') {
      $BMR = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
      }
      $calories=$BMR;

      if ($activityLevel == 'Sedentary') {
      $calories = $BMR + $BMR * 0.2;
      } else if ($activityLevel == 'Light') {
      $calories = $BMR + $BMR * 0.375;
      } else if ($activityLevel == 'Medium') {
      $calories = $BMR + $BMR * 0.55;
      } else if ($activityLevel == 'Heavy') {
      $calories = $BMR + $BMR * 0.725;
      } */

    if ($gender == 'Female') {
        $BMR = 10 * $weight + 6.25 * $height - 5 * $age - 161;
    } else if ($gender == 'Male') {
        $BMR = 10 * $weight + 6.25 * $height - 5 * $age + 5;
    }
    $calories = $BMR;
    $userId = $_SESSION['userId'];


    $queryUserId = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$userId'");
    $count = mysqli_num_rows($queryUserId);





    if ($count == 0) {



        $query = mysqli_query($connect, "INSERT INTO health_profile (userId, height, weight, age, gender, calories) VALUES ('$userId', '$height', '$weight', '$age', '$gender', '$calories')");
        //$queryInsertCaloriesTable = mysqli_query($connect, "INSERT INTO daily_calories (calorieBMR) VALUES ('$calories')") or die('Invalid query: ' . mysqli_error($connect));
        if ($query) {

            echo "<script>
                              
                    swal('Profile updated', 'User profile successfully updated ', 'success');
                    $(document).click(function(e) {
                        window.location.href = '';
                     });
   
                  </script>";
        } else {
            echo "<script>swal('Error', 'The values were not recorded, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
    } else {

        $query = mysqli_query($connect, "UPDATE health_profile SET height='$height', weight='$weight', age='$age', gender='$gender', calories='$calories' WHERE userId='$userId'");

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
    }
}

function searchTask($taskNameSearch, $taskCategorySearch, $taskDescriptionSearch, $taskDeadlineSearchFrom, $taskDeadlineSearchTo, $taskLocationSearch, $taskImportanceSearch, $taskOrderUnitSearch, $taskOrderBySearch) {
    require 'db_connect.php';
//echo "<script>alert('$taskNameSearch')</script>;"; 
    $userId = $_SESSION['userId'];
    if ($taskNameSearch == '') {
        $taskNameQuery = "''";
    } else {
        $taskNameQuery = 'name';
    }

    if ($taskCategorySearch == '') {
        $taskCategoryQuery = "''";
    } else {
        $taskCategoryQuery = 'category';
    }

    if ($taskDescriptionSearch == '') {
        $taskDescriptionQuery = "''";
    } else {
        $taskDescriptionQuery = 'description';
    }

    if ($taskDeadlineSearchFrom == '' && $taskDeadlineSearchTo == '') {
        $taskDeadlineSearchFromQuery = "''";
    } else {
        $taskDeadlineSearchFromQuery = 'time';
    }

    if ($taskDeadlineSearchTo == '') {
        $taskDeadlineSearchTo = 2147483648;
    }

    if ($taskLocationSearch == '') {
        $taskLocationQuery = "''";
    } else {
        $taskLocationQuery = 'location';
    }

    if ($taskImportanceSearch == '') {
        $taskImportanceQuery = "''";
    } else {
        $taskImportanceQuery = 'importance';
    }

    if ($taskOrderUnitSearch == '') {
        $taskOrderUnitQuery = "";
    } else {
        $taskOrderUnitQuery = "name";
    }


    if ($taskOrderBySearch == 'Ascending') {
        $taskOrderBySearch = "ASC";
    } else if ($taskOrderBySearch == 'Descending') {
        $taskOrderBySearch = "DESC";
    }

    switch ($taskOrderUnitSearch) {
        case "Name":
            $taskOrderUnitSearch = "name";
            break;
        case "Description":
            $taskOrderUnitSearch = "description";
            break;
        case "Deadline":
            $taskOrderUnitSearch = "time";
            break;
        case "Location":
            $taskOrderUnitSearch = "location";
            break;
        case "Duration":
            $taskOrderUnitSearch = "duration";
            break;
        case "Reminder":
            $taskOrderUnitSearch = "reminderInput";
            break;
        case "Calories":
            $taskOrderUnitSearch = "calorieConsumption";
            $taskCategoryQuery = "category";
            $taskCategorySearch = "Health";
            break;
        default:
            $taskOrderUnitSearch = "";
    }

    //echo "<script>alert('$taskOrderUnitSearch')</script>;"
    //echo $taskDeadlineSearchFrom . " ". $taskDeadlineSearchTo;
    //echo "<script>alert('$taskDeadlineSearchFrom')</script>;"; 
    //echo "<script>alert('$taskDeadlineSearchTo')</script>;"; 
    $query = mysqli_query($connect, "SELECT id FROM tasks WHERE $taskNameQuery='$taskNameSearch' AND $taskCategoryQuery='$taskCategorySearch ' AND $taskDescriptionQuery='$taskDescriptionSearch'  AND $taskDeadlineSearchFromQuery BETWEEN '$taskDeadlineSearchFrom' AND  '$taskDeadlineSearchTo' AND $taskLocationQuery='$taskLocationSearch' AND $taskImportanceQuery='$taskImportanceSearch' AND userId='$userId' ORDER BY $taskOrderUnitSearch $taskOrderBySearch");
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        //$task = new Task($row['id']);
        if (!empty($result)) {
            ?>

            <div class="row">
                <div class="col-md-12">
                    <h3>Search Results</h3>
                    <div class="table-responsive">
                        <table id="searchTable" class="table table-bordred table-striped">
                            <thread >
                                <th >Name</th>
                                <th>Category</th>
                                <th >Description</th>
                                <th >Deadline</th>
                                <th >Location</th>
                                <th >Duration</th>
                                <th >Importance</th>
                                <th >Reminder</th>
                                <th >Calories</th>
                                <th >Edit</th>
                                <th >Delete</th>
                            </thread>





                            <?php
                            foreach ($result as $line) {
                                $task = new Task($line['id']);
                                $_SESSION['blabla'] = $line['id'];
                                ?>


                                <tr class="tableRow" id="<?php echo $task->id; ?>" >



                                    <?php if (strlen($task->name) > 32): ?>
                                        <td class="bigCellTd bigValue"><?php echo $task->name ?></td>
                                        <?php
                                    else:
                                        ?><td class="bigCellTd"><?php echo $task->name ?></td>
                                    <?php endif; ?>

                                    <td ><?php echo $task->category ?></td>
                                    <?php if (strlen($task->description) > 32): ?>
                                        <td class="bigCellTd bigValue"><?php echo $task->healthyActivity . " " . $task->description ?></td>
                                        <?php
                                    else:
                                        ?><td class="bigCellTd"><?php echo $task->healthyActivity . " " . $task->description ?></td>
                                    <?php endif; ?>

                                    <td ><?php echo $task->time ?></td>


                                    <?php if (strlen($task->location) > 32): ?>
                                        <td class="bigCellTd bigValue"><?php echo $task->location ?></td>
                                        <?php
                                    else:
                                        ?><td class="bigCellTd"><?php echo $task->location ?></td>
                                    <?php endif; ?>


                                    <td ><?php echo $task->duration ?></td>
                                    <td ><?php echo $task->importance ?></td>
                                    <td ><?php echo $task->reminderInput ?></td>
                                    <td> <?php echo $task->calories ?></td>


                                    <td><a class="btn btn-primary btn-xs editTaskBtn" data-title="Edit" data-toggle="modal" data-target="#editTask" href="php_functions/edit_task_modal.php?id=<?php echo $task->id; ?>"/><span class="glyphicon glyphicon-pencil"></span></a></td>

                                    <td><a class="btn btn-danger btn-xs deleteTaskTableBtn" data-title="Delete" data-toggle="modal" data-target="#deleteTask" ><span class="glyphicon glyphicon-trash"></span></a></td>


                                </tr>


                                <?php
                            }
                            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $("td, tr").resizable();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </script>-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <script>
                $("td").resizable();

                $('.editTaskBtn').click(function (e) {
                    var taskId = $(e.target).parents('tr').attr('id');

                });
            </script>

            <!-- delete task modal-->

            <div class="modal fade" id="deleteTask" tabindex="-1" role="dialog" >
                <div class='modal-dialog'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h4 class="modal-title custom_align" id="headingModal">Delete task</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Task?</div>
                            <input id="taskToDelete" type="hidden" value="">
                        </div>
                        <div class="modal-footer ">
                            <button id='deleteTaskBtn' name="deleteTaskBtn" type="button" class="btn btn-success pull-left" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                            <button id='cancelTaskBtn' name='cancelTaskBtn' type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>


                        </div>


                    </div>
                </div>
            </div>
            <!-- ajax delete task -->
            <script>

                $('.deleteTaskTableBtn').click(function (e) {
                    $('#taskToDelete').val($(e.target).parents('tr').attr('id'));
                });

                $('#deleteTaskBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "php_functions/delete_task.php",
                        data: {taskId: $('#taskToDelete').val()},
                        success: function (data) {

                            if (data.success) {
                                swal('Task deleted successfully', 'Task deleted from the database ', 'success');
                                $('#'+$('#taskToDelete').val()).remove();
                                $('#deleteTask').modal('hide');
                            } else {
                                swal('Error', 'Error occurred. Task was not deteled', 'error');
                                $('#deleteTask').modal('hide');
                            }

                        }
                    });
                });
            </script>
            <!--edit task modal-->
            <div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                    </div>
                    <!-- /.modal-content --> 
                </div>
                <!-- /.modal-dialog --> 
            </div>

            <script>
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                });
            </script>






            <?php
        } else {
//            echo "<script>swal('No tasks', 'No tasks were found ', 'warning');</script>";
        }
    } else {
        echo "<script>swal('Error', 'Search failed, error occurred ', 'error');</script>";
        die('Invalid query: ' . mysqli_error($connect));
    }
}

function computeCaloriesActivity($taskActivity, $taskDurationSeconds, $weight) {
    //echo "<script>alert('$taskActivity')</script>";
    //echo "<script>alert($taskDurationSeconds)</script>";
    //echo "<script>alert($weight)</script>";

    /* if (!empty($taskActivity) && $taskDurationSeconds != 0) {
      switch ($taskActivity) {
      case 'Badminton':
      $taskCalories = round(0.044 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Basketball':
      $taskCalories = round(0.063 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Bicycling (10 km/h)':
      $taskCalories = round(0.029 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Bicycling (15 km/h)':
      $taskCalories = round(0.045 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Bicycling (25 km/h)':
      $taskCalories = round(0.171 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Golf':
      $taskCalories = round(0.038 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Running (4 minutes per km)':
      $taskCalories = round(0.115 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Running (5 minutes per km)':
      $taskCalories = round(0.095 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Running (6 minutes per km)':
      $taskCalories = round(0.087 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Swimming, crawl, slow':
      $taskCalories = round(0.058 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Swimming, crawl, fast':
      $taskCalories = round(0.071 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Swimming, breast stroke, fast':
      $taskCalories = round(0.074 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Tennis':
      $taskCalories = round(0.114 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Table tennis':
      $taskCalories = round(0.031 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Walking, normal pace, asphalt road':
      $taskCalories = round(0.036 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Walking, normal pace, fields & hills':
      $taskCalories = round(0.037 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      case 'Volleyball':
      $taskCalories = round(0.023 * ($weight * 2.2046) * ($taskDurationSeconds / 60));
      break;
      default:
      $taskCalories = 0;
      }
      return $taskCalories;
      } else {
      return -1;
      } */
    if ($weight < 60) {
        $weightCategory = 0;
    } else {
        if ($weight >= 60 && $weight < 80) {
            $weightCategory = 1;
        } else {
            if ($weight >= 80 && $weight < 100) {
                $weightCategory = 2;
            } else {
                if ($weight >= 100 && $weight < 120) {
                    $weightCategory = 3;
                } else {
                    if ($weight >= 120 && $weight < 140) {
                        $weightCategory = 4;
                    } else {
                        if ($weight > 140) {
                            $weightCategory = 5;
                        }
                    }
                }
            }
        }
    }
    $activityMatch = array
        (
        array("Badminton", 0, 4.5),
        array("Badminton", 1, 5.57),
        array("Badminton", 2, 6.67),
        array("Badminton", 3, 7.73),
        array("Badminton", 4, 8.83),
        array("Badminton", 5, 9.9),
        array("Basketball", 0, 8),
        array("Basketball", 1, 9.93),
        array("Basketball", 2, 11.83),
        array("Basketball", 3, 13.77),
        array("Basketball", 15.67),
        array("Basketball", 5, 17.60),
        array("Bicycling 22-25 km/h", 0, 10),
        array("Bicycling 22-25 km/h", 1, 12.40),
        array("Bicycling 22-25 km/h", 2, 14.80),
        array("Bicycling 22-25 km/h", 3, 17.20),
        array("Bicycling 22-25 km/h", 4, 19.60),
        array("Bicycling 22-25 km/h", 5, 22),
        array("Bicycling 25-30 km/h", 0, 12),
        array("Bicycling 25-30 km/h", 1, 14.87),
        array("Bicycling 25-30 km/h", 2, 17.77),
        array("Bicycling 25-30 km/h", 3, 20.63),
        array("Bicycling 25-30 km/h", 4, 23.53),
        array("Bicycling 25-30 km/h", 5, 26.40),
        array("Bicycling +30 km/h", 0, 16.5),
        array("Bicycling +30 km/h", 1, 20.47),
        array("Bicycling +30 km/h", 2, 24.43),
        array("Bicycling +30 km/h", 3, 28.40),
        array("Bicycling +30 km/h", 4, 32.37),
        array("Bicycling +30 km/h", 5, 36.33),
        array("Golf", 0, 5.5),
        array("Golf", 1, 6.83),
        array("Golf", 2, 8.13),
        array("Golf", 3, 9.47),
        array("Golf", 4, 10.77),
        array("Golf", 5, 12.1),
        array("Running 4 minutes per km", 0, 14.5),
        array("Running 4 minutes per km", 1, 17.97),
        array("Running 4 minutes per km", 2, 21.47),
        array("Running 4 minutes per km", 3, 24.93),
        array("Running 4 minutes per km", 4, 28.43),
        array("Running 4 minutes per km", 5, 31.9),
        array("Running 5 minutes per km", 0, 12.5),
        array("Running 5 minutes per km", 1, 15.5),
        array("Running 5 minutes per km", 2, 18.5),
        array("Running 5 minutes per km", 3, 21.5),
        array("Running 5 minutes per km", 4, 24.5),
        array("Running 5 minutes per km", 5, 27.5),
        array("Running 6 minutes per km", 0, 10),
        array("Running 6 minutes per km", 1, 12.4),
        array("Running 6 minutes per km", 2, 14.8),
        array("Running 6 minutes per km", 3, 17.2),
        array("Running 6 minutes per km", 4, 19.6),
        array("Running 6 minutes per km", 5, 22),
        array("Swimming, crawl, slow", 0, 6),
        array("Swimming, crawl, slow", 1, 7.43),
        array("Swimming, crawl, slow", 2, 8.87),
        array("Swimming, crawl, slow", 3, 10.3),
        array("Swimming, crawl, slow", 4, 11.73),
        array("Swimming, crawl, slow", 5, 13.17),
        array("Swimming, crawl, fast", 0, 10),
        array("Swimming, crawl, fast", 1, 12.4),
        array("Swimming, crawl, fast", 2, 14.8),
        array("Swimming, crawl, fast", 3, 17.2),
        array("Swimming, crawl, fast", 4, 19.6),
        array("Swimming, crawl, fast", 5, 22),
        array("Swimming, breast stroke", 0, 11),
        array("Swimming, breast stroke", 1, 13.63),
        array("Swimming, breast stroke", 2, 16.27),
        array("Swimming, breast stroke", 3, 18.9),
        array("Swimming, breast stroke", 4, 21.53),
        array("Swimming, breast stroke", 5, 24.17),
        array("Tennis", 0, 7),
        array("Tennis", 1, 8.67),
        array("Tennis", 2, 10.37),
        array("Tennis", 3, 12.03),
        array("Tennis", 4, 13.73),
        array("Tennis", 5, 15.4),
        array("Table tennis", 0, 3.57),
        array("Table tennis", 1, 4.7),
        array("Table tennis", 2, 6.1),
        array("Table tennis", 3, 7.33),
        array("Table tennis", 4, 8.6),
        array("Table tennis", 5, 9.87),
        array("Walking, normal pace, asphalt road", 0, 3.6),
        array("Walking, normal pace, asphalt road", 1, 4.5),
        array("Walking, normal pace, asphalt road", 2, 5.8),
        array("Walking, normal pace, asphalt road", 3, 6.83),
        array("Walking, normal pace, asphalt road", 4, 7.93),
        array("Walking, normal pace, asphalt road", 5, 9.03),
        array("Walking, normal pace, fields & hills", 0, 6),
        array("Walking, normal pace, fields & hills", 1, 7.43),
        array("Walking, normal pace, fields & hills", 2, 8.87),
        array("Walking, normal pace, fields & hills", 3, 10.3),
        array("Walking, normal pace, fields & hills", 4, 11.73),
        array("Walking, normal pace, fields & hills", 5, 13.17),
        array("Volleyball inside", 0, 4),
        array("Volleyball inside", 1, 4.97),
        array("Volleyball inside", 2, 5.93),
        array("Volleyball inside", 3, 6.9),
        array("Volleyball inside", 4, 7.87),
        array("Volleyball inside", 5, 8.83),
        array("Volleyball water", 0, 3),
        array("Volleyball water", 1, 3.73),
        array("Volleyball water", 2, 4.43),
        array("Volleyball water", 3, 5.17),
        array("Volleyball water", 4, 5.87),
        array("Volleyball water", 5, 6.6)
    );
    if (!empty($taskActivity) && $taskDurationSeconds != 0) {
        for ($i = 0; $i < count($activityMatch); $i++) {
            if ($activityMatch[$i][0] == $taskActivity && $activityMatch[$i][1] == $weightCategory) {
                $taskCalories = $taskDurationSeconds / 60 * $activityMatch[$i][2];
                //$activityMatch[$i][$weightCategory];
            }
        }
    } else {
        return -1;
    }
    //echo $taskCalories;
    return $taskCalories;



    /* $taskDurationMinutes = $taskDurationSeconds/60;
      switch($taskActivity){
      case 'Badminton':
      switch($taskDurationMinuts){
      case '1':
      }
      }
      return $taskCalories; */
}

function statusUnset($caloriePerDay) {
    require 'db_connect.php';
    date_default_timezone_set('UTC');
    $userId = $_SESSION['userId'];
    $sumCalories = 0;

    /* $queryGetBMR = mysqli_query($connect, "SELECT calories FROM health_profile WHERE userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
      $queryResultBMR = mysqli_fetch_assoc($queryGetBMR);
      $resultBMR = $queryResultBMR['calories']; */

    $dateStart = strtotime(date("m/d/Y"));
    $dateEnd = strtotime(date("m/d/Y")) + 86399;
    echo $dateStart;
    $queryGetConsumptionToday = mysqli_query($connect, "SELECT calorieConsumption FROM tasks WHERE category='Health' AND finishTime BETWEEN '$dateStart' AND '$dateEnd' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
    //$queryResultGetConsumptionToday = mysqli_fetch_assoc($queryGetConsumptionToday);

    while ($rowCalorieSum = mysqli_fetch_assoc($queryGetConsumptionToday)) {
        $resultCalorieSum[] = $rowCalorieSum;
    }

    foreach ($resultCalorieSum as $sum) {
        $sumCalories = $sumCalories + $sum['calorieConsumption'];
    }


    $queryCheckDuplicate = mysqli_query($connect, "SELECT * FROM daily_calories WHERE unixDay = '$dateStart' AND userId='$userId'")or die('Invalid query: ' . mysqli_error($connect));
    $rowCheckDuplicate = mysqli_num_rows($queryCheckDuplicate);
    if ($rowCheckDuplicate == 0) {
        $calorieBurnedSession = $_SESSION['burnedCalories'];
        $queryAdd = mysqli_query($connect, "INSERT INTO daily_calories (userId ,calorieEat, calorieTarget, calorieBurned, unixDay) VALUES  ('$userId','$caloriePerDay','$sumCalories','$calorieBurnedSession','$dateStart')");
    } else {
        $queryUpdate = mysqli_query($connect, "UPDATE daily_calories SET calorieEat='$caloriePerDay' WHERE unixDay = '$dateStart' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
    }


    if ($queryAdd || $queryUpdate) {
        echo "<script>window.location.href = '';</script>";
    } else {

        echo "<script>swal('Error', 'Submit failed, error occurred ', 'error');</script>";
        die('Invalid query: ' . mysqli_error($connect));
    }
}
?>


