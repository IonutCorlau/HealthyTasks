<?php

function checkTasks() {

    require 'db_connect.php';
    date_default_timezone_set('UTC');

    $userId = $_SESSION['userId'];
    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE userId='$userId' ORDER BY finishTime ASC");
  
    $numRows = mysqli_num_rows($query);
    
    if($numRows > 0){
    
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        if (!empty($result)) {

            foreach ($result as $task) {
                $finishTaskTime[] = $task['finishTime'];
            }
        }
        foreach ($finishTaskTime as $finishTaskTimeVar) {
            if ($finishTaskTimeVar > 86340 &&  $finishTaskTimeVar < time()+10800){ //+ 3 hours to GTN timezone
               
                //passedTask();
            }
        }
    }
    //passedTask(); 

    
}

function passedTask() {
    //echo "<script>alert('bla')</script>";
    ?>

    <script type="text/javascript">
        $(window).load(function () {
            $('#basicModal').modal('show');
        });
    </script>  
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <h3>Modal Body</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <?php

}
?>

