<?php
require_once 'php_functions/main_page_functions.php';
require_once 'php_functions/db_connect.php';
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

        <script src="/healthytasks/plugins/nice_scroll/jquery.nicescroll.js"></script>

        <script src="/healthytasks/plugins/nice_scroll/jquery.nicescroll.js"></script>

        <script src="/healthytasks/plugins/fake_loader/fakeLoader.js"></script>
        <link rel="stylesheet" href="/healthytasks/plugins/fake_loader/fakeLoader.css">

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

        

        <script src="/healthytasks/plugins/jquery_validation_plugin/jquery.validate.js"></script>
        <script src="/healthytasks/plugins/jquery_validation_plugin/validateJQueryPlugin.js"></script>


        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
        <script src="/healthytasks/js/main_page/google_geolocation.js" type="text/javascript"></script>

        
        <script type="text/javascript" src="/healthytasks/plugins/date_time_picker/moment.min.js"></script>
        <script type="text/javascript" src="/healthytasks/plugins/date_time_picker/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="/healthytasks/plugins/date_time_picker/bootstrap-datetimepicker.min.css" />
        
        

        <script src="/healthytasks/plugins/textarea_autosize/jquery.textarea_autosize.js"></script>
        
        <link rel="stylesheet" href="/healthytasks/plugins/slider_button/slider.css" />
        <script src="/healthytasks/plugins/slider_button/bootstrap-slider.js"></script>
        
        <script src="/healthytasks/js/main_page/my_functions.js" type="text/javascript"></script>
        
        <script src="/healthytasks/plugins/select_picker/bootstrap-select.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/healthytasks/plugins/select_picker/bootstrap-select.css" />
        
        <link rel="stylesheet" href="css/main_page/my_style.css" />
        
        <noscript>
        <link rel="stylesheet" href="/healthytasks/plugins/skel/skel.css" />
        <link rel="stylesheet" href="/healthytasks/plugins/skel/style.css" />
        <link rel="stylesheet" href="/healthytasks/plugins/skel/style-wide.css" />

        </noscript>



        
        <?php
        header("Content-type: text/html; charset=utf-8");
        ?>
        <script>
            function start(){
                initialize(); 
                startTime();
            }
        </script>
    </head>

    <body onload='start()'>
        <div class="fakeloader">
            <script>
                function fakeLoaderFunction(timer) {
                    $(".fakeloader").fakeLoader({
                        timeToHide: timer,
                        spinner: "spinner2",
                        bgColor: "#e74c3c"


                    });
                }
            </script>


        </div>

        <div id="header" class="skel-layers-fixed">

            <div class="top">


                <div id="logo">
                    <div id="menuAvatar">
                        <?php
                        if (isset($_SESSION['userId'])) {

                            $user = new User($_SESSION['userId']);

                            $query = mysqli_query($connect, "SELECT avatar FROM users WHERE id='$user->id'") or die("Connection failed: " . mysqli_connect_error());
                            $row = mysqli_fetch_assoc($query);
                            $pathAvatar = '/healthytasks/' . $row['avatar'];
                            echo "<img src='$pathAvatar' class='avatar'  onerror=\"this.src='/healthytasks/images/userAvatars/user_not_found.jpg';\" alt='Image not found'  width=80px; >";
                        }
                        ?>



                    </div>
                    <div id="menuNameTime">
                        <?php
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
                                    window.location.href = '/healthytasks/sign_in.php';
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


                    </header>

                </div>  
            </section>

            <section id="add_task" class="three">
                <?php include ('/index/add_task.php') ?> 
            </section>

            <section id="health_zone" class="four">
                 <?php include ('/index/health_zone.php'); ?>
            </section>
            <section id="find_places" class="five">
                <div class="container">
                    <header>
                        <h2>Find Places</h2>
                    </header>

                </div>
            </section>
            <section id="edit_profile" class="six">
                <?php include ('/index/edit_profile.php') ?> 
            </section>

            <section id="contact" class="seven">
                <?php include ('/index/contact.php') ?> 
            </section>



        </div>

        <div id="footer">

            <ul class="copyright">
                <li>&copy;  All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>

        </div>

    </body>

</html>
