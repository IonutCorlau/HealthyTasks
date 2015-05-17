<div class="container">
    <header>
        <h2>Status</h2>


    </header>

</div>

<?php
    require '/../../php_functions/db_connect.php';
    date_default_timezone_set('UTC');
    $currentDate = strtotime(date("m/d/Y"));
    if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
    
    //$dailyCalories = new DailyCalories($_SESSION['userId']);
    
    
    $query = mysqli_query($connect, "SELECT userId,calorieEat FROM daily_calories WHERE unixDay = '$currentDate' AND userId = '$userId'") or die('Invalid query: ' . mysqli_error($connect)); ;
    $row = mysqli_fetch_assoc($query);
    $count = mysqli_num_rows($query);
    if( $row['calorieEat'] != 0){
        
            require('status_set.php');
        
        //echo "bla";
    }else{
        require('status_unset.php');
    }
    }
?>