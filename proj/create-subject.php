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
  <title>Create Class</title>
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
        <a class="link" href="monitor.php"><i class="fa-solid fa-chart-bar"></i>Monitor Students</a><br><br><br><br>
        <a class="link" href="LoginSignup.php"><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</a>
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
    <button onclick="location.href='#'">
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

    <div class="body-section">
    <?php
            include('config.php');
            $id = $_SESSION['id'];
            $query = mysqli_query($con, "SELECT * FROM teachers WHERE Id = $id ");

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {

                function generateRandomCode($length = 6, $con) {
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomCode = '';

                    do {
                        $randomCode = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomCode .= $characters[rand(0, strlen($characters) - 1)];
                        }

                        // Check if the random code already exists in the database
                        $query = mysqli_query($con, "SELECT * FROM class WHERE classcode = '$randomCode'");
                        $result = mysqli_num_rows($query);

                    } while ($result > 0); // Generate a new random code if the current one already exists

                    return $randomCode;
                }

                $randomCode = generateRandomCode(6, $con);
                $subject = mysqli_real_escape_string($con, $_POST['subject']);
                $section = mysqli_real_escape_string($con, $_POST['section']);
                $schedule = mysqli_real_escape_string($con, $_POST['schedule']);
                $_SESSION['randomCode'] = $randomCode;
                $_SESSION['subject'] = $subject;
                $_SESSION['section'] = $section;
                $_SESSION['schedule'] = $schedule;

                // Insert the random code, subject, and teacher's ID into the database
                $sql = "INSERT INTO class (classcode, subject, section, schedule, teacher_id) VALUES ('$randomCode', '$subject', '$section', '$schedule', '$id')";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    $_SESSION['success'] = "Creation Successful! Please Send it to your students now";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            }
        else{
        ?>
        <div class="body-section">
            <form class="class" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-wrapper">
                    <input type='text' id='input' name="subject" autocomplete="off" required >
                    <label for='input' class='placeholder'>Subject Name</label>
                </div>
                <div class="input-wrapper">
                    <input type='text' id='input' name="section" autocomplete="off" required >
                    <label for='input' class='placeholder'>Section</label>
                </div>
                <div class="input-wrapper">
                    <input type='text' id='input' name="schedule" autocomplete="off" required >
                    <label for='input' class='placeholder'>Schedule</label>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="create" value="Create">
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
            <p>Your class code for <strong>{$_SESSION['subject']}</strong> is <strong>{$_SESSION['randomCode']}</strong> </p>
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
                            window.location.href = 'THome.php';
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
    }
?>
</html>

