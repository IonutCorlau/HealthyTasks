<?php
require_once('C:\Users\Ionut\vendor\autoload.php');
$siteKey = '6LcePAATAAAAAGPRWgx90814DTjgt5sXnNbV5WaW';
$secret = '6LcePAATAAAAABjXaTsy7gwcbnbaF5XgJKwjSNwT';
$lang = 'en';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register page</title>
       
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>
        
        <link rel="stylesheet" type="text/css" href="css/account/register.css">
        <script src="plugins/jquery/jquery-2.1.3.min.js"></script>
          <script>
             $(window).load(function () {
                $("#background").fullBg();
            });
        </script>
        
        <script src="plugins/jquery_fullbg/jquery.fullbg.js" ></script>
        
        <script src="plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>
        
        <link rel="stylesheet" type="text/css" media="screen" href="plugins/password_meter/jquery.validate.password.css" />
        <script type="text/javascript" src="plugins/password_meter/jquery.validate.password.js"></script>
        
        

        
       <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl= <?php echo $lang; ?>"></script>

        

        <script src="plugins/sweet_alert/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="plugins/sweet_alert/sweet-alert.css">
    
    
       
        
    </head>
    <body>
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
        <img src="images/background_signIn.jpg" alt="" id="background" />
        <div id="maincontent">
            <section class="register animation">
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
                        <input id="password" name="password" type="password" autocomplete="off" value=""/>
                        <input id="passwordClear" name="passwordClear" type="text" autocomplete="off" value="At least an uppercase or a digit"/>
                        <div class="password-meter">
                            <div class="password-meter-message">&nbsp;</div>
                            <div class="password-meter-bg">
                                <div class="password-meter-bar"></div>
                            </div>
                        </div>

                        <br>
                        <label for="confirmPassword">Confirm Password:</label>
                        <input id="confirmPassword" name="confirmPassword" type="password" autocomplete="off"/><br>
                        <div class="g-recaptcha" data-type="" data-sitekey="<?php echo $siteKey; ?>"></div>
                    </div>
                    <div class="bottom">
                        <table >
                            <tr>
                                <td>
                                    <input type="submit" value="Register" id="registerButton" name="registerButton"/>
                                </td>
                                <td>
                                    <a class="yellow_text" href="sign_in.php">You have an account already? Sign in here</a>

                                </td>
                            </tr>
                        </table>

                    </div>
                </form>
            </section>
        </div>
        <script type="text/javascript">
       

            $('#passwordClear').show();
            $('#password').hide();

            $('#passwordClear').focus(function () {
                $('#passwordClear').hide();
                $('#password').show();
                $('#password').focus();
            });

            $('#password').blur(function () {
                if ($('#password').val() === '') {
                    $('#passwordClear').show();
                    $('#password').hide();
                }
            });

        
        </script>

    </body>
    
</html>

<?php
if (isset($_POST['registerButton'])) {
    if (isset($_POST['g-recaptcha-response'])) {

        require_once('C:\Users\Ionut\vendor\autoload.php');
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);

        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if ($resp->isSuccess()) {

            $firstname = $_POST['firstName'];
            $lastname = $_POST['lastName'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            require_once "php_functions/account_functions.php";
            databaseConnect();
            register($firstname, $lastname, $username, $email, $password);
        } else {

            foreach ($resp->getErrorCodes() as $code) {
                if ($code === 'missing-input-response') {
                    echo "<script>swal('Please validate capcha', '', 'warning');</script>";
                } else
                if ($code === 'invalid-input-response') {
                    echo "<script>swal('It is possible to be a spammer. Please try again!', '', 'error');</script>";
                } else
                if ($code === 'invalid-input-secret') {
                    echo "<script>swal('The secret parameter is invalid or malformed', '', 'error');</script>";
                } else
                if ($code === 'missing-input-secret') {
                    echo "<script>swal('The secret parameter is missing', '', 'error');</script>";
                }
            }
        }
    }
}
?>



