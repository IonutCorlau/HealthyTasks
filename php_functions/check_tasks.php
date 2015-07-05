


<?php

function checkTasks() {

    require 'db_connect.php';
    date_default_timezone_set('UTC');

    $userId = $_SESSION['userId'];
    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE userId='$userId' ORDER BY finishTime ASC");

    $numRows = mysqli_num_rows($query);

    if ($numRows > 0) {

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }

        if (!empty($result)) {

            foreach ($result as $task) {
                $finishTaskTime[] = $task['finishTime'];
            }
        }
        foreach ($finishTaskTime as $finishTaskTimeVar) {
            if ($finishTaskTimeVar > 86340 && $finishTaskTimeVar < time() + 10800) { //+ 3 hours to GTN timezone
                $queryTaskId = mysqli_query($connect, "SELECT id FROM tasks WHERE finishTime='$finishTaskTimeVar' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
                $rowId = mysqli_fetch_assoc($queryTaskId);

                passedTask($rowId['id'], $finishTaskTimeVar);
                echo $finishTaskTimeVar;
                ?>
                <script>
                    $(window).load(function () {
                        $('#checkTaskModal').modal('show');
                    });
                </script>
                <?php
            }
        }
        //passedTask(24); 
    }
}

function passedTask($taskId, $finishTaskTimeVar) {
    require 'db_connect.php';
    //date_default_timezone_set('Europe/Bucharest');
    $currentTime = time() + 3600 * 3; //local time
    $task = new Task($taskId);

    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE id='$taskId' ") or die('Invalid query: ' . mysqli_error($connect));

    if ($query) {
        $row = mysqli_fetch_assoc($query);
    }
    $timePassed = convertTime($currentTime - ($row['time'] + $row['duration']));
    ?>


    <div class="modal fade" id="checkTaskModal" tabindex="-1" role="dialog" aria-labelledby="checkTaskModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h3 class="modal-title text-center bold_text" id="ckeckTaskModalLabel">Check task</h3>
                </div>

                <div class="modal-body">


                    <p class="text-center"><span class="bold_text"><?php echo $task->name ?> </span> was finished for <span class="bold_text"><?php echo $timePassed; ?> </span></p>

                </div>


                <div class="modal-footer ">
                    <form id="checkTaskForm" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <button id="checkTaskDone" name="checkTaskDone" type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span>Task Done!</button>                  
                            </div>
                            <div class="col-md-3">
                                <button id="checkTaskDetay" name="checkTaskDetay" type="submit" class="btn btn-warning " ><span class="glyphicon glyphicon-hourglass"></span>Remind later</button>
                                
                                <script>
                                    $('#checkTaskDetay').click(function(){
                                       alert(bla); 
                                    });
                                 </script>
         
                            </div>
                            <div class="col-md-3">
                                <button id="checkTaskDetails" name="checkTaskDetails" type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-tasks"></span>Details</button>
                            </div>
                            <div class="col-md-3">
                                <button id="checkTaskDelete" name="checkTaskDelete" type="submit" class="btn btn-danger " ><span class="glyphicon glyphicon-trash"></span>Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php
    if (isset($_POST['checkTaskDone'])) {
        
        echo "<script>$('#checkTaskModal').modal('hide');</script>";
        require 'db_connect.php';
        $userId = $_SESSION['userId'];
        
        if ($task->category == 'Health') {
            $dayStart = strtotime(date("m/d/Y"));
            $queryGetCalories = mysqli_query($connect, "SELECT calorieBurned FROM daily_calories WHERE unixDay = '$dayStart' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));
            $rowGetCalories = mysqli_fetch_assoc($queryGetCalories);
            $calorieBurnedBefore = $rowGetCalories['calorieBurned'];
            $calorieBurnedThisTask = $row['calorieConsumption'];
            $calorieBurnedAfter = $calorieBurnedBefore + $calorieBurnedThisTask;

            //echo "<script>alert()</script>";

            $queryCountRow = mysqli_query($connect, "SELECT * FROM daily_calories WHERE unixDay='$dayStart' AND userId='$userId'") or die('Invalid query: ' . mysqli_error($connect));

            $rowCount = mysqli_num_rows($queryCountRow);

            if ($rowCount != 0) {


                $querySetCalories = mysqli_query($connect, "UPDATE daily_calories SET calorieBurned='$calorieBurnedAfter' WHERE userId = '$userId'") or die('Invalid query: ' . mysqli_error($connect));
                deleteTask($taskId);
                //echo "<script>window.location.href=''</script>";
            } else {
                $_SESSION['burnedCalories'] = $_SESSION['burnedCalories'] + $calorieBurnedThisTask;
                deleteTask($taskId);
            }
            //$calorieBurnedStatusUnset = $_SESSION['burnedCalories'];
            //echo "<script>alert($calorieBurnedStatusUnset)</script>";
            //$calorieAlreadyConsumed = 
        } else {
            deleteTask($taskId);
        }
        //$queryGetCalories = 
        //$queryDelete = mysqli_query($connect, "DELETE FROM tasks WHERE id='$taskId'");
    } else

    if (isset($_POST['checkTaskDetails'])) {
        //echo "<script>alert('bla')</script>";
        ?>
        <div class="modal fade" id="detailsTaskModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" id='closeDetailsTask' class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h3 class="modal-title custom_align bold_text text-center" id="Heading">Task Details</h3>
                    </div>

                    <div class="modal-body">
                        <div class='row'>
                            <form id="editTaskForm" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="taskNameEdit" class="col-md-3 control-label pull-left">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control pull-left" id="taskNameEdit" name="taskNameEdit" value="<?php echo $task->name ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="col-md-3 control-label pull-left" for="taskCategoryEdit">Category</label>
                                    <div class="col-md-3" id="taskCategoryDiv" >   
                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->category ?>" disabled>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label pull-left" for="taskCActivityEdit">Activity</label>
                                    <div class="col-md-9">   
                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->healthyActivity ?>" disabled>                                              
                                    </div>


                                </div>

                                <div class='form-group'>
                                    <label for="taskDescription" class="col-md-3 control-label pull-left">What to do?</label>
                                    <div class="col-md-9">
                                       
                                        <textarea rows=2 class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" disabled><?php echo $task->description ?>" </textarea>                           
                                    </div>
                                </div>    

                                <div class='form-group'>
                                    <label for="datetimepickerWhenEdit" class="col-md-3 control-label pull-left">When?</label>

                                    
                                    <div class='col-md-9 pull-left'>
                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->time ?>" disabled>                             
                                    </div>    
                                </div>   

                                <div class='form-group'>
                                    <label for="taskLocationEdit" class="col-md-3 control-label pull-left">Where?</label>
                                    <div class='col-md-9 pull-left'>
                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->location ?>" disabled>  
                                    </div>
                                </div> 

                                <div class='form-group'>
                                    <label for="taskDurationEdit" class="col-md-3 control-label">Duration</label>
                                    <div class="col-md-3 pull-left">

                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->duration ?>" disabled>               
                                    </div>
                                </div> 
                                <div class='form-group'>
                                    <label for="taskImportanceEdit" class="col-md-3 control-label pull-left">Importance</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control pull-left" id="tasCategoryEdit" name="taskCategotyEdit" value="<?php echo $task->importance ?>" disabled> 
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for="taskReminder" class="col-md-3 control-label">Reminder</label>

                                    <div class="col-md-3">
                                        <input type="text" class="form-control pull-left" id="taskReminderInput" name="taskReminderInput1" value="<?php echo $task->reminderInput; ?>" disabled >
                                    </div>

                                </div>   
                                <div class='form-group'>
                                    <label for="taskReminder" class="col-md-3 control-label">Calories</label>

                                    <div class="col-md-3">
                                        <input type="text" class="form-control pull-left" id="taskReminderInput" name="taskReminderInput1" value="<?php echo $task->calories; ?>" disabled >
                                    </div>

                                </div>

                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <script>

            $(window).load(function () {
                $('#checkTaskModal').modal('hide');
                $('#detailsTaskModal').modal('show');
            });
            $('#closeDetailsTask').click(function () {
                $('#checkTaskModal').modal('hide');
            });


        </script>

        <?php
    } else
    if (isset($_POST['checkTaskDelete'])) {
        deleteTask($taskId);
    } else
    if (isset($_POST['checkTaskDetay'])) {

        delayTask($taskId);
    }
}

function convertTime($time) {
    if ($time >= 0 && $time < 3600) {

        $timeReadable = date("i", $time) . ' Minutes';
    } else if ($time >= 3600 && $time < 86400) {
        $timeReadable = date('h', $time) . ' Hours and ' . date('i', $time) . ' Minutes';
        //$timeReadable = (date("d", $time)-1).' Days and '.date("h:i", $time).' Hours';
    } else if ($time >= 86400 && $time <= 2592000) {
        $timeReadable = (date("d", $time) - 1) . ' Days, ' . date("h", $time) . ' Hours and ' . date("i", $time) . ' Minutes';
    }

    return $timeReadable;
}

function deleteTask($taskId) {
    require 'db_connect.php';
    $queryDeleteTask = mysqli_query($connect, "DELETE FROM tasks WHERE id='$taskId'");
    if ($queryDeleteTask) {
        echo "<script>
            //$('#checkTaskModal').modal('hide');
            $('#checkTaskModal').remove();
            location.reload();
            //swal('Task deleted successfullyii', 'Task deleted from the database ', 'success');
            //$('.confirm').click(function () {
            //$('#checkTaskModal').modal('hide');
              // setTimeout(function() {
   
   //window.location='';
  //}, 5000);
           // });
        </script>";
    } else {
        echo "<script>swal('Error', 'Delete failed, error occurred ', 'error');</script>";
        die('Invalid query: ' . mysqli_error($connect));
    }
}

function delayTask($taskId) {
    require 'db_connect.php';

    //header("Location: http://http://localhost/healthytasks/index.php");
    //$queryDelayGet = mysqli_query($connect, "SELECT finishTime FROM tasks WHERE id='$taskId'") or die('Invalid query: ' . mysqli_error($connect));
    //$result = mysqli_fetch_assoc($queryDelayGet);
    //$updatedFinishTime = $result['finishTime'] + 30;
    $updatedFinishTime = time() + 10800 + 600;
    $queryDelayPut = mysqli_query($connect, "UPDATE tasks SET finishTime = '$updatedFinishTime' WHERE id='$taskId'") or die('Invalid query: ' . mysqli_error($connect));
    echo "<script>
              window.location.href = ' ';
            
                            </script>";
}
?>
      

