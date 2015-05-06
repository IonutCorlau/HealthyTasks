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
                    <button type="button" id="searchTaskButtton" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown" ><span class="glyphicon glyphicon-search"></span>Search<span class="caret"></span></button>
                    <div id="searchTaskDropdown" class="dropdown-menu col-md-12" role="menu">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="taskNameSearch" class="col-md-2 control-label">Name</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskNameSearch" name="taskNameSearch" type="text" />
                                    <div id="suggesstionName"></div>
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
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datetimepickerWhenSearch" class="col-md-2 control-label">When</label>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepickerWhenSearch').datetimepicker();
                                    });
                                </script>
                                <div class='col-md-9 pull-left'>
                                    <input type='text' class="form-control" id='datetimepickerWhenSearch' name='datetimepickerWhenSearch'  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label form="taskLocationSearch" class="col-md-2 control-label">Where?</label>
                                <div class="col-md-9">
                                    <input class="form-control pull-left" id="taskLocationSearch" name="taskLocationSearch" type="text" />
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
                                    function cancelSearch(){
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
<script>
$(document).ready(function(){
	$("#taskNameSearch").keyup(function(){
		$.ajax({
		type: "POST",
		url: "readTasks.php",
		data:'taskName='+$(this).val(),
		beforeSend: function(){
			$("#taskNameSearch").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstionName").show();
			$("#suggesstionName").html(data);
			$("#taskNameSearch").css("background","#FFF");
		}
		});
	});
});
function selecttaskName(val) {
$("#taskNameSearch").val(val);
$("#suggesstionName").hide();
}
</script>
