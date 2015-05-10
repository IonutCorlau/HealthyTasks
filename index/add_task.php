<div class="container">
    <header>
        <h2>Add Task</h2>
    </header>
</div>

<div class="container" >
    <div class="row">
        <form id="addTask" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="taskName" class="col-md-2 control-label">Name</label>
                <div class="col-md-10">
                    <input type="text" class="form-control pull-left" id="taskName" name="taskName">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="taskCategory">Category</label>
                <div class="col-md-2" >   
                    <select class="form-control selectpicker" id="taskCategory" name="taskCategory">
                        <option data-icon="glyphicon glyphicon-briefcase">Work</option>
                        <option data-icon="glyphicon glyphicon-user">Personal</option>
                        <option data-icon="glyphicon glyphicon-heart">Health</option>
                    </select>                                                       
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    
                    var categoryValue = $( "#taskCategory" ).val();
                        //alert(categoryValue);
                 
                });
            </script>
            <div class="form-group">
                <label class="col-md-2 control-label" for="taskCActivity">Activity</label>
                <div class="col-md-4">   
                    <select class="form-control selectpicker " id="taskActivity" name="taskActivity" >
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

            <div class="form-group">
                <label for="taskDescription" class="col-md-2 control-label">What to do?</label>
                <div class="col-md-10">


                    <textarea id="taskDescription" name="taskDescription" class="js-auto-size form-control" rows="1"></textarea>
                    <script>
                        $('textarea.js-auto-size').textareaAutoSize();
                    </script>
                </div>
            </div> 
            <div class="form-group">
                <label for="datetimepickerWhen" class="col-md-2 control-label">When?</label>
                <script type="text/javascript">
                    $(function () {
                        $('#datetimepickerWhen').datetimepicker();
                    });
                </script>
                <div class='col-md-10 pull-left'>
                    <input type='text' class="form-control" id='datetimepickerWhen' name='datetimepickerWhen'  />
                </div>             
            </div>
            <div class="form-group">
                <label for="taskLocation" class="col-md-2 control-label">Where?</label>
                <div class='col-md-10'>
                    <input id="autocomplete" class='form-control pull-left' name="taskLocation" placeholder=""  onFocus="geolocate()" type="text"/>
                </div>
            </div>
            <div class="form-group">
                <label for="taskDuration" class="col-md-2 control-label">Duration</label>
                <div class="col-md-10">
                    <script type="text/javascript">
                        $(function () {
                            var dateNow = new Date('1/1/1970 00:00:00');
                            $('#datetimepickerDuration').datetimepicker({
                                defaultDate: dateNow,
                                format: ' HH:mm '
                            });
                        });
                    </script>
                    <div class='input-group date' id='datetimepickerDuration' >
                        <input id="taskDuration"  name="taskDuration" type='text' class="form-control" value='' />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>                   
                </div>
            </div>       
            <div class="form-group">
                <label for="taskImportance" class="col-md-2 control-label">Importance</label>
                <div class="col-md-2">
                    <select class="selectpicker form-control" name="taskImportance" id="taskImportance">
                        <option class="taskImportanceLow">Low</option>
                        <option class="taskImportanceMedium">Medium</option>
                        <option class="taskImportanceHigh">High</option>
                    </select>
                </div>
            </div>   

            <div class="form-group ">
                <label for="taskReminder" class="col-md-2 control-label">Reminder</label>

                <div class="col-md-2">
                    <input type="text" class="form-control pull-left" id="taskReminderInput" name="taskReminderInput1" >
                </div>
                <div id="taskReminderUnitDiv" class="col-md-2 " onclick="reminderUnit()" >
                    <select class="selectpicker form-control " name="taskReminderUnit" id="taskReminderUnit" >
                        <option value="1" >Minutes</option>
                        <option value="2">Hours</option>
                        <option value="3">Days</option>
                    </select>


                </div>    
            </div>
            <script>
                function reminderUnit() {

                    var unit = document.getElementById("taskReminderUnit");
                    var unitSelected = unit.options[unit.selectedIndex].value;

                    var input = document.getElementById('taskReminderInput');

                    if (unitSelected == 1) {

                        input.name = 'taskReminderInput1';
                    }
                    else if (unitSelected == 2) {
                        input.name = 'taskReminderInput2';

                    }
                    else if (unitSelected == 3) {
                        input.name = 'taskReminderInput3';
                    }

                }

            </script>
            <div class="form-group">
                <label class="col-md-2 "></label>
                <div class="col-md-10 ">

                    <button class="btn btn-success btn-lg pull-left" name="submitAddTask" id="submitAddTask" type="submit"  >
                        <i class="glyphicon glyphicon-check"></i>Add task
                    </button>
                    <span></span>
                    <button class="btn btn-danger btn-lg pull-left" name="cancelAddTask" id="cancelAddTask" type="reset">
                        <i class="glyphicon glyphicon-remove"></i>Cancel
                    </button>
                </div>
            </div>


        </form>
    </div>
</div>
<?php
if (isset($_POST['submitAddTask'])) {
    $taskName = $_POST['taskName'];
    $taskCategory = $_POST['taskCategory'];
    $taskDescription = $_POST['taskDescription'];
    $taskDate = $_POST['datetimepickerWhen'];

    $taskLocation = $_POST['taskLocation'];
    $taskDuration = $_POST['taskDuration'];
    $taskImportance = $_POST['taskImportance'];
    if(isset($_POST['taskActivity'])){
        $taskActivity = $_POST['taskActivity'];
    }else{
       $taskActivity=""; 
    }
    
    
    //echo "<script>alert('$taskActivity')</script>";
    
    $taskReminder = 0;
    $reminderUnit = $_POST['taskReminderUnit'];
    if (isset($_POST['taskReminderInput1'])) {
        $reminderInput = $_POST['taskReminderInput1'];
    } else if (isset($_POST['taskReminderInput2'])) {
        $reminderInput = $_POST['taskReminderInput2'];
    } else if (isset($_POST['taskReminderInput3'])) {
        $reminderInput = $_POST['taskReminderInput3'];
    }

    if ($reminderUnit == 1) {
        $taskReminder = $reminderInput * 60;
    } else if ($reminderUnit == 2) {
        $taskReminder = $reminderInput * 3600;
    } else if ($reminderUnit == 3) {
        $taskReminder = $reminderInput * 86400;
    }

    addTask($_SESSION['userId'], $taskName, $taskCategory, $taskDescription, $taskDate, $taskLocation, $taskDuration, $taskImportance, $taskReminder, $taskActivity);
}
?>