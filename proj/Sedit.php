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
  <title>Update Profile</title>
</head>
<body>

  <div class="header">
        <div class="left-side">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><br><br>
            <a class="link" href="SHome.php"><i class="fa-solid fa-house"></i>Home</a>
            <a class="link" href="schedule_s.php"><i class="fa-regular fa-clock"></i>Schedule</a>
            <a class="link" href="calendar_s.php"><i class="fa-solid fa-calendar"></i>Calendar</a>
            <button class="dropdown-btn">
              <i class="fa-solid fa-graduation-cap"></i>
              <span>Enrolled<i class="fa fa-caret-down"></i></span>
            </button>
            <div class="dropdown-container">
            <?php 
                  session_start();
                  include('config.php');
                  $id = $_SESSION['id'];
                  $classcode = $_POST['classcode'];
      
                  // Fetch the classes created by the teacher from the database
                  $query = mysqli_query($con, "SELECT subject FROM class_student cs JOIN class c ON cs.classcode = c.classcode WHERE cs.student_id = '$id' 
                  AND c.classcode = '$classcode'");
                  $result = mysqli_num_rows($query);
                  $row = mysqli_fetch_assoc($query);
          
                  if (isset($row)) {
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $row['subject'] . '</a>';
                  }
                  ?>
                </div>
                <button class="dropdown-btn">
                   <i class="fa-solid fa-list-check"></i>
                  <span>To-Do<i class="fa fa-caret-down"></i></span>
                </button>
                <div class="dropdown-container">
                <?php 
                  include('config.php');
                  $id = $_SESSION['id'];
                  $classcode = $_POST['classcode'];

                  // Fetch the pending activities by the student from the database
                  $query = mysqli_query($con, "SELECT c.classcode, c.subject, cs.classcode, cs.student_id, ac.act_id, ac.activity, ac.topic, ac.classcode, ac.teacher_id
                  FROM class_student cs
                  JOIN class c ON cs.classcode = c.classcode 
                  JOIN activity ac ON c.classcode = ac.classcode
                  LEFT JOIN activitylog al ON ac.act_id = al.activity_id AND al.student_id = $id
                  WHERE cs.student_id = $id AND (al.activity_id IS NULL OR al.student_id IS NULL)");
                  $result = mysqli_num_rows($query);

                  if ($result == 0) {
                      echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . 'No Activities yet!' . '</a>';
                  } else {
                      // Loop through the classes and create a link for each class
                      for ($i = 0; $i < $result; $i++) {
                          $class = mysqli_fetch_assoc($query);
                          echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $class['topic'] . ' / '.'<b>' . $class['subject'] . '</b>'. '</a>';
                      }
                  }
              ?>
                </div>
                <button class="dropdown-btn">
                 <i class="fa-regular fa-handshake"></i>
                  <span>Meeting-Links<i class="fa fa-caret-down"></i></span>
                </button>
                <div class="dropdown-container">
                <?php 
                include('config.php');
                $id = $_SESSION['id'];

                // Fetch the pending activities by the student from the database
                $query = mysqli_query($con, "SELECT c.classcode, c.subject, cs.classcode, cs.student_id, m.link, m.classcode, m.teacher_id
                FROM class_student cs
                JOIN class c ON cs.classcode = c.classcode
                JOIN meetings m ON c.classcode = m.classcode AND c.teacher_id = m.teacher_id
                WHERE cs.student_id = $id");
                $result = mysqli_num_rows($query);

                if ($result == 0) {
                  echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . 'No Meetings yet!' . '</a>';
              } else {
                // Loop through the classes and create a link for each class
                for ($i = 0; $i < $result; $i++) {
                  $class = mysqli_fetch_assoc($query);
                  $link = $class['link']; // Fetch the link from the database
                  echo '<a class="link2" href="' . $link . '" target="_blank"><i class="fa-solid fa-link"></i>'. '- '.'<b>' . $class['subject'] . '</b>' . '</a>';
                }
              }
                ?>
                </div> <br><br><br><br>
            <a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</a>
          </div>

          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
          <i  id="school-icon" class="fa-solid fa-book-open"></i>
          <a class="tm" href="SHome.php"><p>Task Mastery</p> </a> 
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
    <button onclick="location.href='join-subject.php'">
            <i class="fa-solid fa-plus"></i>
      </button>
      <button onclick="location.href='Sedit.php'">
            <i class="fa-solid fa-user"></i>
      </button>
      <button onclick="location.href='tchat.php'">
            <i class="fa-solid fa-inbox"></i>
      </button>
      </div>
    </div>


    <div class="body-section" id="main">

        <?php
        include ('config.php');
            $id = $_SESSION['id'];

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $age = mysqli_real_escape_string($con, $_POST['age']);
                $address = mysqli_real_escape_string($con, $_POST['address']);

                // Update information on the database
                $edit_query = mysqli_query($con, "UPDATE users SET Username='$username', Email='$email', Age='$age', Address='$address' WHERE Id=$id") or die("error occurred");

                if ($edit_query) {
                    $_SESSION['success'] = "Update Successful!";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }

            }
            else{
        ?>
            <form class="form" action="" method="post">
                <h1>Update Profile</h1>
                 <div class="input-wrapper">
                        <input class="input" type="text" name="username" id="username" autocomplete="off" required></input>
                        <label for="input" class="placeholder">Username</label>
                 </div>
                 <div class="input-wrapper">
                        <input class="input" type="email" name="email" id="email" autocomplete="off" oninput="this.value = this.value.toLowerCase();" required>
                        <label for="input" class="placeholder">Email</label>
                 </div>
                <div class="input-wrapper">
                        <input class="input" type="number" name="age" id="age" autocomplete="off" required>
                        <label for="input" class="placeholder">Age</label>
                </div>
                <div class="input-wrapper">
                        <input class="input" type="text" name="address" id="address" autocomplete="off" required>
                        <label for="input" class="placeholder">Address</label>
                 </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Update">
                        <input type="button" class="btn" name="submit" value="Back" onclick="window.history.back()">
                    </div>
                </form>
                <?php   }?>

    </div>

<?php
if (isset($_SESSION['success'])) {
        echo "
        <div id='success-dialog' title='Successful' style='display: none; text-align:center; font-size: 15px;'>
            <p>{$_SESSION['success']}</p><br>
            <p>Click 'OK' to close this message.</p><br>
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
                            window.location.href = 'SHome.php';
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
            font-weight: lighter;
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
    } ?>
</body>
</html>