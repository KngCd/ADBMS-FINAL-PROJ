<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style4.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Task Mastery</title>
</head>
<body>

  <div class="header">
        <div class="left-side">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><br><br>
            <a class="link" href="THome.php"><i class="fa-solid fa-house"></i>Home</a>
            <a class="link" href="schedule_t.php"><i class="fa-regular fa-clock"></i>Schedule</a>
            <a class="link" href="calendar.php"><i class="fa-solid fa-calendar"></i>Calendar</a>
            <button class="dropdown-btn">
              <i class="fa-solid fa-graduation-cap"></i>
              <span>Class<i class="fa fa-caret-down"></i></span>
            </button>
            <div class="dropdown-container">
            <?php 
                  session_start();
                  include('config.php');
                  $id = $_SESSION['id'];;
      
                  // Fetch the classes created by the teacher from the database
                  $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id'");
                  $result = mysqli_num_rows($query);

                  // Loop through the classes and create a link for each class
                  for ($i = 0; $i < $result; $i++) {
                    $class = mysqli_fetch_assoc($query);
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $class['subject'] . '</a>';
                  }
                  ?>
                </div>
                <button class="dropdown-btn">
                  <i class="fa-regular fa-square-plus"></i>
                  <span>Add<i class="fa fa-caret-down"></i></span>
                </button>
                <div class="dropdown-container">
                  <a class="link2" href="upload_module.php"><i class="fa fa-circle fa-fw"></i>Module</a>
                  <a class="link2" href="upload_act.php"><i class="fa fa-circle fa-fw"></i>Activity</a>
                  <a class="link2" href="upload_ann.php"><i class="fa fa-circle fa-fw"></i>Announcement</a>
                  <a class="link2" href="meeting.php"><i class="fa fa-circle fa-fw"></i>Meeting</a>
                </div>
            <a class="link" href="#"><i class="fa-solid fa-chart-bar"></i>Monitor Students</a><br><br><br><br>
            <a class="link" href="LoginSignup.php"><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</a>
          </div>

          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
          <i  id="school-icon" class="fa-solid fa-book-open"></i>
          <a class="tm" href="THome.php"><p>Task Mastery</p> </a>
            </div>
          <script>
            function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
            }

            function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
            }

          </script>
          <script>
          /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
          var dropdown = document.getElementsByClassName("dropdown-btn");
          var i;

          for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
              this.classList.toggle("active");
              var dropdownContent = this.nextElementSibling;
              if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
              } else {
                dropdownContent.style.display = "block";
              }
            });
          }
          </script>

    <div class="right-side">
    <button onclick="location.href='create-subject.php'">
            <i class="fa-solid fa-plus"></i>
      </button>
      <button onclick="location.href='Tedit.php'">
            <i class="fa-solid fa-user"></i>
        </button>
        <button onclick="location.href='tchat.php'">
            <i class="fa-solid fa-inbox"></i>
      </button>
      </div>
    </div>
