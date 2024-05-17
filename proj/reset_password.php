<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
        
            <?php
                include("config.php");

                if (isset($_POST["submit"])) {
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

                    if ($password !== $confirm_password) {
                        $_SESSION['warning'] = "Passwords do not match!";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        $confrim_password = $_POST['confirm_password'];
                        $hashed_password = password_hash($confirm_password, PASSWORD_DEFAULT);

                        // Find the user in the users table
                        $result = mysqli_query($con, "SELECT * FROM users WHERE Email='$email'") or die("Select Error");
                        $row = mysqli_fetch_assoc($result);

                        if (!empty($row)) {
                            // If the user is found in the users table, update the user's password
                            $sql = "UPDATE users SET Password = '$hashed_password' WHERE Email = '$email'";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                $_SESSION['success'] = "Password reset successfully!";
                                header("Location: LoginSignup.php");
                                exit;
                            } else {
                                $_SESSION['warning'] = "Password reset unsuccessfully!";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                        } else {
                            // Find the user in the teachers table
                            $result = mysqli_query($con, "SELECT * FROM teachers WHERE Email='$email'") or die("Select Error");
                            $row = mysqli_fetch_assoc($result);

                            if (!empty($row)) {
                                // If the user is found in the teachers table, update the teacher's password
                                $sql = "UPDATE teachers SET Password = '$hashed_password' WHERE Email = '$email'";
                                $result = mysqli_query($con, $sql);
                                if ($result) {
                                    $_SESSION['success'] = "Password reset successfully!";
                                    header("Location: LoginSignup.php");
                                    exit;
                                } else {
                                    $_SESSION['warning'] = "Password reset unsuccessfully!";
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit;
                                }
                            } else {
                                // User not found in either the users or teachers table
                                $_SESSION['warning'] = "Email is not found! Pleae check your email and try again.";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                    }
                }
            }else{
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1>Reset your Password</h1>
                    <input type="email" placeholder="Email" name="email" id="email" autocomplete="off" oninput="this.value = this.value.toLowerCase();" required/>
                    <div class="password-wrapper">
                        <i class="far fa-eye-slash" id="togglePasswords"></i>
                        <input type="password" placeholder="New Password" name="password" id="passwords" autocomplete="off" required />
                    </div>
                    <div class="password-wrapper">
                        <i class="far fa-eye-slash" id="togglePassword"></i>
                        <input type="password" placeholder="Confirm Password" name="confirm_password" id="password" autocomplete="off" required />
                    </div>
            
                    <div class="field">
                        <input type="submit" class="btn-2" name="submit" value="Submit">
                        <input type="button" class="btn-2" name="submit" value="Back" onclick="window.history.back()">
                    </div>
                </form>
                <?php } ?>
        </div>
        <?php
    if (isset($_SESSION['warning'])) {
        echo "
        <div id='error-dialog' title='Error' style='display: none; text-align:center; font-size: 15px;'>
            <p>{$_SESSION['warning']}</p>
            <p>Click 'OK' to close this message and try again.</p>
        </div>
        <script>
            $(document).ready(function() {
                $(\"#error-dialog\").dialog({
                    modal: true,
                    width: 400,
                    resizable: false,
                    draggable: false,
                    dialogClass: 'ui-dialog-error',
                    buttons: {
                        'OK': function() {
                            $( this ).dialog( 'close' );
                        }
                    }
                });
            });
        </script>
        <style>
        .ui-dialog-error .ui-dialog-titlebar-close {
            display: none;
        }
        .ui-dialog-error .ui-dialog-titlebar {
            background-color: red;
            color: #fff;
            padding: 5px;
            font-size: 15px;
        }
        .ui-dialog-error .ui-dialog-buttonset button {
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            background-color: #0c3666;
            color: #fff;
            border: none;
        }
        .ui-dialog-error .ui-dialog-buttonset button:hover {
            opacity: 0.8;
            cursor: pointer;
        }
        .ui-dialog-error .ui-dialog-buttonset button:active {
            opacity: 0.8;
        }
        .ui-dialog-buttonpane {
            padding: 10px 20px;
            margin: 10px 0px;
        }
        </style>";
        unset($_SESSION['warning']);

    }elseif (isset($_SESSION['success'])) {
        echo "
        <div id='success-dialog' title='Successful' style='display: none; text-align:center; font-size: 15px;'>
            <p>{$_SESSION['success']}</p>
            <p>Click 'OK' to close this message.</p>
        </div>
        <script>
            $(document).ready(function() {
                $(\"#success-dialog\").dialog({
                    modal: true,
                    width: 400,
                    resizable: false,
                    draggable: false,
                    dialogClass: 'ui-dialog-success',
                    buttons: {
                        'OK': function() {
                            $( this ).dialog( 'close' );
                        }
                    }
                });
            });
        </script>
        <style>
        .ui-dialog-success .ui-dialog-titlebar-close {
            display: none;
        }
        .ui-dialog-success .ui-dialog-titlebar {
            background-color: green;
            color: #fff;
            padding: 5px;
            font-size: 15px;
        }
        .ui-dialog-success .ui-dialog-buttonset button {
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            background-color: #0c3666;
            color: #fff;
            border: none;
        }
        .ui-dialog-success .ui-dialog-buttonset button:hover {
            opacity: 0.8;
            cursor: pointer;
        }
        .ui-dialog-success .ui-dialog-buttonset button:active {
            opacity: 0.8;
        }
        .ui-dialog-buttonpane {
            padding: 10px 20px;
            margin: 10px 0px;
        }
        </style>";
        unset($_SESSION['success']);
    }
    
    ?>

        <script>
				const togglePasswords = document.getElementById("togglePasswords");
				const passwords = document.getElementById("passwords");

				togglePasswords.addEventListener("click", () => {
					if (passwords.type === "password") {
						passwords.type = "text";
						togglePasswords.classList.remove("fa-eye-slash");
						togglePasswords.classList.add("fa-eye");
					} else {
						passwords.type = "password";
						togglePasswords.classList.remove("fa-eye");
						togglePasswords.classList.add("fa-eye-slash");
					}
					});

                const togglePassword = document.getElementById("togglePassword");
				const password = document.getElementById("password");

				togglePassword.addEventListener("click", () => {
					if (password.type === "password") {
						password.type = "text";
						togglePassword.classList.remove("fa-eye-slash");
						togglePassword.classList.add("fa-eye");
					} else {
						password.type = "password";
						togglePassword.classList.remove("fa-eye");
						togglePassword.classList.add("fa-eye-slash");
					}
					});
			</script>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Pansolian!</h1>
                    <p>Please enter your new password and start journey with us. To ensure the security of your account, 
                    please take a moment to enter your new password details. We recommend that you choose a strong and 
                    unique password that includes a combination of letters, numbers, and special characters. 
                    This will help protect your account from unauthorized access and keep your information safe.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>