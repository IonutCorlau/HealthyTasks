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
                <div class="col-md-2">   
                    <select class="form-control" id="taskCategory" name="taskCategory">
                        <option>Work</option>
                        <option>Personal</option>
                        <option>Health</option>
                    </select>                                                       
                </div>
            </div>
            <div class="form-group">
                <label for="taskDescription" class="col-md-2 control-label">What to do?</label>
                <div class="col-md-10">
                  
                    <textarea  class="form-control"  id="taskDescription" name="taskDescription"></textarea>
                    
                </div>
            </div> 
            <div class="form-group">
                <label for="amount" class="col-md-2 control-label">When?</label>
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
                        <option>Low</option>
                        <option>Medium</option>
                        <option>High</option>
                    </select>
                </div>
            </div>   
            <div class="form-group">
                <label class="col-md-2 "></label>
                <div class="col-md-10 ">

                    <button class="btn btn-success btn-lg pull-left" name="submitAddTask" id="submitAddTask" type="submit" onclick="fakeLoaderFunction(1000);">
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


    addTask($_SESSION['userId'], $taskName, $taskCategory, $taskDescription, $taskDate, $taskLocation, $taskDuration, $taskImportance);
    
}
?>