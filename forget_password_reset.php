<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Reset Password</title>	
        
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>
        
       
    </head>
    <body>
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
        <img src="../images/background_signIn.jpg" alt="" id="background" />
        <div id="maincontent">
            <section class="resetPassword">
                <div class="top">
                    <h2>Reset Password</h2>
                </div>
                <form id="resetPasswordForm" method="post" >
                    <div class="middle">
                        <label for="resetPassword"> Password: </label>
                        <input id="resetPassword" name="resetPassword" type="password" autocomplete="off"/>
                        <input id="passwordClear" name="passwordClear" type="text" autocomplete="off" value="At least an uppercase or a digit"/>

                        <div class="password-meter">
                            <div class="password-meter-message">&nbsp;</div>
                            <div class="password-meter-bg">
                                <div class="password-meter-bar"></div>

                            </div>
                        </div>
                        <br>
                        <label for="resetPasswordConfirm">Password confirmation: </label>
                        <input id="resetPasswordConfirm" name="resetPasswordConfirm" type="password" autocomplete="off"/>
                    </div>
                    <div class="bottom">
                        <input id ="resetPasswordSubmit" name="resetPasswordSubmit" type="submit" value="Update password"/>

                    </div>
                </form>
            </section>
        </div>
 <script type="text/javascript">
            $(window).load(function () {
                $("#background").fullBg();
            });

            $('#passwordClear').show();
            $('#resetPassword').hide();

            $('#passwordClear').focus(function () {
                $('#passwordClear').hide();
                $('#resetPassword').show();
                $('#resetPassword').focus();
            });
            $('#resetPassword').blur(function () {
                if ($('#resetPassword').val() === '') {
                    $('#passwordClear').show();
                    $('#resetPassword').hide();
                }
            });
        </script>
    </body>
</html>
<?php
if (isset($_POST['resetPasswordSubmit'])) {
    require_once 'php_functions/account_functions.php';
    $newPassword = $_POST['resetPassword'];
    $token = $_GET['token'];

    resetPassword($newPassword, $token);
}
?>
