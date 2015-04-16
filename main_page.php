<?php
require_once 'php_functions/main_page_functions.php';
require_once 'php_functions/db_connect.php';
$user = new User($_SESSION['userId']);
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Healthy Tasks</title>
        <link rel="done icon" href="/healthytasks/images/tab_icon.png" type="image/x-icon"/>
        <script src="/healthytasks/plugins/jquery/jquery-2.1.3.min.js"></script>

        <link href="/healthytasks/bootstrap/css/bootstrap.css" rel="stylesheet">
        <script src="/healthytasks/bootstrap/js/bootstrap.js"></script>

        <script type="text/javascript" src="/healthytasks/plugins/filestyle/bootstrap-filestyle.js"></script>




        <script src="/healthytasks/plugins/scrolly/jquery.scrolly.min.js"></script>
        <script src="/healthytasks/plugins/scrolly/jquery.scrollzer.min.js"></script>

        <script src="/healthytasks/plugins/skel/skel.min.js"></script>
        <script src="/healthytasks/plugins/skel/skel-layers.min.js"></script>

        <script src="/healthytasks/js/main_page/init.js"></script>

        <script src="/healthytasks/plugins/sweet_alert/sweet-alert.js"></script> 
        <link rel="stylesheet" type="text/css" href="/healthytasks/plugins/sweet_alert/sweet-alert.css">

        <link href="/healthytasks/plugins/star_rating/star-rating.css" media="all" rel="stylesheet" type="text/css" />
        <script src="/healthytasks/plugins/star_rating/star-rating.js" type="text/javascript"></script>

        <script src="/healthytasks/js/main_page/my_functions.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/main_page/my_style.css" />

        <script src="/healthytasks/plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="/healthytasks/plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>



        <noscript>
        <link rel="stylesheet" href="/healthytasks/plugins/skel/skel.css" />
        <link rel="stylesheet" href="/healthytasks/plugins/skel/style.css" />
        <link rel="stylesheet" href="/healthytasks/plugins/skel/style-wide.css" />

        </noscript>

    </head>
    <body>
        
        <div id="header" class="skel-layers-fixed">

            <div class="top">


                <div id="logo">
                    <div id="menuAvatar">
                        <?php
                            $query = mysqli_query($connect, "SELECT avatar FROM users WHERE id='$user->id'") or die ("Connection failed: " . mysqli_connect_error());
                            $row = mysqli_fetch_assoc($query);
                            $pathAvatar = '/healthytasks/'.$row['avatar'];
                            echo "<img src='$pathAvatar' class='avatar '  onerror=\"this.src='/healthytasks/images/userAvatars/user_not_found.jpg';\" alt='Image not found'  weight=100px width=100px; >";
                            ?>
                        
                        
                     
                   </div>
                    <div id="menuNameTime">
                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
                        echo $user->firstName . " " . $user->lastName;
                        echo "
                       
                    <body onload='startTime()'>
                        <p id='date' ></p>
                        <p id='time'></p>
                    </body>";
                    } else {
                        echo "<script>
                        $(document).ready(function() {
                            swal({ 
                            title: 'Please Sign in',
                            text: '',
                            type: 'warning' 
                        },
                        function(){
                        window.location.href = 'http://localhost/healthytasks/sign_in.php';
              });
            });
            </script>";
                    }
                    ?>  
                </div>

                </div>
                <nav id="nav">

                    <ul>
                        <li><a href="#home" id="home-link" class="skel-layers-ignoreHref"><span class="fa fa-home">Home</span></a></li>
                        <li><a href="#status" id="status-link" class="skel-layers-ignoreHref"><span class="fa fa-bar-chart">Status</span></a></li>
                        <li><a href="#add_task" id="add_task-link" class="skel-layers-ignoreHref"><span class="fa fa-plus-square">Add task</span></a></li>
                        <li><a href="#health_zone" id="health_zone-link" class="skel-layers-ignoreHref"><span class="fa fa-heart">Health zone</span></a></li>
                        <li><a href="#find_places" id="find_places-link" class="skel-layers-ignoreHref"><span class="fa fa-map-marker">Find Places</span></a></li>
                        <li><a href="#edit_profile" id="edit_profile-link" class="skel-layers-ignoreHref"><span class="fa fa-edit">Edit profile</span></a></li>
                        <li><a href="#contact" id="contact-link" class="skel-layers-ignoreHref"><span class="fa fa-envelope">Contact</span></a></li>
                        <li><a href="sign_out.php" id="sign_out-link" class="skel-layers-ignoreHre" ><span class="fa fa-sign-out">Sign out</span></a></li>
                    </ul>

                </nav>

            </div>

        </div>

        <div id="main">
            <section id="home" class="one">
                <div class="container">
                    <header>
                        <h1>Healthy Tasks</h1>
                        <p><i>Have a healthy life and manage you daily tasks</i></p>

                    </header>

                </div>

            </section>

            <section id="status" class="two">
                <div class="container">
                    <header>
                        <h2>Status</h2>
                        <?php
                        echo session_status();
                        ?>

                    </header>

                </div>  
            </section>

            <section id="add_task" class="three">
                <div class="container">
                    <header>
                        <h2>Add task</h2>
                    </header>

                </div>
            </section>

            <section id="health_zone" class="four">
                <div class="container">
                    <header>
                        <h2>Health Zone</h2>
                    </header>
                </div>


            </section>
            <section id="find_places" class="five">
                <div class="container">
                    <header>
                        <h2>Find Places</h2>
                    </header>

                </div>
            </section>
            <section id="edit_profile" class="six">
                <div class="container">
                    <header>
                        <h2>Edit Profile</h2>
                    </header>


                </div>


                <div class="container">
                    <div class="row">

                        <div class="col-md-3" >

                            <div class="text-center">
                                <?php
                                $query = mysqli_query($connect, "SELECT avatar FROM users WHERE id='$user->id'") or die("Connection failed: " . mysqli_connect_error()); 
                                $row = mysqli_fetch_assoc($query);
                                $pathAvatar = '/healthytasks/'.$row['avatar'];
                              
                                
                                
                                echo "<img src='$pathAvatar' class='avatar '  onerror=\"this.src='/healthytasks/images/userAvatars/user_not_found.jpg';\" alt='Image not found'  weight=100px width=100px; >";
                               ?>
                                <h6>Upload a different photo...</h6>
                                <input id="uploadAvatarBtn" name="uploadAvatarBtn" type="file" class="filestyle " data-input="false" data-buttonName="btn-primary " form="editProfileInfo" >



                            </div>

                        </div>


                        <div class="col-md-9 personal-info">

                            <h3>Personal info</h3>
                            <form id="editProfileInfo" class="form-horizontal"  method="post" action="" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">First name:</label>
                                    <div class="col-md-8">



                                        <input id="firstNameEditForm" name="firstNameEditForm" class="form-control " type="text" value="<?php echo $user->firstName ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Last name:</label>
                                    <div class="col-md-8">
                                        <input id="lastNameEditForm" name="lastNameEditForm" class="form-control" type="text" value="<?php echo $user->lastName ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username:</label>
                                    <div class="col-md-8">
                                        <input id="userNameEditForm" name="userNameEditForm" class="form-control" type="text" value="<?php echo $user->userName ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email:</label>
                                    <div class="col-md-8">
                                        <input id="emailEditForm" name="emailEditForm" class="form-control" type="email" value="<?php echo $user->email ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label">Password:</label>
                                    <div id="pass-b" class="col-md-8">
                                        <input name="changePassMain" type="submit" class="btn btn-primary btn-lg pull-left" value="Change Password">
