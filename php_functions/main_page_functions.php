
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
        $this->activityLevel = $row['activityLevel'];
        $this->calories = $row['calories'];
    }

}

class DailyCalories {

    public $id;

    function __construct($id) {
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
        $query = mysqli_query($connect, "SELECT * FROM daily_calories WHERE userId='$id'") or die('Invalid query: ' . mysqli_error($connect));
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

function computeCalories($userId, $height, $weight, $age, $gender, $activityLevel) {
    require 'db_connect.php';


    if ($gender == 'Female') {
        $BMR = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
    } else if ($gender == 'Male') {
        $BMR = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
    }

    if ($activityLevel == 'Sedentary') {
        $calories = $BMR + $BMR * 0.2;
    } else if ($activityLevel == 'Light') {
        $calories = $BMR + $BMR * 0.375;
    } else if ($activityLevel == 'Medium') {
        $calories = $BMR + $BMR * 0.55;
    } else if ($activityLevel == 'Heavy') {
        $calories = $BMR + $BMR * 0.725;
    }

    $userId = $_SESSION['userId'];


    $queryUserId = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$userId'");
    $count = mysqli_num_rows($queryUserId);





    if ($count == 0) {



        $query = mysqli_query($connect, "INSERT INTO health_profile (userId, height, weight, age, gender, activityLevel, calories) VALUES ('$userId', '$height', '$weight', '$age', '$gender', '$activityLevel', '$calories')");
        //$queryInsertCaloriesTable = mysqli_query($connect, "INSERT INTO daily_calories (calorieBMR) VALUES ('$calories')") or die('Invalid query: ' . mysqli_error($connect));
        if ($query) {

            echo "<script>
                                swal(title: 'Profile updated',text: 'Health profile successfully updated ',type: 'success' );
                                window.location.href = '';
                            </script>";
        } else {
            echo "<script>swal('Error', 'The values were not recorded, error occurred ', 'error');</script>";
            die('Invalid query: ' . mysqli_error($connect));
        }
    } else {

        $query = mysqli_query($connect, "UPDATE health_profile SET height='$height', weight='$weight', age='$age', gender='$gender', activityLevel='$activityLevel', calories='$calories' WHERE userId='$userId'");

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
                            <thread>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Deadline</th>
                                <th>Location</th>
                                <th>Duration</th>
                                <th>Importance</th>
                                <th>Reminder</th>
                                <th>Calories</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thread>

                            <tbody>     
                            <script>


                            </script>




                            <?php
                            foreach ($result as $line) {
                                $task = new Task($line['id']);
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

                                    
                                    <td><button id="editTaskBtn" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#editTask" /><span class="glyphicon glyphicon-pencil"></span></button></td>
                              
                                <td><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteTask" ><span class="glyphicon glyphicon-trash"></span></button></td>

                                </tr>
                                <script>

                                </script>





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
            </script>

            <!-- delete task modal-->

            <div class="modal fade" id="deleteTask" tabindex="-1" role="dialog" area-hidden="true">
                <div class='modal-dialog'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h4 class="modal-title custom_align" id="headingModal">Delete task</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Task?</div>

                        </div>
                        <div class="modal-footer ">
                            <button id='deleteTaskBtn' name="deleteTaskBtn" type="button" class="btn btn-success pull-left" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                            <button id='cancelTaskBtn' name='cancelTaskBtn' type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>

                            <script>
                                $('#deleteTaskBtn').click(function () {

                                    var id = $('.tableRow').attr('id');
                                    //alert(id);


                                    $.ajax({
                                        type: "POST",
                                        url: "php_functions/delete_task.php",
                                        data: 'taskId=' + id,
                                        success: function (data) {

                                            if (data == 1) {

                                                swal('Task deleted successfully', 'Task deleted from the database ', 'success');
                                                $('.confirm').click(function () {
                                                    window.location.href = "";
                                                });

                                            } else {
                                                swal('Error', 'Error occurred. Task was not deteled', 'error');
                                                $('.confirm').click(function () {
                                                    window.location.href = "";
                                                });
                                            }

                                        }
                                    });


                                });
                            </script>
                        </div>


                    </div>
                </div>
            </div>

            <!--edit task modal-->

            <div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h3 class="modal-title custom_align bold_text" id="Heading">Edit task</h3>
                        </div>

                        <div class="modal-body">
                            <div class='row'><form
                                <form id="editTaskForm" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="taskNameEdit" class="col-md-3 control-label pull-left">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control pull-left" id="taskNameEdit" name="taskNameEdit" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label class="col-md-3 control-label pull-left" for="taskCategoryEdit">Category</label>
                                        <div class="col-md-9" id="taskCategoryDiv" >   
                                            <select class="form-control selectpicker" id="taskCategoryEdit" name="taskCategoryEdit">
                                                <option  data-icon="glyphicon glyphicon-briefcase">Work</option>
                                                <option data-icon="glyphicon glyphicon-user">Personal</option>
                                                <option data-icon="glyphicon glyphicon-heart">Health</option>
                                            </select>                                                       

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label pull-left" for="taskCActivityEdit">Activity</label>
                                        <div class="col-md-4">   
                                            <select class="form-control selectpicker " id="taskActivityEdit" name="taskActivity" >
                                                <option>Badminton</option>
                                                <option>Basketball</option>
                                                <option>Bicycling (10 km/h)</option>
                                                <option>Bicycling (15 km/h)</option>
                                                <option>Bicycling (25 km/h)</option>
                                                <option>Golf</option>
                                                <option>Running (4 minutes per km)</option>
                                                <option>Running (5 minutes per km)</option>
                                                <option>Running (6 minutes per km)</option>
                                                <option>Swimming, crawl, slow</option>
                                                <option>Swimming, crawl, fast</option>
                                                <option>Swimming, breast stroke, fast</option>
                                                <option>Tennis</option>
                                                <option>Table tennis</option>
                                                <option>Walking, normal pace, asphalt road</option>
                                                <option>Walking, normal pace, fields & hills</option>
                                                <option>Volleyball</option>


                                            </select>                                                       
                                        </div>


                                    </div>

                                    <div class='form-group'>
                                        <label for="taskDescription" class="col-md-3 control-label pull-left">What to do?</label>
                                        <div class="col-md-9">


                                            <textarea id="taskDescriptionEdit" name="taskDescriptionEdit" class="js-auto-size form-control" rows="1"></textarea>
                                            <script>
                                                $('textarea.js-auto-size').textareaAutoSize();
                                            </script>
                                        </div>
                                    </div>    

                                    <div class='form-group'>
                                        <label for="datetimepickerWhenEdit" class="col-md-3 control-label pull-left">When?</label>
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#datetimepickerWhenEdit').datetimepicker();
                                            });
                                        </script>

                                        <div class='col-md-9 pull-left'>
                                            <input type='text' class="form-control" id='datetimepickerWhenEdit' name='datetimepickerWhenEdit'  />
                                        </div>    
                                    </div>   

                                    <div class='form-group'>
                                        <label for="taskLocationEdit" class="col-md-3 control-label pull-left">Where?</label>
                                        <div class='col-md-9 pull-left'>
                                            <input id="locationEdit" class='form-control pull-left' name="taskLocationEdit" placeholder=""  type="text"/>
                                        </div>
                                    </div> 

                                    <div class='form-group'>
                                        <label for="taskDurationEdit" class="col-md-3 control-label">Duration</label>
                                        <div class="col-md-9 pull-left">
                                            <script type="text/javascript">
                                                $(function () {
                                                    var dateNow = new Date('1/1/1970 00:00:00');
                                                    $('#datetimepickerDurationEdit').datetimepicker({
                                                        defaultDate: dateNow,
                                                        format: ' HH:mm '
                                                    });
                                                });
                                            </script>
                                            <div class='input-group date' id='datetimepickerDurationEdit' >
                                                <input id="taskDurationEdit"  name="taskDurationEdit" type='text' class="form-control" value='' />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>                   
                                        </div>
                                    </div> 
                                    <div class='form-group'>
                                        <label for="taskImportanceEdit" class="col-md-3 control-label pull-left">Importance</label>
                                        <div class="col-md-3">
                                            <select name="taskImportanceEdit" id="taskImportanceEdit" class="selectpicker form-control" >
                                                <option class="taskImportanceLow">Low</option>
                                                <option class="taskImportanceMedium">Medium</option>
                                                <option class="taskImportanceHigh">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label for="taskReminder" class="col-md-3 control-label">Reminder</label>

                                        <div class="col-md-2">
                                            <input type="text" class="form-control pull-left" id="taskReminderInput" name="taskReminderInput1" >
                                        </div>
                                        <div id="taskReminderUnitDiv" class="col-md-3 " onclick="reminderUnit()" >
                                            <select class="selectpicker form-control " name="taskReminderUnit" id="taskReminderUnit" >
                                                <option value="1" >Minutes</option>
                                                <option value="2">Hours</option>
                                                <option value="3">Days</option>
                                            </select>


                                        </div> 
                                    </div>    
                                    <div class="modal-footer ">
                                        <button id="updateTaskBtn" name="updateTaskBtn" type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- /.modal-content --> 
                </div>
                <!-- /.modal-dialog --> 
            </div>
           

            
   


            <?php
        } else {
            echo "<script>swal('No tasks', 'No tasks were found ', 'warning');</script>";
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
    if (!empty($taskActivity) && $taskDurationSeconds != 0) {
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
    }
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
    if($rowCheckDuplicate==0){
    $calorieBurnedSession = $_SESSION['burnedCalories'];
        $queryAdd = mysqli_query($connect, "INSERT INTO daily_calories (userId ,calorieEat, calorieTarget, calorieBurned, unixDay) VALUES  ('$userId','$caloriePerDay','$sumCalories','$calorieBurnedSession','$dateStart')");
    }else{
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


