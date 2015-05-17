<div class="container">
    <br>
    <div class="row">
         
        <form id="calorieEatForm"  class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="calorieEatInput" class="col-md-8 control-label" >How many calories do you propose to eat today?</label> 
                <div class="col-md-2">
                    <input id="calorieEatInput" name="calorieEatInput" type="text" class="form-control pull-left" autocomplete="off" />
                </div>    
            </div>
            <div class="form-group">
                <div class="col-md-2 col-md-offset-5">
                    <button  id="submitEatCalories"  class="btn btn-success btn-lg" name="submitEatCalories" type="submit">
                        <span class="glyphicon glyphicon-ok"></span>Submit
                    </button>
                </div>
            </div>
        </form>
    </div> 
    
    
</div>

<?php

if(isset($_POST['calorieEatInput'])){
    echo "<script>
            fakeLoaderFunction(1000);
        </script>";
    $caloriePerDay =  $_POST['calorieEatInput'];
    
    statusUnset($caloriePerDay);
}
?>
