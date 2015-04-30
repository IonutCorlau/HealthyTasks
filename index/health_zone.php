

<div class="container">
    <header>
        <h2>Health Zone</h2>
    </header>
</div>

<div class="container">
    <div class='row'>
        <form id="computeCalories" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group ">
                <label for="height" class="col-md-2 control-label ">Height</label>
                <div class="col-md-10 ">
                    <input id="height" class="form-control pull-left" type="text" data-slider-min="150" data-slider-max="210" data-slider-step="1" data-slider-value="170" data-slider-orientation="horizontal"/>
                </div>
                <script>
                    $("#height").slider({
                        //reversed: true
                    });
                </script>
            </div>
            <div class="form-group">
                <label for="weight" class="col-md-2 control-label">Weight</label>
                <div class="col-md-10 ">

                    <input id="weight" class="form-control pull-left" type="text" data-slider-min="45" data-slider-max="110" data-slider-step="1" data-slider-value="70" data-slider-orientation="horizontal"/>

                </div>
                <script>
                    $("#weight").slider({
                        //reversed: true
                    });
                </script>

            </div>
            <div class="form-group">
                <label for="age" class="col-md-2 control-label">Age</label>
                <div class="col-md-10">

                    <input id="age" class="form-control pull-left" type="text" data-slider-min="16" data-slider-max="80" data-slider-step="1" data-slider-value="20" data-slider-orientation="horizontal"/>
                    <script>
                        $("#age").slider({
                            //reversed: true
                        });
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="col-md-2 control-label">Gender</label>
                <div class="col-md-2">
                    <select id="gender" name="gender" class="form-control selectpicker">
                        <option>Female</option>
                        <option>Male</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="activityLevel" class="col-md-2 control-label">Activity</label>
                <div class="col-md-2">
                    <select id="activityLevel" name="activityLevel" class="form-control selectpicker">
                        <option data-subtext="e.g. I'm bedridden">Sedentary</option>
                        <option data-subtext="e.g. an office worker">Light</option>
                        <option data-subtext="e.g. a professional cleaner">Medium</option>
                        <option data-subtext="e.g. a construction worker">Heavy</option>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker();
                    </script>
                </div>
            </div>
            <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-8">
                        <button name="computeCaloriesSubmit" id="computeCaloriesSubmit" type="submit" class="btn btn-success btn-lg pull-left"  onclick="fakeLoaderFunction(3000);">
                            <i class="glyphicon glyphicon-scale"></i>Compute calories
                        </button>

                        <span></span>
                        <button id="computeCaloriesCancel" type="reset" class="btn btn-danger btn-lg pull-left" >
                            <i class="glyphicon glyphicon-remove"></i>Cancel
                        </button>
                        <br>

                    </div>
            </div>



        </form>
    </div>


</div>