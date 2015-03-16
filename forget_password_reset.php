<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Reset Password</title>	
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/validateJQueryPlugin.js"></script>
</head>
<body>
	<section class="resetPassword">
		<div class="top">
			<h2>Reset Password</h2>
		</div>
		<form id="resetPassowordForm" method="post" >
		<div class="middle">
			<label for="resetPassoword"> Password: </label>
			<input id="resetPassoword" name="resetPassoword" type="password" />
			<br>
			<label for="resetPassowordConfirm">Password confirmation: </label>
			<input id="resetPassowordConfirm" name="resetPassowordConfirm" type="password" />
		</div>
		<div class="bottom">
			<input id ="resetPassowordSubmit" name="resetPassowordSubmit" type="submit" value="Update password"/>
			
		</div>
		</form>
	</section>
</body>
</html>
<?php
    if(isset($_POST['resetPassowordSubmit'])){
         require_once 'php_functions/db_connect.php';
         $newPassword = $_POST['resetPassoword'];
         $token = $_GET['token'];
         resetPassword($newPassword,$token);
         
    }
   
  
   
?>
