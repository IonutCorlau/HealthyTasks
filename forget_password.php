<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forget Password page</title>
        
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>
        
        <link rel="stylesheet" type="text/css" href="css/login/forget_password.css">

        <script src="js/login/jquery-2.1.3.min.js"></script>
        <script src="js/login/jquery.validate.js"></script>
        <script src="js/login/validateJQueryPlugin.js"></script>
        <script src="js/login/jquery.fullbg.js"></script>
        <script src="js/login/jquery.fullbg.min"></script>
        <script src="js/login/sweet-alert.min.js"></script> 

        <script src="../js/login/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="css/login/sweet-alert.css">
        <link rel="stylesheet" type="text/css" href="../css/login/sweet-alert.css">

        <script type="text/javascript">
            $(window).load(function () {
                $("#background").fullBg();
            });
        </script>
    </head>
    <body>
        <noscript ><h2>Sorry, your browser does not support JavaScript!</h2></noscript>
        <img src="images/background_signIn.jpg" alt="Image not found!" id="background" onError="this.src='../images/background_login.jpg';"/>
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

    require_once 'php_functions/db_connect.php';
    databaseConnect();
    forgetPassword($forgetPass);
}
?>