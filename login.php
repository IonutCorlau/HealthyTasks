<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login page</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/validateJQueryPlugin.js"></script>
        <script src="js/jquery.fullbg.js"></script>
        <script src="js/jquery.fullbg.min"></script>
        
</head>
<body>
<img src="images/background_login.jpg" alt="" id="background" />
<div id="maincontent">
	<section class="login">
		<div class="top">
                    <h2><b>Login</b></h2>
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
                    <table >
                        <tr>
                            <td>
                                <input id ="submitLoginSibmit" name="submitLoginSibmit" type="submit" value="Login"/>
                            </td>
                            <td>
                                <a class="yellow_text" href="register.php" >You don't have an account yet? <br>Register here</a>
                            </td>
                        </tr>
                    </table>
		</div>
		</form>
	</section>
</div>
<script type="text/javascript">
$(window).load(function() {
	$("#background").fullBg();
});
</script>
</body>
</html>


<?php
  
if(isset($_POST['submitLoginSibmit'])){
    $username=$_POST['usernameLogin'];
    $password=$_POST['passwordLogin'];
    
    require_once 'php_functions/db_connect.php';
    databaseConnect();
    login($username, $password);
    
   
}


?>

