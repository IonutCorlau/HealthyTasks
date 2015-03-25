<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Reset Password</title>	
	
</head>
<body>
<img src="../images/background_login.jpg" alt="" id="background" />
<div id="maincontent">
	<section class="resetPassword">
		<div class="top">
			<h2>Reset Password</h2>
		</div>
            <form id="resetPassowordForm" method="post" >
		<div class="middle">
			<label for="resetPassoword"> Password: </label>
			<input id="resetPassoword" name="resetPassword" type="password" autocomplete="off"/>
                        <input id="password-clear" name="password-clear" type="text" autocomplete="off" value="At least an uppercase or a digit"/>
			
                        <div class="password-meter">
				<div class="password-meter-message">&nbsp;</div>
				<div class="password-meter-bg">
					<div class="password-meter-bar"></div>
                                       
				</div>
			</div>
                        <br>
			<label for="resetPassowordConfirm">Password confirmation: </label>
			<input id="resetPassowordConfirm" name="resetPassowordConfirm" type="password" autocomplete="off"/>
		</div>
		<div class="bottom">
			<input id ="resetPassowordSubmit" name="resetPassowordSubmit" type="submit" value="Update password"/>
			
		</div>
		</form>
	</section>
</div>
<script type="text/javascript">
$(window).load(function() {
	$("#background").fullBg();
});
$('#password-clear').show();
$('#password-password').hide();

$('#password-clear').focus(function() {
    $('#password-clear').hide();
    $('#password-password').show();
    $('#password-password').focus();
});
$('#password-password').blur(function() {
    if($('#password-password').val() == '') {
        $('#password-clear').show();
        $('#password-password').hide();
    }
});
</script>
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
