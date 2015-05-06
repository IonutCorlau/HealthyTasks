<?php
 require 'db_connect.php';
if(!empty($_POST['taskName'])){
    $query = mysqli_query($connect, "SELECT * FORM tasks WHERE name like '" . $_POST["taskName"] . "%' ORDER BY country_name LIMIT 0,6");
    $result = mysqli_fetch_assoc($query);
    
    if(!empty($result)){
?>
        <ul id="taskNameList">
<?php
    foreach($result as $taskName){
?>
            <li onlick="selectTaskName()"></li>
    }
                
    }
}
?>
