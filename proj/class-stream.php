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
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a class="link" href="#"><i class="fa-solid fa-house"></i>Home</a>
            <a class="link" href="#"><i class="fa-solid fa-calendar"></i>Calendar</a>
            <button class="dropdown-btn">
              <i class="fa-solid fa-graduation-cap"></i>
              <span>Class<i class="fa fa-caret-down"></i></span>
            </button>
            <div class="dropdown-container">
            <?php 
                  session_start();
                  include('config.php');
                  $id = $_SESSION['id'];
      
                  // Fetch the classes created by the teacher from the database
                  $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id'");
                  $subject = $_POST['subject'];
                  $classcode = $_POST['classcode'];

                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $subject . '</a>';
                  ?>
                </div>
            <a class="link-todo" href="#"><i class="fa-solid fa-list-check"></i>To-Do</a>
            <a class="link" href="#"><i class="fa-solid fa-gear"></i>Settings</a>
          </div>

          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
          <i  id="school-icon" class="fa-solid fa-book-open"></i>
          <a class="tm" href="THome.php"><p>Task Mastery</p> </a> <i class="fa-solid fa-greater-than"></i>
          <?php
        $subject = isset($_POST['subject']) ? mysqli_real_escape_string($con, $_POST['subject']) : '';
        $classcode = isset($_POST['classcode']) ? mysqli_real_escape_string($con, $_POST['classcode']) : '';


              echo  "<div class='sub'>" . $subject ."</div>";
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
            <i class="fa-solid fa-user"></i>
      </div>
    </div>


    <div class="body-section" id="main">
    <?php
        include('config.php');
        $id = $_SESSION['id'];

        // Retrieve the classcode from the POST request
        $subject = isset($_POST['subject']) ? mysqli_real_escape_string($con, $_POST['subject']) : '';
        $classcode = isset($_POST['classcode']) ? mysqli_real_escape_string($con, $_POST['classcode']) : '';

        if (isset($_POST['create'])) {
          $m_name = mysqli_real_escape_string($con, $_POST['m_name']);
          $module = $_FILES['module']['tmp_name'];
          
              // Retrieve the Id of the class using the classcode value
              $query = "SELECT Id FROM class WHERE subject = '$subject'  AND classcode = '$classcode'";
              $classid_result = mysqli_query($con, $query);

                  // Fetch the Id from the result resource
                  $classid = mysqli_fetch_assoc($classid_result)['Id'];

                  // Check if the classid is not null
                  if ($classid) {
                      // Use the retrieved class_id in the SQL query
                      $sql = "INSERT INTO modules (module_name, module, class_id, teacher_id) VALUES ('$m_name', '$module', '$classid', '$id')";
                      $result = mysqli_query($con, $sql);

                      if ($result) {
                          $_SESSION['success'] = "Uploading Successful!";
                          header('Location: ' . $_SERVER['PHP_SELF']);
                          exit;
                      }
                  } else {
                      // Handle the error
                      echo "Error: Class not found.";
                  }
        }
      ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
        <input type="hidden" name="classcode" value="<?php echo htmlspecialchars($classcode); ?>">
            <div class="input-wrapper">
                <input type='text' id='input' name="m_name" autocomplete="off" required >
                <label for='input' class='placeholder'>Module Name</label>
            </div>
            <label for="input">Select a File for the Module:</label>
            <input type='file' id='input' name="module" autocomplete="off" required>

            <div class="input-container">
                <input type="submit" class="btn-2" name="create" value="Create">
                <i class="fa-solid fa-plus"></i>
            </div>
        </form>

    </div>

    <script>
          $(document).ready(function() {
            $('#input').change(function() {
              $('#message').text('Your file has been chosen for upload!');
            });
          });
            function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
            }

            function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
            }

    </script>
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
    } ?>
</body>
</html>
