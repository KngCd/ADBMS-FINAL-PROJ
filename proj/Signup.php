<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>User Registration</title>
</head>
<body>
 
        <div class="container">
            <div class="box form-box">

                <?php
                include("config.php");

                if(isset($_POST['submit'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $address = $_POST['Address'];
                    $school = $_POST['School'];
                    $age = $_POST['Age'];
                    $password = $_POST['password'];
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    // Verify if email is unique
                    $verify_query = mysqli_query($con, "SELECT 'user' as type, Email FROM users WHERE Email ='$email'
                                    UNION
                                    SELECT 'teacher' as type, Email FROM teachers WHERE Email ='$email'");

                    if(mysqli_num_rows($verify_query) != 0){
                        echo "<div class='message'>
                                <p>This email is already in use. Please choose another one.</p>
                              </div><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    } else {
                        if (isset($_POST['role'])){
                            $role = $_POST['role'];
                            if($role == "student"){
                                // Insert user into the students table
                                mysqli_query($con, "INSERT INTO users (Username, Email, Age, Password, School, Address) VALUES ('$username', '$email', '$age', '$hash','$school','$address')") or die("Error Occurred");

                                echo "<div class='message'>
                                        <p>Registration Successful</p>
                                      </div><br>";
                                echo "<a href='Login.php'><button class='btn'>Login Now</button>";
                            }
                            elseif($role == "teacher"){
                                // Insert user into the teachers table
                                mysqli_query($con, "INSERT INTO teachers (Username, Email, Age, Password, School, Address) VALUES ('$username', '$email', '$age', '$hash','$school','$address')") or die("Error Occurred");

                                echo "<div class='message'>
                                        <p>Registration Successful</p>
                                      </div><br>";
                                echo "<a href='Login.php'><button class='btn'>Login Now</button>";
                            }
                        }
                    }
                } else {
                ?>

                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">UserName</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" oninput="this.value = this.value.toLowerCase();" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="age">Age</label>
                        <input type="number" name="Age" id="Age" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="School">School</label>
                        <input type="text" name="School" id="school" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="Address">Address</label>
                        <input type="text" name="Address" id="address" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="radio-container">
                        <input type="radio" value="student" name="role" id="student" required>Student
                        <input type="radio" value="teacher" name="role" id="teacher" required>Teacher
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register">
                    </div>

                    <div class="link">
                        Already a member? <a href="Login.php">Sign in</a>
                    </div>
                </form>

                <?php } ?>

            </div>
        </div>
</body>
</html>