
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Register page</title>
        
       
        
	<link rel="stylesheet" type="text/css" href="css/register.css">
	
	<link rel="stylesheet" type="text/css" media="screen" href="css/jquery.validate.password.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/validateJQueryPlugin.js"></script>
	<script type="text/javascript" src="js/jquery.validate.password.js"></script>
        
        <script src='https://www.google.com/recaptcha/api.js'></script>
         
        <script src="js/jquery.fullbg.js"></script>
        <script src="js/jquery.fullbg.min.min"></script>
        
        <script src="js/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="css/sweet-alert.css">
        

        
</head>
<body>
<img src="images/background_login.jpg" alt="" id="background" />
<div id="maincontent">
	<section class="register">
		<div class="top">
			<h2> Register </h2>
		</div>
		<form id="registerForm" method="post" action="register.php">
		<div class="middle" >
			<label for="firstName">First Name:</label>
			<input id="firstName" name="firstName" type="text"/><br>
			
			<label for="lastName">Last Name:</label>
			<input id="lastName" name="lastName" type="text"/>
			<br>

			<label for="username">Username:</label>
			<input id="username" name="username" type="text"/>
			<br>
		
			<label for="email">Email:</label>
			<input id="email" name="email" type="email"/>
			<br>

			<label for="password">Password:</label>
			<input id="password" name="password" type="password"/>

			<div class="password-meter">
				<div class="password-meter-message">&nbsp;</div>
				<div class="password-meter-bg">
					<div class="password-meter-bar"></div>
				</div>
			</div>

			<br>
			<label for="confirmPassword">Confirm Password:</label>
			<input id="confirmPassword" name="confirmPassword" type="text"/><br>
                        <div class="g-recaptcha"  data-sitekey="6Ld31QITAAAAALEwzQWNmIcU3INUbH6-ZvIzTqHP"></div>
		</div>
		<div class="bottom">
                    <table >
                        <tr>
                            <td>
                                <input type="submit" value="Register" id="registerButton" name="registerButton"/>
                            </td>
                            <td>
                                <a class="yellow_text" href="login.php">You have an account already? Log in here</a>
           
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
                      
                        
                        if (isset($_POST['registerButton'])) {
                            
                            $firstname=$_POST['firstName'];
                            $lastname=$_POST['lastName'];
                            $username=$_POST['username'];
                            $email=$_POST['email'];
                            $password=$_POST['password'];
                            
                            require_once "php_functions/db_connect.php";
                            databaseConnect();
                            register($firstname, $lastname, $username, $email, $password);
                        }
      
                        ?>



