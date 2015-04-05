<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Healthy Tasks</title>
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>

        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link href="css/main_page/myStyle.css" rel="stylesheet">


        <script src="plugins/jquery/jquery-2.1.3.min.js"></script>
        
        <script src="plugins/scrolly/jquery.scrolly.min.js"></script>
        <!--<script src="plugins/scrolly/jquery.scrollzer.min.js"></script>-->
        
        <script src="plugins/skel/skel.min.js"></script>
        <script src="plugins/skel/skel-layers.min.js"></script>
        
        <script src="js/main_page/init.js"></script>

        <script src="plugins/sweet_alert/sweet-alert.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="plugins/sweet_alert/sweet-alert.css">

        <noscript>
        <link rel="stylesheet" href="plugins/skel/skel.css" />
        <link rel="stylesheet" href="plugins/skel/style.css" />
        <link rel="stylesheet" href="plugins/skel/style-wide.css" />

        </noscript>
        <!--<link rel="stylesheet" href="css/myStyle.css" />-->

        <style>
            .top a:hover {
                background: rgba(0,0,0,0.15);
                box-shadow: inset 0 0 0.25em 0 rgba(0,0,0,0.125);
                color: #fff;
            }          
        </style>

    </head>
    <body>
        <div id="header" class="skel-layers-fixed">

            <div class="top">


                <div id="logo" >
                    <span class="image avatar"><img src="images/avatar.jpg" alt="" /></span>
                    <?php
                    session_start();
                    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
                        echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];
                        echo "
                        <script>

                        function formatTime(i) {
                            if (i<10) {
                            i = '0' + i}; 
                        return i;
                        }                        
                        
                        function startTime() {
                        var date = new Date();
                        
                        var day = date.getUTCDate();
                        var dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 'December'];
                        var year = date.getFullYear();
                        
                        var hour = date.getHours();
                        var minute = date.getMinutes();
                        var second = date.getSeconds();
                        
                        hour = formatTime(hour);
                        minute = formatTime(minute);
                        second = formatTime(second);

                        document.getElementById('date').innerHTML = dayNames[date.getDay()] + ', ' + day  + ' ' + monthNames[date.getMonth()] + ' '+year;
                        document.getElementById('time').innerHTML = hour + ' : ' + minute + ' : ' + second;
                        var t = setTimeout(function(){startTime()},500);
                        }
                        
                        
                    </script>
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
            </section>

            <section id="contact" class="seven">
                <div class="container">
                    <header>
                        <h2>Contact</h2>
                        <div class="container">
                            <form id="contactForm" method="post" action="main_page.php">
                                <div class="form-group">
                                    <label for="message" class="col-sm-2 control-label">Message</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="8" name="message"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">     

                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button id="sendContact" name="sendContact" class="btn btn-success btn-lg pull-left" >Send  </button>
                                        <button id="cancelContact" name="cancelContact" class="btn btn-danger btn-lg pull-left" >Cancel</button>

                                    </div>
                                    <?php
                                        if(isset($_POST['sendContact'])){
                                            $comment=$_POST['sendContact'];
                                            
                                            require_once 'php_functions/main_page_functions.php';
                                            sendContact($comment);
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
