<?php
$userId = $_SESSION['userId'];
date_default_timezone_set('UTC');
$currentDate = strtotime(date("m/d/Y"));

$dailyCalories = new DailyCalories($userId, $currentDate);
$calorieNeedToBurn = $dailyCalories->calorieEat - $dailyCalories->calorieBMR - $dailyCalories->calorieBurned;
?>
<div class="container">
    <br>
    <div class="row">
        <form id="healthStatus" class="form-horizontal col-md-12" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <span class="col-md-9 text-left pull-left">Your target for today is <b class="bold_text"><?php echo $dailyCalories->calorieEat ?></b> calories. </span>

                <div class="col-md-3">
                    <button id='modifyCalorieEat' name='modifyCalorieEat' class='btn btn-primary pull-left' type='submit'>
                        <span id='faIcon' class='fa fa-eraser'></span>Modify estimation
                    </button>
                </div>
            </div>
            <?php
            if (!empty($dailyCalories->calorieBMR)):
                ?>

                <div class="form-group">
                    <span class="col-md-9 text-left pull-left">You need only <b class="bold_text"><?php echo $dailyCalories->calorieBMR ?></b> calories in order to maintain your current body weight.</span>
                </div>

            <?php else: ?>
                <div class='form-group'>
                    <span class="col-md-9 text-left pull-left">You didn't compute your health profile</span>
                    <div class='col-md-3'>
                        <button id='statusGoHealthProfile' name='statusGoHealthProfile' class='btn btn-primary pull-left' type='submit'>
                            <span id='faIcon' class='fa fa-heart'></span>Compute Now
                        </button>
                    </div>
                </div>

            <?php endif; ?>
            <div class="form-group">
                <span class="col-md-9 text-left pull-left">  <b class="bold_text"><?php echo $dailyCalories->calorieTarget ?></b> calories will be burned from today's remained healthy activities.</span>
                <div class="col-md-3 ">



                    <button  id="searchHealtyTasksToday"  name="searchHealtyTasksToday" class="btn btn-success pull-left" type="submit" >
                        <span class="glyphicon glyphicon-eye-open"></span> See them
                    </button>
                    <button  id="cancelHealtyTasksToday"  name="cancelHealtyTasksToday" class="btn btn-danger pull-left " type="submit" >
                        <span class="glyphicon glyphicon-remove"></span> Hide
                    </button>
                </div>
            </div>
            <?php if($calorieNeedToBurn>0):?>
                <div class="form-group">

                    <span class="col-md-9 text-left pull-left">You still need to burn <b class="bold_text text-danger"><?php echo $calorieNeedToBurn ?></b> calories.</span>
                    <div class="col-md-3">
                        <button  id="seeScheduleStatus"  name="seeScheduleStatus" class="btn btn-success pull-left " type="submit" >
                            <span class="glyphicon glyphicon-calendar"></span>Schedule
                        </button>
                        <button  id="cancelScheduleStatus"  name="cancelScheduleStatus" class="btn btn-danger pull-left " type="submit" >
                            <span class="glyphicon glyphicon-remove"></span> Hide
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group">

                    <span class="col-md-9 text-left pull-left">You burned <b class="bold_text text-success"><?php echo abs($dailyCalories->calorieEat - $dailyCalories->calorieBMR - $dailyCalories->calorieTarget) ?></b> more calories then you need in order to maintain your weight.</span>
                    <div class="col-md-3">
                        <button  id="seeScheduleStatus"  name="seeScheduleStatus" class="btn btn-success pull-left " type="submit" >
                            <span class="glyphicon glyphicon-calendar"></span>Schedule
                        </button>
                        <button  id="cancelScheduleStatus"  name="cancelScheduleStatus" class="btn btn-danger pull-left " type="submit" >
                            <span class="glyphicon glyphicon-remove"></span> Hide
                        </button>
                    </div>
                    
                </div>
            <?php endif; ?>
            
            
            
            <br>
            <div class="form-group">
                <span class="col-md-9 text-left pull-left">Already burned <b class="bold_text"><?php echo $dailyCalories->calorieBurned ?></b> calories from healthy activities of today.</span>
            </div>
            
            <div class="progress">
                <?php
                    $progressBarWidth=round(($dailyCalories->calorieBurned*100)/ ($dailyCalories->calorieEat - $dailyCalories->calorieBMR));
                    //echo $dailyCalories->calorieBurned;
                    if( $progressBarWidth  < 100):
                ?>
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="1" style="width: <?php echo $progressBarWidth ?>%;">
                        <?php echo $progressBarWidth.'%' ?>
                    </div>
                <?php else: ?>
                    <div class="progress-bar"  role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="1" style="width: 100%;background-color:#4CAE4C;">
                        <?php echo '100%' ?>
                    </div>
                <?php endif; ?>
            </div>


        </form>
    </div>
    <p>
        <small>
            When the progress bar is full you have done enough healthy tasks in order to not gain weight.  
        </small>
    </p>

</div>
<?php
if (isset($_POST['searchHealtyTasksToday'])) {
    echo "<script>
            fakeLoaderFunction(200);
            window.location.href = '#status';
        </script>";
    date_default_timezone_set('UTC');
    $dateStart = strtotime(date("m/d/Y"));
    $dateEnd = strtotime(date("m/d/Y")) + 86399;

    searchTask("", "Health", "", "$dateStart", "$dateEnd", "", "", "Deadline", "Ascending");
}
if (isset($_POST['cancelHealtyTasksToday'])) {
    echo "<script>
            
            window.location.href = '#status';
        </script>";
}
if (isset($_POST['statusGoHealthProfile'])) {
    echo "<script>
            fakeLoaderFunction(200);
            window.location.href = '#health_zone';
        </script>";
}
if (isset($_POST['modifyCalorieEat'])) {
    $query = mysqli_query($connect, "UPDATE daily_calories SET calorieEat=0 WHERE userId='$userId'"); 
    //require('status_unset.php');
    if($query){
        echo "<script>
                fakeLoaderFunction(200);
                window.location.href = '';
            </script>";
    }else{
        echo "<script>swal('Error', 'Cannot perform this operation ', 'error');</script>";
        die("Invalid query: " . mysqli_error($connect));
    }
}
if (isset($_POST['seeScheduleStatus'])) {
    echo "<script>
            fakeLoaderFunction(200);
            window.location.href = '#status';
        </script>";
    date_default_timezone_set('UTC');
    $dateStart = strtotime(date("m/d/Y"));
    $dateEnd = strtotime(date("m/d/Y")) + 86399;
    searchTask("", "", "", "$dateStart", "$dateEnd", "", "", "Deadline", "Ascending");
}
if (isset($_POST['cancelScheduleStatus'])) {
    echo "<script>
            
            window.location.href = '#status';
        </script>";
}
?>