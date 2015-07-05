<?php

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
        $this->unix = $row['time'];

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

$taskId = $_GET['id'];
$task = new Task($taskId);

$categories = [
    'Work',
    'Personal',
    'Health'
];

$activities = [
    'Badminton',
    'Basketball',
    'Bicycling 22-25 km/h',
    'Bicycling 25-30 km/h',
    'Bicycling +30 km/h',
    'Golf',
    'Running 4 minutes per km',
    'Running 5 minutes per km',
    'Running 6 minutes per km',
    'Swimming, crawl, slow',
    'Swimming, crawl, fast',
    'Swimming, breast stroke',
    'Tennis',
    'Table tennis',
    'Walking, normal pace, asphalt road',
    'Walking, normal pace, fields & hills',
    'Volleyball inside'
];
$importanceList = [
    'Low',
    'Medium',
    'High'
];
?>


<script>
//$('#updateActivity').prop('disabled', true);
   // $(window).load(function () {
        
        if($('#updateCategory').val() !== "Health"){
            
        
        
        $('#updateActivity').val(' ');
        setTimeout(function () {
            //$('#updateActivity').attr('disabled');
            
            $('#updateActivity').prop('disabled', true);
            
        }, 500);
    }
      $('#updateCategory').change(function () {
            if ($(this).val() !== "Health"){
                $('#updateActivity').prop('disabled', true);
                $('#updateActivity').val(' ');
                
                
            }
          else{
                $('#updateActivity').prop('disabled', false);
                $('#updateActivity').val('Badminton');
            }
        });
   // });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
    <h3 class="modal-title custom_align bold_text" id="Heading">Edit task</h3>
</div>
<div class="modal-body">
    <div class='row'>
        <form id="editTaskForm" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="taskNameEdit" class="col-md-3 control-label pull-left">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control pull-left" id="taskNameEdit" name="taskNameEdit" value="<?php echo $task->name ?>">
                </div>
            </div>

            <div class="form-group">

                <label class="col-md-3 control-label pull-left" for="taskCategoryEdit">Category</label>
                <div class="col-md-5" id="taskCategoryDiv" >   
                    <script>
                        $('#taskCategoryEdit').attr('selected', 'value');
                    </script>
                    <select class="form-control selectpicker" id='updateCategory' data-id="taskCategoryEdit" name="taskCategoryEdit" title='Choose one of the following...'>
                        <?php
                        foreach ($categories as $category) {
                            if ($category == $task->category)
                                echo "<option selected>" . $category . "</option>";
                            else
                                echo "<option>" . $category . "</option>";
                        }
                        ?>
                    </select>                                                       

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label pull-left" for="tasCActivityEdit">Activity</label>
                <div class="col-md-5">   
                    <select class="form-control selectpicker " id='updateActivity' data-id="taskActivityEdit" name="taskActivity" >

                        <?php
                        foreach ($activities as $activity) {
                            if ($activity == $task->healthyActivity)
                                echo "<option selected>" . $activity . "</option>";
                            else
                                echo "<option>" . $activity . "</option>";
                        }
                        ?>
                    </select>                                                       
                </div>


            </div>

            <div class='form-group'>
                <label for="taskDescription" class="col-md-3 control-label pull-left">What to do?</label>
                <div class="col-md-9">


                    <textarea id="taskDescriptionEdit" name="taskDescriptionEdit" class=" form-control" rows="2" style=""><?php echo $task->description ?></textarea>
                    <script>
                        $('textarea.js-auto-size').textareaAutoSize();
                    </script>
                </div>
            </div>    

            <!--<div class='form-group'>
                <label for="datetimepickerWhenEdit" class="col-md-3 control-label pull-left">When?</label>


                <div class='col-md-9 pull-left'>
                    <input type='text' class="form-control" id='datetimepickerWhenEdit' name='datetimepickerWhenEdit' value="" />
                </div>    
                <script type="text/javascript">

                    $(function () {
                    $('#datetimepickerWhenEdit').datetimepicker();                </script>
            </div> -->


            <div class='form-group'>
                <label for="taskLocationEdit" class="col-md-3 control-label pull-left">Where?</label>
                <div class='col-md-9 pull-left'>
                    <input id="locationEdit" class='form-control pull-left' name="taskLocationEdit" placeholder=""  type="text" value="<?php echo $task->location ?>"/>
                </div>
            </div> 

            <!--<div class='form-group'>
                <label for="taskDurationEdit" class="col-md-3 control-label">Duration</label>
                <div class="col-md-9 pull-left">

                    <div class='input-group date' id='datetimepickerDurationEdit' >
                        <input id="taskDurationEditInput"  name="taskDurationEditInput" type='text' class="form-control" value="<?php echo $task->duration ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                        <script type="text/javascript">
                                    $(function () {
                                    var dateNow = new Date('1/1/1970 00:00:00');
                                            $('#datetimepickerDurationEdit').datetimepicker({
                                    defaultDate: dateNow,
                                            format: ' HH:mm '
                                    });
                                    });                        </script>
                    </div>                   
                </div>
            </div> -->
            <div class='form-group'>
                <label for="taskImportanceEdit" class="col-md-3 control-label pull-left">Importance</label>
                <div class="col-md-3">
                    <select name="taskImportanceEdit" id="taskImportanceEdit" class="selectpicker form-control" >
                        <?php
                        foreach ($importanceList as $importance) {
                            if ($importance == $task->importance)
                                echo "<option selected>" . $importance . "</option>";
                            else
                                echo "<option>" . $importance . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer ">
                <button id="updateTaskBtn" type="button" name="updateTaskBtn"  class="btn btn-warning btn-lg" style="width: 100%;"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
            </div>

            <script>
                var $initTaskForm = $('#editTaskForm').clone();
                var flag = 0;
                $('#updateTaskBtn').click(function () {
                    console.log("<?php echo $taskId ?>");
                    //var $taskForm = $('#editTaskForm');
                    //if ($initTaskForm.find('#taskNameEdit').val() == $taskForm.find('#taskNameEdit').val())
                    //console.log('bb');

                    // swal('No modifications were found', '', 'warning');
                    //else

                    $.ajax({
                        type: "POST",
                        url: "php_functions/ajax/edit_task.php",
                        data: {taskEditFlag: "<?php echo $taskId ?>", taskName: $('#taskNameEdit').val(), taskCategory: $('#updateCategory').val(), taskActivity: $('#updateActivity').val(), taskDescription: $('#taskDescriptionEdit').val(), taskLocation: $('#locationEdit').val(), taskImportance: $('#taskImportanceEdit').val()},
                        success: function (data) {
                            if (data.success) {
                                swal('Task updated successfully', '', 'success');
                                //$('#' + $('#taskToDelete').val()).remove();
                                $('#editTask').modal('hide');
                                location.reload();

                            } else {
                                swal('Error', 'Error occurred. Task was not updated', 'error');
                                $('#editTask').modal('hide');
                            }

                        }
                    });

                });</script>

        </form>
    </div>
</div>

<?php
if (isset($_POST['updateTaskBtn'])) {
    
}
?>