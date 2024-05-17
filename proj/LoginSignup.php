<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin/Signup</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
		<?php
                include("config.php");

                if(isset($_POST['register_submit'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $address = $_POST['address'];
                    //$school = $_POST['school'];
                    $age = $_POST['age'];
                    $password = $_POST['password'];
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    // Verify if email is unique
                    $verify_query = mysqli_query($con, "SELECT 'user' as type, Email FROM users WHERE Email ='$email'
                                    UNION
                                    SELECT 'teacher' as type, Email FROM teachers WHERE Email ='$email'");

                    if(mysqli_num_rows($verify_query) != 0){
                        $_SESSION['error'] = "This email is already in use. Please choose another one.";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        if (isset($_POST['role'])){
                            $role = $_POST['role'];
                            if($role == "student"){
                                // Insert user into the students table
                                mysqli_query($con, "INSERT INTO users (Username, Email, Age, Password, Address) VALUES ('$username', '$email', '$age', '$hash','$address')") or die("Error Occurred");

                                $_SESSION['success'] = "Registration Successful! Please Login now.";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                            elseif($role == "teacher"){
                                // Insert user into the teachers table
                                mysqli_query($con, "INSERT INTO teachers (Username, Email, Age, Password, Address) VALUES ('$username', '$email', '$age', '$hash','$address')") or die("Error Occurred");

                                $_SESSION['success'] = "Registration Successful! Please Login now.";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                        }
                    }
                } else {
                ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="username" id="username" autocomplete="off" required />
                <input type="email" placeholder="Email" name="email" id="email" autocomplete="off" oninput="this.value = this.value.toLowerCase();" required/>
				<input type="number" placeholder="Age" name="age" id="age" autocomplete="off" required/>
				<input type="text" placeholder="Address" name="address" id="address" autocomplete="off" required/>
            
				<div class="password-wrapper">
					<i class="far fa-eye-slash" id="togglePassword"></i>
					<input type="password" placeholder="Password" name="password" id="password" autocomplete="off" required />
				</div>
				<div class="radio-container">
					<input type="radio" value="student" name="role" id="student" required><label for="student">Student</label>
					<input type="radio" value="teacher" name="role" id="teacher" required><label for="teacher">Teacher</label>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="register_submit" value="Sign up">
                </div>
            </form>
			<?php } ?>
            <?php
    if (isset($_SESSION['error'])) {
        echo "
        <div id='error-dialog' title='Error' style='display: none; text-align:center; font-size: 15px;'>
            <p>{$_SESSION['error']}</p>
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
        unset($_SESSION['error']);
    }
    elseif (isset($_SESSION['success'])) {
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
        </div>
		<script>
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


        <div class="form-container sign-in-container">
        <?php
                include("config.php");


                if (isset($_POST['login_submit'])) {
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $role = isset($_POST['role']) ? $_POST['role'] : '';

                    if ($role == 'student') {
                        // When the user creates their account
                        $password = $_POST['password'];
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                        // When the user logs in
                        $stmt = $con->prepare("SELECT * FROM users WHERE Email=?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                    
                        if (is_array($row) && !empty($row)) {
                            $login_timestamp = null;
                            // Verify the hashed password
                            if (password_verify($password, $row['Password']) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                // Set a variable for successful login
                                $_SESSION['valid'] = true;
                                $_SESSION['username'] = $row['Username'];
                                $_SESSION['age'] = $row['Age'];
                                $_SESSION['id'] = $row['Id'];

                                // Insert the login timestamp
                                $query = "INSERT INTO login_log (user_id, login_time) VALUES (?, NOW())";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $row['Id']);
                                $stmt->execute();              
                    
                                // Redirect to the appropriate home page
                                header("Location: SHome.php");
                                exit();
                            } else {
                                $_SESSION['warning'] = "Wrong Email or Password!";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                        } else {
                            $_SESSION['warning'] = "No student account found with this email. Please select the appropriate role or check the email and try again.";
                            header('Location: ' . $_SERVER['PHP_SELF']);
                            exit;
                        }
                    }
                    elseif ($role == 'teacher') {
                        // When the user creates their account
                        $password = $_POST['password'];
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                        // When the user logs in
                        $stmt = $con->prepare("SELECT * FROM teachers WHERE Email=?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                    
                        if (is_array($row) && !empty($row)) {
                            // Verify the hashed password
                            if (password_verify($password, $row['Password']) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                // Set a variable for successful login
                                $_SESSION['valid'] = true;
                                $_SESSION['username'] = $row['Username'];
                                $_SESSION['age'] = $row['Age'];
                                $_SESSION['id'] = $row['Id'];
                    
                                // Redirect to the appropriate home page
                                header("Location: THome.php");
                                exit();
                            } else {
                                $_SESSION['warning'] = "Wrong Email or Password!";
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit;
                            }
                        } else {
                            $_SESSION['warning'] = "No teacher account found with this email. Please select the appropriate role or check the email and try again.";
                            header('Location: ' . $_SERVER['PHP_SELF']);
                            exit;
                        }
                    }

                } else {
                ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Sign in</h1>
				<input type="email" placeholder="Email" name="email" id="email" autocomplete="off" oninput="this.value = this.value.toLowerCase();" required/>
				<div class="password-wrapper">
					<i class="far fa-eye-slash" id="togglePasswords"></i>
					<input type="password" placeholder="Password" name="password" id="passwords" autocomplete="off" required />
				</div>

				<div class="radio-container">
					<input type="radio" value="student" name="role" id="student" required><label for="student">Student</label>
					<input type="radio" value="teacher" name="role" id="teacher" required><label for="teacher">Teacher</label>
                </div>
                <a class="forgot" href="reset_password.php">Forgot your password?</a>
				<div class="field">
                    <input type="submit" class="btn" name="login_submit" value="Sign in">
                </div>
            </form>
			<?php } ?>
        </div>
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
			</script>
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
    }?>
		

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Pansolian!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
		const signUpButton = document.getElementById('signUp');
		const signInButton = document.getElementById('signIn');
		const container = document.getElementById('container');

		signUpButton.addEventListener('click', () =>
		container.classList.add('right-panel-active'));

		signInButton.addEventListener('click', () =>
		container.classList.remove('right-panel-active'));
		</script>
</body>

</html>