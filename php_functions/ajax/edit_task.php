<?php



$taskEditId = $_POST['taskEditFlag'];
$taskEditName = $_POST['taskName'];
$taskEditCategory = $_POST['taskCategory'];
$taskEditActivity = $_POST['taskActivity'];
$taskEditDescription = $_POST['taskDescription'];
$taskEditLocation = $_POST['taskLocation'];
$taskEditImportance = $_POST['taskImportance'];
require '/../db_connect.php';

$queryUpdate = mysqli_query($connect, "UPDATE tasks SET name = '$taskEditName', category = '$taskEditCategory',healthyActivity = '$taskEditActivity' ,description = '$taskEditDescription', location = '$taskEditLocation',importance = '$taskEditImportance'    WHERE id = '$taskEditId' ");
if ($queryUpdate)
    $response = array('success'=>true);
else
    $response = array('success'=>false);

header('Content-type: application/json');
echo json_encode($response);
?>
