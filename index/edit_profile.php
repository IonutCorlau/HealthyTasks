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
                $pathAvatar = '/healthytasks/' . $row['avatar'];
                echo "<img src='$pathAvatar' class='avatar '  onerror=\"this.src='/healthytasks/images/userAvatars/user_not_found.jpg';\" alt='Image not found'  width=100px; >";
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
                        <input name="changePassMain" type="submit" class="btn btn-primary btn-lg pull-left" value="Change Password" onclick="fakeLoaderFunction(4000);">
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
                        <input name="submitEditProfile" id="submitEditProfile" type="submit" class="btn btn-primary btn-lg pull-left" value="Save Changes" onclick="fakeLoaderFunction(1000);">

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

