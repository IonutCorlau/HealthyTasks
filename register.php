<?php
require_once('C:\Users\Ionut\vendor\autoload.php');
require_once ('php_functions/account_functions.php');
$siteKey = '6LcePAATAAAAAGPRWgx90814DTjgt5sXnNbV5WaW';
$secret = '6LcePAATAAAAABjXaTsy7gwcbnbaF5XgJKwjSNwT';
$lang = 'en';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register page</title>



        <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>

        <link rel="stylesheet" type="text/css" href="/healthytasks/css/account/register.css">
        <script src="/healthytasks/plugins/jquery/jquery-2.1.3.min.js"></script>

        <script src="/healthytasks/plugins/nice_scroll/jquery.nicescroll.js"></script>
        
        <script src="/healthytasks/plugins/fake_loader/fakeLoader.js"></script>
        <link rel="stylesheet" href="/healthytasks/plugins/fake_loader/fakeLoader.css">

        <script src="/healthytasks/plugins/jquery_fullbg/jquery.fullbg.js" ></script>

        <script src="/healthytasks/plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="/healthytasks/plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>

        <link rel="stylesheet" type="text/css" media="screen" href="/healthytasks/plugins/password_meter/jquery.validate.password.css" />
        <script type="text/javascript" src="/healthytasks/plugins/password_meter/jquery.validate.password.js"></script>




        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl= <?php echo $lang; ?>"></script>



        <script src="/healthytasks/plugins/sweet_alert/sweet-alert.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/sweet_alert/sweet-alert.css">

        <script src="/healthytasks/plugins/jquery_fullbg/jquery.fullbg.js"></script>
        <script src="/healthytasks/js/account/my_functions.js"></script>


        <meta name="viewport" content="width=device-width, initial-scale=0.8">



    </head>
    <body>

        <div class="fakeloader">
            <script>
                $(".fakeloader").fakeLoader({
                    timeToHide: 600,
                    spinner: "spinner2",
                    bgColor: "#e74c3c"


                });
            </script>
  </div>


      
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
       
        <img src="/healthytasks/images/background_signIn.jpg" alt=""  class="fullBg" id="background"/>
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

                        <label for="userName">Username:</label>
                        <input id="userName" name="userName" type="text"/>
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
        <script>

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
                    $("label.error").hide();
                    $('#password').hide();
                }
            });


        </script>
        <!--</div>-->
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
            $username = $_POST['userName'];
            $email = $_POST['email'];
            $password = $_POST['password'];


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




