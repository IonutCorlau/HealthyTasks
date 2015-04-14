<?php
require_once 'php_functions/account_functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>
        
        <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>
        
        <link href="/healthytasks/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="/healthytasks/bootstrap/js/bootstrap.min.js"></script>
        <script src="/healthytasks/bootstrap/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="/healthytasks/css/account/sign_in.css">
        <script src="/healthytasks/plugins/jquery/jquery-2.1.3.min.js"></script>
        
        <script src="/healthytasks/plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="/healthytasks/plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>
        
        <script src="/healthytasks/plugins/jquery_fullbg/jquery.fullbg.js"></script>
      

        <script src="/healthytasks/plugins/sweet_alert/sweet-alert.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/sweet_alert/sweet-alert.css">
        
        <script src="/healthytasks/js/account/my_functions.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8">

        
    </head>
    <body>
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
        <!--<img src="/healthytasks/images/background_signIn.jpg" alt="" id="background" />-->
        
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


    signIn($username, $password);
    
    
}
?>