<div class="main">
    <div class="table" id="main">
             <form class="forms" action="" method="post" enctype="multipart/form-data">
                    <div class="subject" style="display: flex; align-items: center;">
                        <label for="subject">Filter for : </label>&nbsp;
                        <select name="subject" class="select" id="subject" required>
                            <option value="">Select a Section</option>
                            <?php
                            session_start();
                            include('config.php');
                            $id = $_SESSION['id'];

                            // Fetch the classes created by the teacher from the database
                            $query = mysqli_query($con, "SELECT DISTINCT section FROM class WHERE teacher_id = '$id'");
                            $result = mysqli_num_rows($query);

                            // Loop through the classes and create an option for each class
                            for ($i = 0; $i < $result; $i++) {
                                $class = mysqli_fetch_assoc($query);
                                echo '<option value="' . $class['section'] . '">' . $class['section'] . '</option>';
                            }
                            ?>
                        </select>
                    
                    <div class="field">
                        <input type="submit" name="submit" class="btn" value="Filter">
                    </div>
                    </div>
                </form>
      <?php
        include('config.php');

        $id = $_SESSION['id'];
        
        if (isset($_POST['submit'])) {
            $section = $_POST['subject'];
            // Query the logs table for the row with the matching student_id and subject
            $query = mysqli_query($con, "SELECT u.username, cs.student_id, cs.classcode, c.classcode, c.section, c.subject, c.teacher_id
            FROM class_student cs JOIN users u ON cs.student_id = u.Id JOIN class c on cs.classcode = c.classcode
            WHERE c.teacher_id = $id AND c.section = '$section'");
            echo '<table border="2px" style="border-collapse: collapse; width: 100%">';
            echo '<tr style="width: 100%;">';
            echo '<th style="width: 100px; text-align: center;">Subject</th>';
            echo '<th style="width: 100px; text-align: center;">Student</th>';
            echo '<th style="width: 100px; text-align: center;">Login</th>';
            echo '<th style="width: 100px; text-align: center;">Logout</th>';
            echo '<th style="width: 100px; text-align: center;">Time Elapsed</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($query)) {
                echo '<tr style="width: 100%;">';
                echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
            
                $verify_query = mysqli_query($con, "SELECT l.user_id FROM login_log l WHERE user_id = $row[student_id]
                UNION
                SELECT lo.user_id FROM logout_log lo WHERE user_id = $row[student_id]");
            
                if(mysqli_num_rows($verify_query) != 0){
                    // Check the login
                    $sql_login = mysqli_query($con, "SELECT * FROM login_log WHERE user_id = $row[student_id]");
                    $login_times = [];
                    while ($result_login = mysqli_fetch_assoc($sql_login)) {
                        $login_times[] = $result_login['login_time'];
                    }
            
                    // Check the logout
                    $sql_logout = mysqli_query($con, "SELECT * FROM logout_log WHERE user_id = $row[student_id]");
                    $logout_times = [];
                    while ($result_logout = mysqli_fetch_assoc($sql_logout)) {
                        $logout_times[] = $result_logout['logout_time'];
                    }
            
                    $min_count = min(count($login_times), count($logout_times));
            
                    // Calculate time intervals
                    $time_intervals = [];
                    for ($i = 0; $i < $min_count; $i++) {
                        $login_time = new DateTime($login_times[$i]);
                        $logout_time = new DateTime($logout_times[$i]);
                        $interval = $login_time->diff($logout_time);
                        $time_intervals[] = $interval->format("%H:%I:%S");
                    }
            
                    // Display the minimum count of login and logout times
                    for ($i = 0; $i < $min_count; $i++) {
                        echo '<tr style="width: 100%;">';
                        echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                        echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
            
                        if (isset($login_times[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $login_times[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                        }
            
                        if (isset($logout_times[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $logout_times[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                        }
            
                        if (isset($time_intervals[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $time_intervals[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">';
                            if (count($login_times) == 0 || count($logout_times) == 0) {
                                echo "No records";
                            }
                            echo '</td>';
                        }
            
                        echo '</tr>';
                    }
            
                    // Display any remaining login or logout times
                    if (count($login_times) > $min_count) {
                        for ($i = $min_count; $i < count($login_times); $i++) {
                            echo '<tr style="width: 100%;">';
                            echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $login_times[$i] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '</tr>';
                        }
                    }
            
                    if (count($logout_times) > $min_count) {
                        for ($i = $min_count; $i < count($logout_times); $i++) {
                            echo '<tr style="width: 100%;">';
                            echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $logout_times[$i] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '</tr>';
                        }
                    }
                } else {
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                }
                echo '</tr>';
            }
            echo '</table>';

        }else {
            // Query the logs table for the row with the matching student_id
            $query = mysqli_query($con, "SELECT u.username, cs.student_id, cs.classcode, c.classcode, c.subject, c.teacher_id
            FROM class_student cs JOIN users u ON cs.student_id = u.Id JOIN class c on cs.classcode = c.classcode
            WHERE c.teacher_id = $id");
            $result = mysqli_num_rows($query);

            echo '<table border="2px" style="border-collapse: collapse; width: 100%">';
            echo '<tr style="width: 100%;">';
            echo '<th style="width: 100px; text-align: center;">Subject</th>';
            echo '<th style="width: 100px; text-align: center;">Student</th>';
            echo '<th style="width: 100px; text-align: center;">Login</th>';
            echo '<th style="width: 100px; text-align: center;">Logout</th>';
            echo '<th style="width: 100px; text-align: center;">Time Elapsed</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($query)) {
                echo '<tr style="width: 100%;">';
                echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
            
                $verify_query = mysqli_query($con, "SELECT l.user_id FROM login_log l WHERE user_id = $row[student_id]
                UNION
                SELECT lo.user_id FROM logout_log lo WHERE user_id = $row[student_id]");
            
                if(mysqli_num_rows($verify_query) != 0){
                    // Check the login
                    $sql_login = mysqli_query($con, "SELECT * FROM login_log WHERE user_id = $row[student_id]");
                    $login_times = [];
                    while ($result_login = mysqli_fetch_assoc($sql_login)) {
                        $login_times[] = $result_login['login_time'];
                    }
            
                    // Check the logout
                    $sql_logout = mysqli_query($con, "SELECT * FROM logout_log WHERE user_id = $row[student_id]");
                    $logout_times = [];
                    while ($result_logout = mysqli_fetch_assoc($sql_logout)) {
                        $logout_times[] = $result_logout['logout_time'];
                    }
            
                    $min_count = min(count($login_times), count($logout_times));
            
                    // Calculate time intervals
                    $time_intervals = [];
                    for ($i = 0; $i < $min_count; $i++) {
                        $login_time = new DateTime($login_times[$i]);
                        $logout_time = new DateTime($logout_times[$i]);
                        $interval = $login_time->diff($logout_time);
                        $time_intervals[] = $interval->format("%H:%I:%S");
                    }
            
                    // Display the minimum count of login and logout times
                    for ($i = 0; $i < $min_count; $i++) {
                        echo '<tr style="width: 100%;">';
                        echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                        echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
            
                        if (isset($login_times[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $login_times[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                        }
            
                        if (isset($logout_times[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $logout_times[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                        }
            
                        if (isset($time_intervals[$i])) {
                            echo '<td style="width: 100px; text-align: center;">' . $time_intervals[$i] . '</td>';
                        } else {
                            echo '<td style="width: 100px; text-align: center;">';
                            if (count($login_times) == 0 || count($logout_times) == 0) {
                                echo "No records";
                            }
                            echo '</td>';
                        }
            
                        echo '</tr>';
                    }
            
                    // Display any remaining login or logout times
                    if (count($login_times) > $min_count) {
                        for ($i = $min_count; $i < count($login_times); $i++) {
                            echo '<tr style="width: 100%;">';
                            echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $login_times[$i] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '</tr>';
                        }
                    }
            
                    if (count($logout_times) > $min_count) {
                        for ($i = $min_count; $i < count($logout_times); $i++) {
                            echo '<tr style="width: 100%;">';
                            echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $row['username'] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '<td style="width: 100px; text-align: center;">' . $logout_times[$i] . '</td>';
                            echo '<td style="width: 100px; text-align: center;">No records</td>';
                            echo '</tr>';
                        }
                    }
                } else {
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                    echo '<td style="width: 100px; text-align: center;">No records</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }

        ?>

    </div>
    </div>
</body>
</html>