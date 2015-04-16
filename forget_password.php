<?php
require_once 'php_functions/account_functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forget Password page</title>
        
        <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>
        
        <link rel="stylesheet" type="text/css" href="/healthytasks/css/account/forget_password.css">

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
        <img src="/healthytasks/images/background_signIn.jpg" alt="" id="background" />
        <div id="maincontent">
            <section class="forget_password">
                <div class="top">
                    <h2>Forget Password</h2>
                </div>
                <form id="forgetPasswordForm" method="post">
                    <div class="middle">
                        <label for="usernamePasswordForget">Username or Email:</label><br>
                        <input id="usernamePasswordForget" name="usernamePasswordForget" type="text" />	
                    </div>
                    <div class="bottom">
                        <table>
                            <tr>
                                <td>
                                    <input id="forgetPasswordSubmit" name="forgetPasswordSubmit" type="submit" value="Submit"/>
                                </td>
                                <td>
                                    <a class="yellow_text" href="sign_in.php" >Suddenly remembered? Sign in here</a>
                                    <br>
                                    <a class="yellow_text" href="register.php" >You don't have an account? Register here</a>
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

if (isset($_POST['forgetPasswordSubmit'])) {
    $forgetPass = $_POST['usernamePasswordForget'];

    forgetPassword($forgetPass);
}
?>