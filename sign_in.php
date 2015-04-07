<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>
        
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>
        
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="css/account/sign_in.css">
        <script src="plugins/jquery/jquery-2.1.3.min.js"></script>
        
        <script src="plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>
        
        <script src="plugins/jquery_fullbg/jquery.fullbg.js"></script>
      

        <script src="plugins/sweet_alert/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="plugins/sweet_alert/sweet-alert.css">
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8">

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
                                <label for="passwordLogin">Password: </label> <a class="yellow_text" href="forget_password.php">Forgot your password?</a>
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

    require_once 'php_functions/account_functions.php';
    databaseConnect();

    signIn($username, $password);
    
}
?>

