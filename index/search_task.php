<script type="text/javascript">
$(document).ready(function () {
        $(function () {
            $('#datetimepickerWhenSearchToDiv').datetimepicker();
        });
        $(function () {
            $('#datetimepickerWhenSearchFromDiv').datetimepicker();
        });
    });

    $(document).ready(function () {
        $("#taskNameSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskName=' + $("#taskNameSearch").val(),
                success: function (data) {

                    $("#suggestionName").show();
                    $("#suggestionName").html(data);

                }
            });
        });
    });

    function selectTaskName(val) {
        $("#taskNameSearch").val(val);
        $("#suggestionName").hide();
    }

    $(document).ready(function () {
        $("#taskDescriptionSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskDescrition=' + $("#taskDescriptionSearch").val(),
                success: function (data) {

                    $("#suggestionDescrition").show();
                    $("#suggestionDescrition").html(data);

                }
            });
        });
    });

    function selectTaskDescrition(val) {
        $("#taskDescriptionSearch").val(val);
        $("#suggestionDescrition").hide();
    }

    $(document).ready(function () {
        $("#taskLocationSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskLocation=' + $("#taskLocationSearch").val(),
                success: function (data) {

                    $("#suggestionLocation").show();
                    $("#suggestionLocation").html(data);

                }
            });
        });
    });

    function selectTaskLocation(val) {
        $("#taskLocationSearch").val(val);
        $("#suggestionLocation").hide();
    }

    $(document).ready(function () {
        //var timeFromJs = document.getElementById("datetimepickerWhenSearchFrom").value;

        var dateVar = $("#datetimepickerWhenSearchFrom").datetimepicker("getDate").getTime() / 1000;
        var dateVar = $("#datetimepickerWhenSearchFrom").val();

        $(" #datetimepickerWhenSearchTo").blur(function () {

            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: {timeFrom: "$('#datetimepickerWhenSearchFrom').val()", timeTo: bla},
                success: function (data) {
                    //alert($("#datetimepickerWhenSearchFrom").datetimepicker("getDate").getTime() / 1000);
                    $("#suggestionTime").show();
                    $("#suggestionTime").html(data);

                }
            });
        });
    });

    function selectTaskTime(val) {

        $("#taskTimeSearch").val(val);
        $("#suggestionName").hide();
    }
    
