<style>
     #searchTable th {
        text-align: center !important;
    }
    .tableSeachGlyphicon .glyphicon{
        margin-right: 0px !important;
    }

    #taskTimeSearch{
        margin-top:10px !important;

    }
   
</style>
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
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="taskNameSearch" class="col-md-2 control-label">Name</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskNameSearch" name="taskNameSearch" type="text" autocomplete="off"/>
                                    <br><div id="suggestionName" ></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categorySearch" class="col-md-2 control-label">Category</label>
                                <div class="col-md-2">
                                    <select class="form-control " id="taskCategorySearch" name="taskCategorySearch">
                                        <option>Work</option>
                                        <option>Personal</option>
                                        <option>Health</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descriptionSearch" class="col-md-2 control-label">What to do?</label>
                                <div class="col-md-9">
                                    <textarea id="taskDescriptionSearch" name="taskDescriptionSearch" class="js-auto-size-search form-control" rows="1"></textarea>

                                    <script>
                                        $('textarea.js-auto-size-search').textareaAutoSize();
                                    </script>
                                    <br><div id="suggestionDescrition"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datetimepickerWhenSearch" class="col-md-2 control-label">Between</label>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepickerWhenSearchFromDiv').datetimepicker();
                                    });
                                </script>

                                <div class='col-md-4'>
                                    <div class='input-group date ' id='datetimepickerWhenSearchFromDiv' >
                                        <input type='text' class="form-control" id='datetimepickerWhenSearchFrom' name='datetimepickerWhenSearchFrom' />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepickerWhenSearchToDiv').datetimepicker();
                                    });
                                </script>
                                <div class="col-md-1">

                                </div>
                                <div class='col-md-4 '>
                                    <div class='input-group date ' id='datetimepickerWhenSearchToDiv'>
                                        <input type='text' class="form-control" id='datetimepickerWhenSearchTo' name='datetimepickerWhenSearchTo'/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>


                                <div class='col-md-9'>
                                    <input id='taskTimeSearch' name='taskTimeSearch' type='text' class='form-control' />
                                    <br><div id="suggestionTime"></div>
                                </div>


                            </div>

                            <div class="form-group">
                                <label form="taskLocationSearch" class="col-md-2 control-label">Where?</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskLocationSearch" name="taskLocationSearch" type="text" />
                                    <br><div id="suggestionLocation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label form="taskImportanceSearch" class="col-md-2 control-label">Importance</label>
                                <div class="col-md-2">
                                    <select class="form-control " id="taskImportanceSearch" name="taskImportanceSearch">
                                        <option>Low</option>
                                        <option>Medium</option>
                                        <option>High</option>
                                    </select>

                                </div>
                            </div>



                            <div class="col-md-4 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>Search</button>
                                <button type="reset" class="btn btn-danger" onclick="cancelSearch()"><span class="glyphicon glyphicon-remove" ></span>Cancel</button>
                                <script>
                                    function cancelSearch() {
                                        var searchDiv = document.getElementById("searchTaskDropdown");
                                        searchDiv.className = 'dropdown dropdown-md';


                                    }
                                </script>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
/* date_default_timezone_set('UTC');
  $timeFrom = strtotime($_POST['datetimepickerWhenSearchFrom']);
  $timeTo = strtotime($_POST['datetimepickerWhenSearchTo']);
  $time = 'ionut';
  echo $timeFrom . " " . $timeTo;
 */
?>


<script>
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


<div class='row'>
    <div class='col-md-12'>
        <h3>Search Results</h3>

        <div class='table-responsive'>
            <table id='searchTable' class='able table-bordred table-striped'>
                <thread>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Importance</th>
                    <th>Reminder</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thread>
                <tbody>
                    <tr>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#editTask" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteTask" ><span class="glyphicon glyphicon-trash"></span></button></p></td>

                    </tr>
                    <tr>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#editTask" ><span class="glyphicon glyphicon-pencil "></span></button></p></td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteTask" ><span class="glyphicon glyphicon-trash "></span></button></p></td>

                    </tr>
                    <tr>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td>Ionut</td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#editTask" ><span class="glyphicon glyphicon-pencil "></span></button></p></td>
                        <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteTask" ><span class="glyphicon glyphicon-trash "></span></button></p></td>

                    </tr>

                </tbody>

            </table>
        </div>
    </div>
</div>


