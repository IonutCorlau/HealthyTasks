<?php
    $dailyCalories = new DailyCalories($_SESSION['userId']);
?>
<div class="container">
    <br>
    <div class="row">
       <form id="healthStatus" class="form-horizontal col-md-12" method="post" enctype="multipart/form-data">
           <div class="form-group">
                <span class="col-md-9 text-left"> You will loose <b class="bold_text"><?php echo $dailyCalories->calorieTarget ?></b> calories from today programmed healthy activities.</span>
                <div class="col-md-3 ">
                    
                    
                    
                    <button  id="searchHealtyTasksToday"  name="searchHealtyTasksToday" class="btn btn-success pull-left" type="submit" >
                            <span class="glyphicon glyphicon-eye-open"></span> See them
                    </button>
                    <button  id="cancelHealtyTasksToday"  name="cancelHealtyTasksToday" class="btn btn-danger pull-left " type="submit" >
                            <span class="glyphicon glyphicon-remove"></span> Hide
                    </button>
                </div>
           </div>
           <div class="form-group">
               <span class="col-md-9 text-left">You need to burn <b class="bold_text"><?php echo $dailyCalories->calorieBMR ?></b> calories in order to mentain your current weight.</span>
           </div>
       </form>
    </div>
    
</div>
<?php

if(isset($_POST['searchHealtyTasksToday'])){
    echo "<script>
            fakeLoaderFunction(1000);
            window.location.href = '#status';
        </script>";
    date_default_timezone_set('UTC');
    $dateStart = strtotime(date("m/d/Y"));
    $dateEnd = strtotime(date("m/d/Y"))+ 86399; 
    
    searchTask("", "Health", "", "$dateStart", "$dateEnd", "", "", "Deadline", "Ascending");
    
}
if(isset($_POST['cancelHealtyTasksToday'])){
     echo "<script>
            
            window.location.href = '#status';
        </script>";
}

?>