</script>
<div class="container">
    <header>
        <h2>Search Task</h2>
    </header>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="input-group input-group-btn" id="adv-search">
            <div id="searchTaskButtonDiv" class="btn-group col-md-12" role="group">
                <div id="searchTaskDropdown" class="dropdown dropdown-md " >
                    <button type="button" id="searchTaskButtton" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown" ><span class="glyphicon glyphicon-search"></span>Search<span class="caret pull-right "></span></button>
                    <div id="searchTaskDropdown" class="dropdown-menu col-md-12" role="menu">
                        <form id="searchTaskForm" class="form-horizontal"  method="post" action="" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label for="taskNameSearch" class="col-md-2 control-label" >Name</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskNameSearch" name="taskNameSearch" type="text" autocomplete="off"/>
                                    <br><div id="suggestionName" ></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categorySearch" class="col-md-2 control-label">Category</label>
                                <div class="col-md-2">
                                    <select class="form-control " id="taskCategorySearch" name="taskCategorySearch">
                                        <option selected disabled hidden value=''></option>
                                        <option>Work</option>
                                        <option>Personal</option>
                                        <option>Health</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descriptionSearch" class="col-md-2 control-label">What to do?</label>
                                <div class="col-md-9">
                                    <textarea id="taskDescriptionSearch" name="taskDescriptionSearch" class="js-auto-size-search form-control" rows="1" ></textarea>

                                    <script>
                                        $('textarea.js-auto-size-search').textareaAutoSize();
                                    </script>
                                    <br><div style="word-wrap: normal;" id="suggestionDescrition"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datetimepickerWhenSearch" class="col-md-2 control-label">Between</label>



                                <div class='col-md-4'>
                                    <script type="text/javascript">

                                    </script>
                                    <div class='input-group date ' id='datetimepickerWhenSearchFromDiv' >

                                        <input type='text' class="form-control" id='datetimepickerWhenSearchFrom' name='datetimepickerWhenSearchFrom' />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class='col-md-4'>
                                    <div class='input-group date ' id='datetimepickerWhenSearchToDiv'>
                                        <input type='text' class="form-control" id='datetimepickerWhenSearchTo' name='datetimepickerWhenSearchTo'/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label form="taskLocationSearch" class="col-md-2 control-label">Where?</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskLocationSearch" name="taskLocationSearch" type="text" autocomplete="off"/>
                                    <br><div id="suggestionLocation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label form="taskImportanceSearch" class="col-md-2 control-label">Importance</label>
                                <div class="col-md-2">
                                    <select class="form-control " id="taskImportanceSearch" name="taskImportanceSearch">
                                        <option selected disabled hidden value=''></option>
                                        <option>Low</option>
                                        <option>Medium</option>
                                        <option>High</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label form="taskOrderUnitSearch" class="col-md-2 control-label">Order by</label>
                                <div class="col-md-3">
                                    <select class="form-control " id="taskOrderUnitSearch" name="taskOrderUnitSearch">

                                        <option>Name</option>

                                        <option>Description</option>
                                        <option>Deadline</option>
                                        <option>Location</option>
                                        <option>Duration</option>

                                        <option>Reminder</option>
                                        <option>Calories</option>
                                    </select>

                                </div>


                                <div class="col-md-3">
                                    <select class="form-control " id="ttaskOrderBySearch" name="taskOrderBySearch">

                                        <option>Ascending</option>
                                        <option>Descending</option>

                                    </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div id="buttonsSearch" class="col-md-4  ">
                                    <button id="submitSearch" name="submitSearch" type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search" aria-hidden="true" ></span>Search</button>
                                    <button type="reset" class="btn btn-danger" onclick="cancelSearch()"><span class="glyphicon glyphicon-remove" ></span>Cancel</button>
                                    <script>
                                        function cancelSearch() {
                                            var searchDiv = document.getElementById("searchTaskDropdown");
                                            searchDiv.className = 'dropdown dropdown-md';
                                        }
                                    </script>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
require_once 'php_functions/main_page_functions.php';
if (isset($_POST['submitSearch'])) {
    ?>
    <script type="text/javascript">

        $(document).ready(function () {
            fakeLoaderFunction(1000);
            //window.location = "http://localhost/healthytasks/main_page.php#search_task";

        });

    </script>
    <?php
    date_default_timezone_set('UTC');

    $taskNameSearch = $_POST['taskNameSearch'];
    if (isset($_POST['taskCategorySearch'])) {
        $taskCategorySearch = $_POST['taskCategorySearch'];
    } else {
        $taskCategorySearch = '';
    }
    $taskDescriptionSearch = $_POST['taskDescriptionSearch'];
    $taskDeadlineSearchFrom = strtotime($_POST['datetimepickerWhenSearchFrom']);
    $taskDeadlineSearchTo = strtotime($_POST['datetimepickerWhenSearchTo']);
    $taskLocationSearch = $_POST['taskLocationSearch'];

    if (isset($_POST['taskImportanceSearch'])) {
        $taskImportanceSearch = $_POST['taskImportanceSearch'];
    } else {
        $taskImportanceSearch = '';
    }

    if (isset($_POST['taskOrderUnitSearch'])) {
        $taskOrderUnitSearch = $_POST['taskOrderUnitSearch'];
    } else {
        $taskOrderUnitSearch = '';
    }
    if (isset($_POST['taskOrderBySearch'])) {
        $taskOrderBySearch = $_POST['taskOrderBySearch'];
    } else {
        $taskOrderBySearch = '';
    }

    searchTask($taskNameSearch, $taskCategorySearch, $taskDescriptionSearch, $taskDeadlineSearchFrom, $taskDeadlineSearchTo, $taskLocationSearch, $taskImportanceSearch, $taskOrderUnitSearch, $taskOrderBySearch);
    ?>

    <?php
}



/* date_default_timezone_set('UTC');
  $timeFrom = strtotime($_POST['datetimepickerWhenSearchFrom']);
  $timeTo = strtotime($_POST['datetimepickerWhenSearchTo']);
  $time = 'ionut';
  echo $timeFrom . " " . $timeTo;
 */
?>





