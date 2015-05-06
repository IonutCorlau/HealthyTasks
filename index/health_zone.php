
<?php
$healthProfile = new HealthProfile($_SESSION['userId']);

?>

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
                    <input id="height" name="height" class="form-control pull-left" type="text" data-slider-min="140" data-slider-max="210" data-slider-step="1" data-slider-value="<?php echo $healthProfile->height ?>" data-slider-orientation="horizontal"/>

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

                    <input id="weight" name="weight" class="form-control pull-left" type="text" data-slider-min="45" data-slider-max="110" data-slider-step="1" data-slider-value="<?php echo $healthProfile->weight ?>" data-slider-orientation="horizontal"/>

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

                    <input id="age" name="age" class="form-control pull-left" type="text" data-slider-min="16" data-slider-max="80" data-slider-step="1" data-slider-value="<?php echo $healthProfile->age ?>" data-slider-orientation="horizontal"/>
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
                    <script>
                        $(document).ready(function () {
                            $('#gender option[value=<?php echo $healthProfile->gender; ?>]').attr('selected', 'selected');

                        });
                    </script>
                    <select id="gender" name="gender" class="form-control selectpicker">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    </select>
                </div>
            </div>
            <div class="form-group">

                <label for="activityLevel" class="col-md-2 control-label">Activity</label>
                <div class="col-md-2">
                    <script>
                        $(document).ready(function () {
                            $('#activityLevel option[value=<?php echo $healthProfile->activityLevel; ?>]').attr('selected', 'selected');


                        });
                    </script>
                    <select id="activityLevel" name="activityLevel" class="form-control selectpicker" >
                        <option value="Sedentary" data-subtext="e.g. I'm bedridden">Sedentary</option>
                        <option value="Light" data-subtext="e.g. an office worker">Light</option>
                        <option value="Medium" data-subtext="e.g. a professional cleaner">Medium</option>
                        <option value="Heavy" data-subtext="e.g. a construction worker">Heavy</option>
                    </select>

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-8">
                    <button name="computeCaloriesSubmit" id="computeCaloriesSubmit" type="submit" class="btn btn-success btn-lg pull-left"  >
                        <i class="glyphicon glyphicon-scale"></i>Compute calories
                    </button>

                    <span></span>
                    <button name="computeCaloriesCancel" id="computeCaloriesCancel" type="submit" class="btn btn-danger btn-lg pull-left" >
                        <i class="glyphicon glyphicon-remove"></i>Cancel
                    </button>
                    <br>

                </div>
            </div>
            <div class="col-md-12">
                <?php
                require '/../php_functions/db_connect.php';
                $userId = $_SESSION['userId'];
                $queryUserId = mysqli_query($connect, "SELECT * FROM health_profile WHERE userId='$userId'");
                $count = mysqli_num_rows($queryUserId);
                
                

                if ($count == 0) {
                    echo "<p>You didn't configure you profile yet</p>";
                } else {
                    echo "<p>You need <span id='displayCalories'>$healthProfile->calories</span> calories daily in order to mentain your weight</p>";
                }
                ?>


            </div>
<?php
require_once 'php_functions/main_page_functions.php';
if (isset($_POST['computeCaloriesSubmit'])) {

    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $activityLevel = $_POST['activityLevel'];

    if ($height == 0 || $weight == 0 || $age == 0) {
        echo "<script>swal('No enough modifications', 'Please modify fields height, weight and age', 'warning');</script>";
    } else {

        computeCalories($_SESSION['userId'], $height, $weight, $age, $gender, $activityLevel);
    }
} else if (isset($_POST['computeCaloriesCancel'])) {
   echo "<script>
                                window.location.href = '#health_zone'; 
                            
                            </script>";
}
?>


        </form>
    </div>


</div>