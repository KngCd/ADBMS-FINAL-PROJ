<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Login</title>
</head>
<body>
        <div class="container"> 
            <div class="box form-box">
                <?php
                include("config.php");


                if (isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    

                    // When the user creates their account
                    $password = $_POST['password'];
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // When the user logs in
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $result = mysqli_query($con, "SELECT * FROM users WHERE Email='$email'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if (empty($row)) {
                        // If not found in Students table, check the Teachers table
                        $result = mysqli_query($con, "SELECT * FROM teachers WHERE Email='$email'") or die("Select Error");
                        $row = mysqli_fetch_assoc($result);
                    }

                    if (is_array($row) && !empty($row)) {
                        // Verify the hashed password
                        if (password_verify($password, $row['Password'])) {
                            $_SESSION['valid'] = true; // Set a variable for successful login
                            $_SESSION['username'] = $row['Username'];
                            $_SESSION['age'] = $row['Age'];
                            $_SESSION['id'] = $row['Id'];
                            $role = isset($_POST['role']) ? $_POST['role'] : '';

                            // Redirect to the appropriate home page
                            if ($role == 'students') {
                                header("Location: SHome.php");
                            } elseif ($role == 'teachers') {
                                header("Location: THome.php");
                            }
                            exit();
                        } else {
                            echo "<div class='message'>
                                <p>Wrong Username or Password</p>
                                </div> <br>";
                            echo "<a href='Login.php'><button class='btn'>Go Back</button>";
                        }
                    }
                } else {
                ?>
                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" oninput="this.value = this.value.toLowerCase();" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="radio-container">
                        <input type="radio" value="students" name="role" id="students" required>Student
                        <input type="radio" value="teachers" name="role" id="teachers" required>Teacher
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    
                    <div class="links">
                        Don't have an account? <a href="Signup.php">Sign Up Now</a>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
</body>
</html>