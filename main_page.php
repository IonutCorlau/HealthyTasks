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
        
        
        <div class="fakeloader">
        <script>
            function fakeLoaderFunction(timer){
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
                            if(isset($_SESSION['userId'])){
                                
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


                        </header>

                    </div>  
                </section>

                <section id="add_task" class="three">
                    <div class="container">
                        <div class="container">
	<div class="row">
        <div class="col-sm-12">
            <legend>Mr. Sosa:</legend>
        </div>
        <!-- panel preview -->
        <div class="col-sm-5">
            <h4>Add payment:</h4>
            <div class="panel panel-default">
                <div class="panel-body form-horizontal payment-form">
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Concept</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="concept" name="concept">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="amount" name="amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status">
                                <option>Paid</option>
                                <option>Unpaid</option>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>   
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-default preview-add-button">
                                <span class="glyphicon glyphicon-plus"></span> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>            
        </div> <!-- / panel preview -->
        <div class="col-sm-7">
            <h4>Preview:</h4>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table preview-table">
                            <thead>
                                <tr>
                                    <th>Concept</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody> <!-- preview content goes here-->
                        </table>
                    </div>                            
                </div>
            </div>
            <div class="row text-right">
                <div class="col-xs-12">
                    <h4>Total: <strong><span class="preview-total"></span></strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr style="border:1px dashed #dddddd;">
                    <button type="button" class="btn btn-primary btn-block">Submit all and finish</button>
                </div>                
            </div>
        </div>
	</div>
</div>

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
