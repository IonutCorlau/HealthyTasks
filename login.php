<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login page</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/validateJQueryPlugin.js"></script>
</head>
<body>
	<section class="login">
		<div class="top">
			<h2>Login</h2>
		</div>
		<form id="loginForm" method="post" action="login.php">
		<div class="middle">
			<label for="usernameLogin"> Username: </label>
			<input id="usernameLogin" name="usernameLogin" type="text" />
			<br>
			<label for="passwordLogin">Password: <a class="yellow_text" href="forget_password.php">Forgot your password?</a></label>
			<input id="passwordLogin" name="passwordLogin" type="password" />
		</div>
		<div class="bottom">
			<input id ="submitLoginSibmit" name="submitLoginSibmit" type="submit" value="Login"/>
			<a class="yellow_text" href="register.php" >You don't have an account yet? <br>Register here</a>
		</div>
		</form>
	</section>
</body>

<?php
  
if(isset($_POST['submitLoginSibmit'])){
    $username=$_POST['usernameLogin'];
    $password=$_POST['passwordLogin'];
    
    require_once 'php_functions/db_connect.php';
    databaseConnect();
    login($username, $password);
    
   
}


?>

</html>