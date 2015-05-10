
<style>
    .taskReadTextarea{
        border: solid 1px rgba(0,0,0,0.15);
        padding-left:10px;
        cursor: pointer;
        height: 50px;
        max-height: 100px;
        font-size: 14px;
    }
    .taskReadListUl{
        border: solid 1px rgba(0,0,0,0.15);
        padding-left:10px;
        cursor: pointer;
    }
</style>
<?php
require '/../db_connect.php';
/* if( !empty($_POST['timeTo']) && !empty($_POST['timeFrom'])){
  $timeTo = $_POST['timeTo'];
  $timeFrom =$_POST['timeFrom'];

  $test=$_POST['timeTo'];

  $timeFromUnix = strtotime($timeFrom);
  //$timeToUnix = strtotime($timeTo);

  /*if(empty($_POST['timeFrom'])){
  $timeFrom = 0;

  }else if($_POST['timeTo']==''){
  $timeTo = 21474836;

  }
  //echo "<script>alert($timeFrom)</script>";
  //echo "<script>alert($timeToUnix);</script>";

  $query = mysqli_query($connect, "SELECT * FROM tasks WHERE time BETWEEN '$timeFromUnix' AND '2147483633' ORDER BY time");


  while ($row = mysqli_fetch_assoc($query)) {
  $result[] = $row;
  }



  if (!empty($result)) {
  ?>
  <ul>
  <?php
  foreach ($result as $time) {
  $timeFromGMT = date(" g:i a , F j , Y", $time['time']);

  ?>

  <li class="taskReadListUl" onClick="selectTaskTime('<?php echo $test; ?>');"><?php echo $test; ?></li>


  <?php } ?>
  </ul>
  <?php

  }

  }else */

if (!empty($_POST['taskName'])) {
    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE name like '%" . $_POST["taskName"] . "%' ORDER BY name LIMIT 8");


    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }



    if (!empty($result)) {
        ?>
        <ul >
            <?php
            foreach ($result as $name) {
                ?>

                <li class="taskReadListUl" onClick="selectTaskName('<?php echo $name['name']; ?>');"><?php echo $name['name']; ?></li>


            <?php } ?>
        </ul>
        <?php
    }
} else if (!empty($_POST['taskDescrition'])) {
    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE description like '%" . $_POST['taskDescrition'] . "%' ORDER BY description LIMIT 4");


    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }



    if (!empty($result)) {
        foreach ($result as $description) {
            ?>

            <textarea class="taskReadTextarea js-auto-size-search" onClick="selectTaskDescrition('<?php echo $description['description']; ?>');"><?php echo $description['description']; ?></textarea>
            <script>
                $('textarea.js-auto-size-search').textareaAutoSize();
            </script>
        <?php } ?>

        <?php
    }
} else if (!empty($_POST['taskLocation'])) {
    $query = mysqli_query($connect, "SELECT * FROM tasks WHERE location like '%" . $_POST['taskLocation'] . "%' ORDER BY location LIMIT 3");


    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }



    if (!empty($result)) {

        foreach ($result as $location) {
            ?>

            <textarea class="taskReadTextarea textarea.js-auto-size-search" onClick="selectTaskLocation('<?php echo $location['location']; ?>');"><?php echo $location['location']; ?></textarea>
            <script>
                $('textarea.js-auto-size-search').textareaAutoSize();
            </script>

        <?php } ?>

        <?php
    }
}
?>

