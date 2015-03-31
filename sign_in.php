<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>
        
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>
        
        <link rel="stylesheet" type="text/css" href="css/login/sign_in.css">
        <script src="js/login/jquery-2.1.3.min.js"></script>
        <script src="js/login/jquery.validate.js"></script>
        <script src="js/login/validateJQueryPlugin.js"></script>
        <script src="js/login/jquery.fullbg.js"></script>
        <script src="js/login/jquery.fullbg.min.min"></script>

        <script src="js/login/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="css/login/sweet-alert.css">

        <script type="text/javascript">
            $(window).load(function () {
                $("#background").fullBg();
            });

        </script>
    </head>
    <body>
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
        <img src="images/background_signIn.jpg" alt="" id="background" />
        <div id="maincontent">
            <section class="signIn">
                <div class="top">
                    <h2><b>Sign in</b></h2>
                </div>
                <form id="signInForm" method="post" action="sign_in.php">
                    <div class="middle">
                        <label for="usernameLogin"> Username: </label>
                        <input id="usernameLogin" name="usernameLogin" type="text" />
                        <br>
                        <label for="passwordLogin">Password: <a class="yellow_text" href="forget_password.php">Forgot your password?</a></label>
                        <input id="passwordLogin" name="passwordLogin" type="password" autocomplete="off"/>
                    </div>
                    <div class="bottom">
                        <table >
                            <tr>
                                <td>
                                    <input id ="submitLoginSibmit" name="submitLoginSibmit" type="submit" value="Sign in"/>
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

    </body>
</html>


<?php
if (isset($_POST['submitLoginSibmit'])) {
    $username = $_POST['usernameLogin'];
    $password = $_POST['passwordLogin'];

    require_once 'php_functions/db_connect.php';
    databaseConnect();

    signIn($username, $password);
    
}
?>