<?php
if (isset($_POST['changePassMain'])) {

    require_once '/php_functions/account_functions.php';
    recoverPasswordMail($user->email, $user->id);
}
?>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">
                                        <input name="submitEditProfile" id="submitEditProfile" type="submit" class="btn btn-primary btn-lg pull-left" value="Save Changes" >

                                        <span></span>
                                        <input id="cancelEditProfile" type="reset" class="btn btn-danger btn-lg pull-left" value="Cancel">
                                        <br>

                                    </div>
                                    <script>

                                    </script>
<?php
if (isset($_POST['submitEditProfile'])) {

    require_once '/php_functions/account_functions.php';
    $firstNameEdit = $_POST['firstNameEditForm'];
    $lastNameEdit = $_POST['lastNameEditForm'];
    $userNameEdit = $_POST['userNameEditForm'];
    $emailEdit = $_POST['emailEditForm'];


    
  


    editProfile($firstNameEdit, $lastNameEdit, $userNameEdit, $emailEdit);
}
?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>






            </section>

            <section id="contact" class="seven">
                <div class="container">
                    <header>
                        <h2>Contact</h2>
                        <div class="container">
                            <form id="contactForm" method="post" action="main_page.php" >

                                <div class="form-group">
                                    <label for="message" class="col-md-2 control-label">Message</label>
                                    <div class="col-md-10">
                                        <textarea id="commentInput" name="commentInput" class="form-control" rows="8"></textarea>

                                        <span class="pull-left">Please rate your experience with Healthy Tasks</span>
                                        <span class="pull-left" id="starRating"><input id="input-21b" name="starInput" value="0" type="number" class="rating" min=0 max=5 step=0.1 data-size="xs"></span>
                                        <script>
                                            $('#input-21b').on('rating.change', function (event, value) {
                                                //alert(value);

                                            });
                                        </script>
                                    </div>

                                </div>


                                <div class="form-group">     

                                    <div class="col-md-10 col-md-offset-2">
                                        <input type="submit" id="sendContact" name="sendContact" class="btn btn-success btn-lg pull-left"  onclick="main_page.php" value="Send">
                                        <input type="reset" name="cancelContact"  class="btn btn-danger btn-lg pull-left" value="Cancel">

                                    </div>
<?php
require_once 'php_functions/main_page_functions.php';
if (isset($_POST['sendContact'])) {
    $contactText = $_POST['commentInput'];


    sendContact($contactText);
}
?>

                                </div>

                            </form>

                        </div>
                    </header>

                </div>
            </section>



        </div>

        <div id="footer">

            <ul class="copyright">
                <li>&copy;  All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>

        </div>

    </body>
</html>
