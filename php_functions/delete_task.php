<?php
$taskId = $_POST['taskId'];
require 'db_connect.php';
$query = mysqli_query($connect, "DELETE FROM tasks WHERE id='$taskId'");
if($query){
    
    echo 1;
    
}else{
    echo 0;
}

?>

