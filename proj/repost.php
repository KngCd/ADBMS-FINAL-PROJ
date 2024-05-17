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
            <a class="link" href="THome.php"><i class="fa-solid fa-house"></i>Home</a>
            <a class="link" href="#"><i class="fa-solid fa-calendar"></i>Calendar</a>
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
                  <a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>Activity</a>
                  <a class="link2" href="upload_ann.php"><i class="fa fa-circle fa-fw"></i>Announcement</a>
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
      <button>
            <i class="fa-solid fa-plus"></i>
      </button>
      <button>
            <i class="fa-solid fa-user"></i>
        </button>
      </div>
    </div>

    <?php
            // Include the database configuration file
            require_once 'config.php';
            $id = $_SESSION['id'];

            // Check if the form is submitted
            if (isset($_POST["submit"])) {
                // Get the classcode and act_id values from the form
                $classcode = $_POST['classcode'];
                $act_id = $_POST['act_id'];

                // Fetch the rows associated with the passed act_id and classcode
                $stmt = $con->prepare("
                    SELECT ac.activity, ac.topic, ac.description, ac.points, ac.due_date, ac.time, ac.filetype,
                    ac.classcode, ac.teacher_id
                    FROM activity ac
                    JOIN class c ON ac.classcode = c.classcode
                    WHERE ac.act_id = ? AND ac.classcode = ? AND ac.teacher_id = ?
                ");
                $stmt->bind_param("sss", $act_id, $classcode, $id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch the row as an associative array
                $row = $result->fetch_assoc();

                // Check if any rows were returned from the query
                if ($row) {
                    // Extract the necessary columns from the result
                    $existingDocContent = $row['activity'];
                    $topic = $row['topic'];
                    $description = $row['description'];
                    $points = $row['points'];
                    $due = $row['due_date'];
                    $time = $row['time'];
                    $fileType = strtolower($row['filetype']);

                    // Prepare the SQL statement with placeholders for the document content, file type, module name, and description
                    $stmt = $con->prepare("INSERT INTO activity (activity, topic, description, points, due_date, time, filetype, uploaded, classcode, teacher_id) VALUES (?,?,?,?,?,?,?, NOW(),?,?)");
                    $stmt->bind_param("sssssssss", $existingDocContent, $topic, $description, $points , $due, $time, $fileType, $class, $id);

                    // Execute the statement and check for success
                    if ($stmt->execute()) {
                        echo "<script>alert('Upload Successful!'); window.location.href='THome.php';</script>";
                    } else {
                        echo "<script>alert('Uploading Failed!'); window.location.href='THome.php';</script>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "No rows found for the selected act_id and classcode!";
                }
            } else {
                echo "No rows found for the selected act_id and classcode!";
            }
        ?>

        <div class="upload" id="main">
    
                    <form class="form" action="" method="post" enctype="multipart/form-data">
                        <div class="head">
                            <i class="fa-solid fa-upload"></i>
                            <h3>Upload Activity</h3>
                        </div>
                        <div class="subject" style="display: flex; align-items: center;">
                            <label for="subject">Upload for :</label>
                            <select name="subject" class="select" id="subject" required>
                            
                                <?php
                                session_start();
                                include('config.php');
                                $id = $_SESSION['id'];

                                // Fetch the classes created by the teacher from the database
                                $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id'");
                                $result = mysqli_num_rows($query);

                                // Loop through the classes and create an option for each class
                                for ($i = 0; $i < $result; $i++) {
                                    $class = mysqli_fetch_assoc($query);
                                    echo '<option value="' . $class['subject'] . '">' . $class['subject'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field">
                            <input type="submit" name="submit" class="btn" value="Upload">
                            <input type="button" class="btn" name="submit" value="Back" onclick="window.history.back()">
                        </div>
                    </form>
    </div>

</body>
</html>
