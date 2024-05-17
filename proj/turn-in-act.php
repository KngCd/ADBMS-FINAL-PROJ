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

    <?php
        // Include the database configuration file
        require_once 'config.php';

        // If file upload form is submitted
        if (isset($_POST["submit"])) {
          $status = $statusMsg = '';
        
          // Get file info
          $fileName = basename($_FILES["document"]["name"]);
        
          $id = $_SESSION['id'];
          $classcode = $_POST['classcode'];
          $act_id = $_POST['act_id'];
          $comment = $_POST['comment'];
          $status = 1;
        
          // Allow certain file formats
          $allowTypes = array('pdf', 'doc', 'docx', 'txt','pptx', 'xlsx');
          if (in_array(pathinfo($fileName, PATHINFO_EXTENSION), $allowTypes)) {
              $document = $_FILES['document']['tmp_name'];
              $docContent = file_get_contents($document);
        
              // Get the file type
              $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
              // Fetch the class ID based on the selected subject name
              $query = mysqli_query($con, "SELECT t.Username, c.subject, cs.classcode FROM class_student cs JOIN class c ON cs.classcode = c.classcode 
              JOIN teachers t ON c.teacher_id = t.Id WHERE cs.student_id = '$id' AND c.classcode = '$classcode'");
              $classcodeRow = mysqli_fetch_assoc($query);
        
              // Check if a row was returned from the query
              if (!$classcodeRow) {
                  $status = 'error';
                  $statusMsg = "The selected subject does not exist for this student.";
              } else {
                  // Extract the classcode value from the result
                  $classcode = $classcodeRow['classcode'];
        
                  // Prepare the SQL statement with placeholders for the document content, file type, module name, and description
                  $stmt = $con->prepare("INSERT INTO activitylog (activity_id, file, comment, filetype, status, uploaded, classcode, student_id) VALUES (?,?,?,?,?, NOW(),?,?)");
                  $stmt->bind_param("sssssss", $act_id, $docContent, $comment, $fileType, $status, $classcode, $id);
        
                  // Execute the statement and check for success
                  if ($stmt->execute()) {
                    echo "<script>alert('Upload Successful!'); window.location.href='SHome.php';</script>";
                  } else {;
                    echo "<script>alert('Upload Unuccessful!'); window.location.href='SHome.php';</script>";
                  }
        
                  // Close the statement
                  $stmt->close();
              }
          } else {
            echo "<script>alert('Upload Unuccessful!'); window.location.href='SHome.php';</script>";
          }
        }
        else if (isset($_POST["hand-in"])) {
          $id = $_SESSION['id'];
          $classcode = $_POST['classcode'];
          $act_id = $_POST['act_id'];
          $comment = $_POST['comment'];
          $status = 1;

          // Fetch the class ID based on the selected subject name
          $query = mysqli_query($con, "SELECT t.Username, c.subject, cs.classcode FROM class_student cs JOIN class c ON cs.classcode = c.classcode 
          JOIN teachers t ON c.teacher_id = t.Id WHERE cs.student_id = '$id' AND c.classcode = '$classcode'");
          $classcodeRow = mysqli_fetch_assoc($query);

              // Check if a row was returned from the query
              if (!$classcodeRow) {
                  $status = 'error';
                  $statusMsg = "The selected subject does not exist for this student.";
              } else {
                  // Extract the classcode value from the result
                  $classcode = $classcodeRow['classcode'];
        
                  // Prepare the SQL statement with placeholders for the document content, file type, module name, and description
                  $stmt = $con->prepare("INSERT INTO activitylog (activity_id, comment, status, uploaded, classcode, student_id) VALUES (?,?,?, NOW(),?,?)");
                  $stmt->bind_param("sssss", $act_id, $comment, $status, $classcode, $id);
        
                  // Execute the statement and check for success
                  if ($stmt->execute()) {
                    echo "<script>alert('Upload Successful!'); window.location.href='SHome.php';</script>";
                  } else {
                      $status = 'error';
                      echo "<script>alert('Upload Unuccessful!'); window.location.href='SHome.php';</script>";
                  }
        
                  // Close the statement
                  $stmt->close();
              }

        }

      else{
    ?>

    <div class="upload" id="main">
  
                <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="head">
                        <i class="fa-solid fa-upload"></i>
                        <h3>Turn-in Activity</h3>
                    </div>
                    <div class="subject" style="margin-top: -20px; display: flex; align-items: center;">
                    <?php
                            include('config.php');
                            $id = $_SESSION['id'];
                            $classcode = $_POST['classcode'];
                            $act_id = $_POST['act_id'];

                            // Query the activity table for the row with the matching act_id
                            $query = mysqli_query($con, "SELECT c.subject, c.classcode, cs.classcode, cs.student_id, ac.act_id, 
                            ac.topic, ac.classcode, ac.teacher_id FROM class_student cs JOIN class c ON cs.classcode = c.classcode
                            JOIN activity ac ON c.classcode = ac.classcode WHERE ac.act_id = '$act_id' AND cs.student_id = '$id'");
                            $result = mysqli_num_rows($query);
                            $row = mysqli_fetch_assoc($query);
                        
                            if (isset($row)) {
                              echo '<div class="mod-container">';
                              echo '<label class="labelz">Subject : '. '<b>'. $row['subject'] . '</b>' . '</label>';
                              echo '<label class="labelz">Upload for : '. '<b>' . $row['topic'] . '</b>' .'</label>';
                              echo '</div>';
                          } else {
                              echo "No activity found with that ID.";
                          }

                        ?>
                    </div>
                      <input type="hidden" name="classcode" value="<?php echo $row['classcode']; ?>">
                      <input type="hidden" name="act_id" value="<?php echo $row['act_id']; ?>">
                    <div class="file" style="display: flex; align-items: center;">
                          <label>Select File to Upload:</label>
                          <input type="file" name="document" accept=".pdf,.doc,.docx,.txt,.pptx,.xlsx">
                    </div>
                    <div class="mod-container">
                        <label class="comment" for="input">Comment:</label>
                        <input class="mod" type="text" placeholder="Comment to the Teacher" name="comment" autocomplete="off" required />
                    </div>
                    <div class="field">
                        <input type="submit" name="submit" class="btn" value="Upload">
                        <input type="button" class="btn" name="submit" value="Back" onclick="window.history.back()">
                    </div>
                    <p style= "text-align:center;"> Note: If your going to submit output without uploading any file, please click Hand-in!</p>
                    <input type="submit" name="hand-in" class="btn" value="Hand-in">
                </form>
                <?php } ?>
    </div>

</body>
</html>
