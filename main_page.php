<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Healthy Tasks</title>
        <link rel="done icon" href="images/tab_icon.png" type="image/x-icon"/>

        <script src="js/main_page/jquery.min.js"></script>
        <script src="js/main_page/jquery.scrolly.min.js"></script>
        <script src="js/main_page/jquery.scrollzer.min.js"></script>
        <script src="js/main_page/skel.min.js"></script>
        <script src="js/main_page/skel-layers.min.js"></script>
        <script src="js/main_page/init.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/main_page/skel.css" />
        <link rel="stylesheet" href="css/main_page/style.css" />
        <link rel="stylesheet" href="css/main_page/style-wide.css" />

        </noscript>
        <!--<link rel="stylesheet" href="css/myStyle.css" />-->
        
    </head>
    <body>
        <div id="header" class="skel-layers-fixed">

            <div class="top">


                <div id="logo" >
                    <span class="image avatar"><img src="images/avatar.jpg" alt="" /></span>
                    <?php
                    session_start();

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
                        <li><a href="#sign_out" id="sign_out-link" class="skel-layers-ignoreHref"><span class="fa fa-sign-out">Sign out</span></a></li>
                    </ul>
                   



                </nav>

            </div>

        </div>

        <div id="main">
            <section id="home" class="one">
                <div class="container">
                    <header>
                        <p>Healthy Tasks</p>
                        

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
