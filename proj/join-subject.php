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
  <title>Task Mastery</title>
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
      <p>Task Mastery</p>

      <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
      }

      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
      }
       function openNav() {
        document.getElementById("mySidenav").classList.add("open");
      }

      function closeNav() {
        document.getElementById("mySidenav").classList.remove("open");
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
      </div>

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

    <div class="body-section">
    <?php
            include('config.php');
            $id = $_SESSION['id'];
            $query = mysqli_query($con, "SELECT * FROM users WHERE Id = $id ");

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['join'])) {

                $classcode = mysqli_real_escape_string($con, $_POST['classcode']);

                // Check if the class code exists
                $sql = "SELECT * FROM class WHERE classcode = '$classcode'";
                $result = mysqli_query($con, $sql);


                if (mysqli_num_rows($result) == 0) {
                    // The class code is incorrect
                    $_SESSION['warning'] = "The class code is incorrect!";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    // Check if the student is already in the class
                    $sql = "SELECT * FROM class_student WHERE classcode = '$classcode' AND student_id = '$id'";
                    $result = mysqli_query($con, $sql);
                
                    if (mysqli_num_rows($result) > 0) {
                        // The student is already in the class
                        $_SESSION['Error'] = "You Already joined the class!";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        // Insert it into the database
                        $sql = "INSERT INTO class_student (classcode, student_id) VALUES ('$classcode', '$id')";
                        $result = mysqli_query($con, $sql);
                
                        if ($result) {
                            // The student has been added to the class
                            $_SESSION['success'] = "Joining Successful! Please Return to your home now.";
                            header('Location: ' . $_SERVER['PHP_SELF']);
                            exit;
                        } else {
                            // There was an error adding the student to the class
                            $_SESSION['error'] = "Joining Unsuccessful! Please try it again.";
                            header('Location: ' . $_SERVER['PHP_SELF']);
                            exit;
                        }
                    }
                }

                // Check if the student is already in the class
                $sql = "SELECT * FROM class_student WHERE classcode = '$classcode' AND student_id = '$id'";
                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // The student is already in the class
                    echo "You have already joined this class.";
                } else {
                    // Insert the random code, subject, and teacher's ID into the database
                    $sql = "INSERT INTO class_student (classcode, student_id) VALUES ('$classcode', '$id')";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        $_SESSION['success'] = "Joining Successful! Please Return to your home now.";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else{
                        $_SESSION['Error'] = "Joining Unsuccessful! Please Return to your home now.";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit; 
                    }
                }

            }
        else{
        ?>
        <div class="body-section">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-wrapper">
                    <input type='text' id='input' name="classcode" autocomplete="off" required >
                    <label for='input' class='placeholder'>Please enter Classcode</label>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="join" value="Join">
                    <input type="button" class="btn" name="submit" value="Back" onclick="window.history.back()">
                </div>
            </form>
        </div>
        <?php } ?>
</body>
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
    }elseif (isset($_SESSION['warning'])) {
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
    }elseif (isset($_SESSION['Error'])) {
        echo "
        <div id='error-dialog' title='Error' style='display: none; text-align:center; font-size: 15px;'>
            <p>{$_SESSION['Error']}</p>
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
        unset($_SESSION['Error']);
    }elseif (isset($_SESSION['error'])) {
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
?>
</html>

