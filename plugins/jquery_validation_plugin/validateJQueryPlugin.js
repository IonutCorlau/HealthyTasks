$(document).ready(function () {
    $("#signInForm").validate({
        rules: {
            usernameLogin: {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            passwordLogin: {
                required: true,
                minlength: 8,
                maxlength: 25
            }
        },
        messages: {
            usernameLogin: {
                required: "Please specify your Username",
                minlength: "Username must be least 6 characters long"
            },
            passwordLogin: {
                required: "Please specify your Password",
                minlength: "Password must be least 8 characters long "
            }
        }
    });


    $("#forgetPasswordForm").validate({
        rules: {
            usernamePasswordForget: {
                required: true,
                minlength: 4,
                maxlength: 35
            }
        },
        messages: {
            usernamePasswordForget: {
                required: "Please enter your Username or Password",
                minlength: "Please enter valid data"
            }
        }
    });

    $("#registerForm").validate({
        rules: {
            firstName: {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            lastName: {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            username: {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            email: {
                required: true,
                email: true,
                maxlength: 35
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 25
            },
            confirmPassword: {
                required: true,
                minlength: 8,
                maxlength: 25,
                equalTo: "#password"
            }

        },
        messages: {
            firstName: {
                required: "Please specify your First Name",
                minlength: "First Name must be least 3 characters long"
            },
            lastName: {
                required: "Please specify your Last Name",
                minlength: "Last Name must be least 3 characters long"
            },
            username: {
                required: "Please specify your Username",
                minlength: "Username must be least 6 characters long"
            },
            email: {
                required: "Please specify your Email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please specify your Password",
                minlength: "Password must be least 8 characters long "
            },
            confirmPassword: {
                required: "Please confirm your Password",
                minlength: "Password must be least 8 characters long",
                equalTo: "Please enter the same password as above"

            }


        }
    });
    $("#resetPasswordForm").validate({
        rules: {
            resetPassword: {
                required: true,
                minlength: 8,
                maxlength: 25
            },
            resetPasswordConfirm: {
                required: true,
                minlength: 8,
                maxlength: 25,
                equalTo: "#resetPassword"
            }

        },
        messages: {
            resetPassword: {
                required: "Please specify your Password",
                minlength: "Password must be least 8 characters long "
            },
            resetPasswordConfirm: {
                required: "Please confirm your Password",
                minlength: "Password must be least 8 characters long",
                equalTo: "Please enter the same password as above"
            }
        }

    });
    $("#contactForm").validate({
        rules: {
            commentInput: {
                required: true,
                maxlength: 500

            }

        },
        messages: {
            commentInput: {
                required: "Please complete the input"

            }

        }

    });
    $("#editProfileInfo").validate({
        rules: {
            firstNameEditForm: {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            lastNameEditForm: {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            userNameEditForm: {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            emailEditForm: {
                required: true,
                email: true,
                maxlength: 35
            }
        },
        messages: {
            firstNameEditForm: {
                required: "Please specify your First Name",
                minlength: "First Name must be least 3 characters long"
            },
            lastNameEditForm: {
                required: "Please specify your Last Name",
                minlength: "Last Name must be least 3 characters long"
            },
            userNameEditForm: {
                required: "Please specify your Username",
                minlength: "Username must be least 6 characters long"
            },
            emailEditForm: {
                required: "Please specify your Email",
                email: "Please enter a valid email address"
            }
        }
    });
    $("#addTask").validate({
        rules: {
            taskName: {
                required: true,
                minlength: 5,
                maxlength: 60
            },
            datetimepickerWhen:{
                required: true
            },
            taskDescription:{
                maxlength: 500
            },
            taskReminderInput1:{
                min: 1,
                max: 59
            },
            taskReminderInput2:{
                min: 1,
                max: 23
            },
            taskReminderInput3:{
                min: 1,
                max: 30
            }
        },
        messages: {
            taskName: {
                required: "Please specify a name for the activity",
                minlength: "Task name must be least 5 characters long "
            },
            datetimepickerWhen:{
               required : "Please specify when you will do the task"
            },
            taskReminderInput1:{
                min: "1-59 Minutes",
                max: "1-59 Minutes"
            },
            taskReminderInput2:{
                min: "1-23 Hours",
                max: "1-23 Hours"
            },
            taskReminderInput3:{
                min: "1-30 Days",
                max: "1-30 Days"
            }
        }

    });
    $("#computeCalories").validate({
        rules: {
            height: {
                required: true,
                min: 130,
                max: 210
            },
            weight: {
                required: true,
                min: 40,
                max: 130
            },
            age: {
                required: true,
                min: 18,
                max: 90
            }

        },
        messages: {
            height: {
                required: "Complete the input",
                min: "Between 130 - 210 ",
                max: "Between 130 - 210 "

            },
            weight: {
                required: "Complete the input",
                min: "Between 40 - 130 ",
                max: "Between 40 - 130 "

            },
            age: {
                required: "Complete the input",
                min: "Between 18 - 90 ",
                max: "Between 18 - 90 "

            }

        }

    });
    /*$("#calorieEatForm").validate({
        rules: {
            calorieEatInput: {
                required: true,
                min: 500,
                max: 9000

            }

        },
        messages: {
            calorieEatInput: {
                required: "Required field",
                min: "Between 500 - 9000",
                max: "Between 500 - 9000"

            }

        }

    });*/
});

