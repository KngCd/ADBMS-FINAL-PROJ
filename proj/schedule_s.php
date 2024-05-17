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
      
                  // Fetch the classes joined by the student from the database
                  $query = mysqli_query($con, "SELECT subject FROM class_student cs JOIN class c ON cs.classcode = c.classcode WHERE student_id = '$id'");
                  $result = mysqli_num_rows($query);
                 
                  if ($result == 0) {
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . 'No Classes yet!' . '</a>';
                } else {
                    // Loop through the classes and create a link for each class
                    for ($i = 0; $i < $result; $i++) {
                        $class = mysqli_fetch_assoc($query);
                        echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $class['subject'] . '</a>';
                    }
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
<div class="main">
    <div class="table" id="main">
             <form class="forms" action="" method="post" enctype="multipart/form-data">
                    <div class="subject" style="display: flex; align-items: center;">
                        <label for="subject">Filter for : </label>&nbsp;
                        <select name="subject" class="select" id="subject" required>
                            <option value="">Select a Subject</option>
                            <?php
                            session_start();
                            include('config.php');
                            $id = $_SESSION['id'];

                            // Fetch the classes created by the teacher from the database
                            $query = mysqli_query($con, "SELECT c.section, c.subject FROM class_student cs JOIN class c ON cs.classcode = c.classcode
                            WHERE student_id = '$id'");
                            $result = mysqli_num_rows($query);

                            // Loop through the classes and create an option for each class
                            for ($i = 0; $i < $result; $i++) {
                                $class = mysqli_fetch_assoc($query);
                                echo '<option value="' . $class['subject'] . '">' . $class['subject'] . '</option>';
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
            $subject = $_POST['subject'];
            // Query the logs table for the row with the matching student_id and subject
            $query = mysqli_query($con, "SELECT t.Username, c.classcode, c.subject, c.section, c.schedule
            FROM class_student cs JOIN class c ON cs.classcode = c.classcode JOIN teachers t ON c.teacher_id = t.Id
            WHERE student_id = $id AND subject = '$subject'");
            echo '<table border="2px" style="border-collapse: collapse; width: 100%">';
            echo '<tr style="width: 100%;">';
            echo '<th style="width: 100px; text-align: center;">Teacher</th>';
            echo '<th style="width: 100px; text-align: center;">Subject</th>';
            echo '<th style="width: 100px; text-align: center;">Section</th>';
            echo '<th style="width: 100px; text-align: center;">Schedule</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($query)) {
                echo '<tr style="width: 100%;">';
                echo '<td style="width: 100px; text-align: center;">' . $row['Username'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['section'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['schedule'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

        }else {
            // Query the logs table for the row with the matching student_id
            $query = mysqli_query($con, "SELECT t.Username, c.classcode, c.subject, c.section, c.schedule
            FROM class_student cs JOIN class c ON cs.classcode = c.classcode JOIN teachers t ON c.teacher_id = t.Id
            WHERE student_id = $id");
            $result = mysqli_num_rows($query);

            echo '<table border="2px" style="border-collapse: collapse; width: 100%">';
            echo '<tr style="width: 100%;">';
            echo '<th style="width: 100px; text-align: center;">Teacher</th>';
            echo '<th style="width: 100px; text-align: center;">Subject</th>';
            echo '<th style="width: 100px; text-align: center;">Section</th>';
            echo '<th style="width: 100px; text-align: center;">Schedule</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($query)) {
                echo '<tr style="width: 100%;">';
                echo '<td style="width: 100px; text-align: center;">' . $row['Username'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['section'] . '</td>';
                echo '<td style="width: 100px; text-align: center;">' . $row['schedule'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        ?>

    </div>
    </div>
</body>
</html>