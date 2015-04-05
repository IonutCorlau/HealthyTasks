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
    $("#resetPassowordForm").validate({
        rules: {
            resetPassoword: {
                required: true,
                minlength: 8,
                maxlength: 25
            },
            resetPassowordConfirm: {
                required: true,
                minlength: 8,
                maxlength: 25,
                equalTo: "#resetPassoword"
            }

        },
        messages: {
            resetPassoword: {
                required: "Please specify your Password",
                minlength: "Password must be least 8 characters long "
            },
            resetPassowordConfirm: {
                required: "Please confirm your Password",
                minlength: "Password must be least 8 characters long",
                equalTo: "Please enter the same password as above"
            }
        }

    });
    $("#contactForm").validate({
        rules: {
            commentInput: {
                required: true

            }


        },
        messages: {
            commentInput: {
                required: "Please complete the input"

            }

        }

    });
});