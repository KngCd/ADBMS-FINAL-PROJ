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

                  $id = $_SESSION['id'];
                  $classcode = $_POST['classcode'];
      
                  // Fetch the classes created by the teacher from the database
                  $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id' AND classcode = '$classcode'");
                  
                  $result = mysqli_num_rows($query);
                  $row = mysqli_fetch_assoc($query);
          
                  if (isset($row)) {
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $row['subject'] . '</a>';
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
          <a class="tm" href="THome.php"><p>Task Mastery</p> </a> <i class="fa-solid fa-greater-than"></i>
          <?php
             $id = $_SESSION['id'];
             $classcode = isset($_POST['classcode']) ? mysqli_real_escape_string($con, $_POST['classcode']) : '';

             $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id' AND classcode = '$classcode'");
             $result = mysqli_num_rows($query);
             $row = mysqli_fetch_assoc($query);
     
             if (isset($row)) {
               echo '<div class="sub">' . $row['subject'] . '</div>';
             }

          ?>
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
      <?php
        include('config.php');

        $id = $_SESSION['id'];
        $classcode = $_POST['classcode'];
        $act_id = $_POST['act_id'];

        $query = mysqli_query($con, "SELECT c.subject, c.classcode, c.teacher_id, cs.student_id, u.Username, ac.act_id,
        ac.topic, ac.points, ac.classcode as activity_classcode, ac.due_date, ac.time, ac.teacher_id, al.student_id, al.file, al.filetype, al.comment, al.uploaded
        FROM class_student cs
        JOIN class c ON cs.classcode = c.classcode
        JOIN users u ON cs.student_id = u.Id
        JOIN activity ac ON c.classcode = ac.classcode
        JOIN activitylog al ON cs.student_id = al.student_id AND ac.act_id = al.activity_id
        WHERE ac.act_id = '$act_id' AND c.teacher_id = '$id' AND ac.classcode = '$classcode'
        ORDER BY al.uploaded ASC");
        $result = mysqli_num_rows($query);

        echo '<table border="2px" style="border-collapse: collapse; width: 100%">';
        echo '<tr style="width: 100%;">';
        echo '<th style="width: 100px; text-align: center;">Activity Name</th>';
        echo '<th style="width: 100px; text-align: center;">Subject</th>';
        echo '<th style="width: 100px; text-align: center;">Student</th>';
        echo '<th style="width: 50pxpx; text-align: center;">Output</th>';
        echo '<th style="width: 100px; text-align: center;">Comment</th>';
        echo '<th style="width: 100px; text-align: center;">Points</th>';
        echo '<th style="width: 100px; text-align: center;">Status</th>';
        echo '<th style="width: 100px; text-align: center;">Marks</th>';
        echo '<th style="width: 100px; text-align: center;">Due Date</th>';
        echo '<th style="width: 100px; text-align: center;">Date Submitted</th>';
        echo '</tr>';

        while ($row = mysqli_fetch_assoc($query)) {
            echo '<tr style="width: 100%;">';
            echo '<td style="width: 100px; text-align: center;">' . $row['topic'] . '</td>';
            echo '<td style="width: 100px; text-align: center;">' . $row['subject'] . '</td>';
            echo '<td style="width: 100px; text-align: center;">' . $row['Username'] . '</td>';
            if ($row['filetype'] === 'pptx' || $row['filetype'] === 'txt' || $row['filetype'] === 'xlsx' || $row['filetype'] === 'docx' || $row['filetype'] === 'doc') {
              echo '<td style="width: 50px; text-align: center;"><a class="view-pdf-link-2"  href="data:application/octet-stream;base64,'. base64_encode($row['file']).'" download="'. $row['topic']. '_'.$row['Username'].'.'. $row['filetype'].'">Download Activity</a></td>';
            }
            else if($row['filetype'] === 'pdf'){
              echo '<td style="width: 50px; text-align: center;"><a href="#" class="view-pdf-link-2" onclick="viewPDF(\''. base64_encode($row['file']). '\', \''. $row['topic'].'_'.$row['Username'].'.pdf\')">View Activity</a></td>';
            }
            else{
              echo '<td style="width: 70px; text-align: center;"> No Output Submitted</td>';
            }
            echo '<td style="width: 100px; text-align: center;">' . $row['comment'] . '</td>';
            echo '<td style="width: 100px; text-align: center;">' . $row['points'] . '</td>';

            // Check if the student ID exists in the activity log
            $activitylog_query = mysqli_query($con, "SELECT * FROM activitylog al JOIN activity ac ON al.activity_id = ac.act_id WHERE student_id = $row[student_id] AND activity_id = $act_id");
          
            if (mysqli_num_rows($activitylog_query) > 0) {
                $student_status = 'Done';
            }
            else {
              $student_status = 'Missing';
              
            }
            echo '<td style="width: 100px; text-align: center;">' . $student_status . '</td>';          
           
            // Check if the grades have already been inserted for the student
            $sql = mysqli_query($con, "SELECT * FROM activitygrade WHERE act_id = $act_id AND teacher_id = $id AND student_id = $row[student_id]");
            $result = mysqli_fetch_assoc($sql);

            if ($result) {
                // Display the marks instead of the form
                echo '<td style="width: 100px; text-align: center;">' . $result['grades'] . "</td>";
            } else {
                // Display the form
                echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">';
                echo '<div class="input-container">';
                echo '<input type="hidden" name="classcode" value="' . $classcode . '">';
                echo '<input type="hidden" name="act_id" value="' . $act_id . '">';
                echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
                echo '<td> '.'<input class="marks" type="number" name="marks" autocomplete="off" required /><br>'.'
                <input type="submit" name="submit" class="go" value="Go"></td>';
                echo '</div>';
                echo '</form>';
            }
            echo '<td style="width: 100px; text-align: center;">' . date('F j, Y g:i A', strtotime($row['due_date'].' '.$row['time'])) . '</td>';
            echo '<td style="width: 100px; text-align: center;">' . date('F j, Y g:i A', strtotime($row['uploaded'])) . '</td>';
            echo '</tr>';
        }

        echo '</table>';

        ?>

        <?php
        // Include the database configuration file
        include ('config.php');

        // If file upload form is submitted
        if (isset($_POST["submit"])) {
            $id = $_SESSION['id'];
            $classcode = $_POST['classcode'];
            $act_id = $_POST['act_id'];
            $marks = $_POST['marks'];
            $student_id = $_POST['student_id'];

            $sql = mysqli_query($con, "SELECT points FROM activity WHERE act_id = $act_id AND teacher_id = $id");
            $result = mysqli_fetch_assoc($sql);

            $points = $result['points'];

            if ($marks > $points) {
                echo "<script>alert('The marks you entered are greater than the allowed points.'); window.location.href='THome.php';</script>";
            } else {
                // Prepare the SQL statement with placeholders for the document content, file type, module name, and description
                $stmt = $con->prepare("INSERT INTO activitygrade (act_id, grades, student_id, teacher_id) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $act_id, $marks, $student_id, $id);

                // Execute the statement and check for success
                if ($stmt->execute()) {
                    echo "<script>alert('Grading Successful!'); window.location.href='THome.php';</script>";
                } else {
                  echo "<script>alert('Grading Error!'); window.location.href='THome.php';</script>";
                  }
            }
        }
        ?>

    </div>
      </div>
      <script>
              function viewPDF(data, filename) {
                // Create a Blob object from the base64-encoded PDF data
                const byteNumbers = atob(data);
                const byteNumbersLength = byteNumbers.length;
                const u8arr = new Uint8Array(byteNumbersLength);
                for (let i = 0; i < byteNumbersLength; i++) {
                  u8arr[i] = byteNumbers.charCodeAt(i);
                }
                const blob = new Blob([u8arr], { type: 'application/pdf' });

                // Create an object URL for the Blob
                const url = URL.createObjectURL(blob);

                window.open(url, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,status=yes');
              }
            </script>
</body>
</html>