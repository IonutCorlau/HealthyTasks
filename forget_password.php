<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Forget Passoword page</title>
	<link rel="stylesheet" type="text/css" href="css/forget_password.css">
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/validateJQueryPlugin.js"></script>
</head>
<body>
	<section class="forget_password">
		<div class="top">
			<h2>Forget Password</h2>
		</div>
		<form id="forgetPasswordForm" method="post">
			<div class="middle">
				<label for="usernamePasswordForget">Username or Email:</label><br>
				<input id="usernamePasswordForget" name="usernamePasswordForget" type="text" />	
			</div>
			<div class="bottom">
				<input id="forgetPasswordSubmit" name="forgetPasswordSubmit" type="submit" value="Submit"/>
				<a class="yellow_text" href="login.php" >Suddenly remebered? Log in here</a>
				<br>
				<a class="yellow_text" href="register.php" >You don't have an account? Register here</a>
			</div>
		</form>
	</section>
</body>
<?php

if(isset($_POST['forgetPasswordSubmit'])){
    $forgetPass=$_POST['usernamePasswordForget'];
    
    require_once 'db_connect.php';
    databaseConnect();
    forgetPassword($forgetPass);
    
    
    
}

?>

</html>