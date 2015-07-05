<?php 
$taskId = $_POST['taskId'];
require 'db_connect.php';

$query = mysqli_query($connect, "DELETE FROM tasks WHERE id='$taskId'");
if ($query)
    $response = array('success'=>true);
else
    $response = array('success'=>false);

header('Content-type: application/json');
echo json_encode($response);
?>