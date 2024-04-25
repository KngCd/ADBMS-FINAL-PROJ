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
                  $id = $_SESSION['id'];
      
                  // Fetch the classes created by the teacher from the database
                  $query = mysqli_query($con, "SELECT subject FROM class WHERE teacher_id = '$id'");
                  $subject = $_POST['subject'];
                  $classcode = $_POST['classcode'];

                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $subject . '</a>';
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
      <button onclick="location.href='Tedit.php'">
            <i class="fa-solid fa-user"></i>
        </button>
      </div>
    </div>

<div class="main-body">
    <div class="body-section2" id="main">
    <?php
// Include the database configuration file
require_once 'config.php';

// Get document data from database
$id = $_SESSION['id'];
$subject = isset($_POST['subject']) ? mysqli_real_escape_string($con, $_POST['subject']) : '';
$classcode = isset($_POST['classcode']) ? mysqli_real_escape_string($con, $_POST['classcode']) : '';

// Query the modules table
$module_result = mysqli_query($con, "SELECT * FROM modules WHERE classcode = '$classcode' AND teacher_id = '$id' ORDER BY uploaded DESC");

// Query the announcements table
$announcement_result = mysqli_query($con, "SELECT * FROM announcement WHERE classcode = '$classcode' AND teacher_id = '$id' ORDER BY uploaded DESC");

// Display documents with BLOB data from database
if ($module_result->num_rows > 0 || $announcement_result->num_rows > 0) {
    // Initialize an array to store the results
    $results = array();

    // Add the modules to the results array
    if ($module_result->num_rows > 0) {
        while ($row = $module_result->fetch_assoc()) {
            $row['type'] = 'module';
            $results[] = $row;
        }
    }

    // Add the announcements to the results array
    if ($announcement_result->num_rows > 0) {
        while ($row = $announcement_result->fetch_assoc()) {
            $row['type'] = 'announcement';
            $results[] = $row;
        }
    }

    // Sort the results array by the uploaded column
    usort($results, function($a, $b) {
        return strtotime($b['uploaded']) - strtotime($a['uploaded']);
    });

    // Display the results
    foreach ($results as $row) {
        if ($row['type'] === 'module') {
            if ($row['filetype'] === 'pdf') {
                // Display PDF document
                echo '<div class="module-card">';
                echo '<i class="fa-solid fa-book-bookmark"></i>';
                echo '  <div class="module-name"> Module Name: '. $row['module_name'] . '</div>';
                echo '  <div class="module-description"> Description: '. $row['description'] . '</div>';
                echo '  <a href="#" class="view-pdf-link" onclick="viewPDF(\''. base64_encode($row['module']). '\', \''. $row['module_name'].'.pdf\')">View Learning Material</a>';
                echo '</div>';
            } elseif ($row['filetype'] === 'pptx' || $row['filetype'] === 'txt' || $row['filetype'] === 'xlsx' || $row['filetype'] === 'docx' || $row['filetype'] === 'doc') {
                // Display a download link for the file if neither PDF nor text is uploaded
                echo '<div class="module-card">';
                echo '<i class="fa-solid fa-book-bookmark"></i>';
                echo '  <div class="module-name"> Module Name: ' . $row['module_name'] . '</div>';
                echo '  <div class="module-description"> Description: ' . $row['description'] .  '</div>';
                echo '  <a class="view-pdf-link"  href="data:application/octet-stream;base64,'. base64_encode($row['module']) .'" download="'. $row['module_name'] .'.'. $row['filetype'] .'">Download Learning Material</a>';
                echo '</div>';
            }
        } elseif ($row['type'] === 'announcement') {
            // Display announcement
            echo '<div class="module-card">';
            echo '<i class="fa-solid fa-bullhorn"></i>';
            echo '  <div class="module-name"> Title: ' . $row['title'] .  '</div>';
            echo '  <div class="module-description"> Description: ' . $row['description'] . '</div>';
            echo '  <div class="module-description">' . date('F j, Y', strtotime($row['uploaded'])) . '</div>';
            echo '</div>';
        }
    }
} else {
    echo '<p class="status error" style="color: #aaa;">No posts yet!</p>';
}
?>

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

</body>
</html>

<?php
/*
        // Include the database configuration file
        require_once 'config.php';

        // Get document data from database
        $id = $_SESSION['id'];
        $subject = isset($_POST['subject']) ? mysqli_real_escape_string($con, $_POST['subject']) : '';
        $classcode = isset($_POST['classcode']) ? mysqli_real_escape_string($con, $_POST['classcode']) : '';

        // Query the modules table
        $module_result = mysqli_query($con, "SELECT * FROM modules WHERE classcode = '$classcode' AND teacher_id = '$id' ORDER BY uploaded DESC");

        // Query the announcements table
        $announcement_result = mysqli_query($con, "SELECT * FROM announcement WHERE classcode = '$classcode' AND teacher_id = '$id' ORDER BY uploaded DESC");

        // Display documents with BLOB data from database
        if ($module_result->num_rows > 0 || $announcement_result->num_rows > 0) {
            // Display modules
            if ($module_result->num_rows > 0) {
                while ($row = $module_result->fetch_assoc()) {
                    if ($row['filetype'] === 'pdf') {
                        // Display PDF document
                        echo '<div class="module-card">';
                        echo '<i class="fa-solid fa-book-bookmark"></i>';
                        echo '  <div class="module-name"> Module Name: '. $row['module_name'] . '</div>';
                        echo '  <div class="module-description"> Description: '. $row['description'] . '</div>';
                        echo '  <a href="#" class="view-pdf-link" onclick="viewPDF(\''. base64_encode($row['module']). '\', \''. $row['module_name'].'.pdf\')">View Learning Material</a>';
                        echo '</div>';
                    } 
                    elseif ($row['filetype'] === 'pptx' || $row['filetype'] === 'txt' || $row['filetype'] === 'xlsx' || $row['filetype'] === 'docx' || $row['filetype'] === 'doc') {
                        // Display a download link for the file if neither PDF nor text is uploaded
                        echo '<div class="module-card">';
                        echo '<i class="fa-solid fa-book-bookmark"></i>';
                        echo '  <div class="module-name"> Module Name: ' . $row['module_name'] . '</div>';
                        echo '  <div class="module-description"> Description: ' . $row['description'] .  '</div>';
                        echo '  <a class="view-pdf-link"  href="data:application/octet-stream;base64,'. base64_encode($row['module']) .'" download="'. $row['module_name'] .'.'. $row['filetype'] .'">Download Learning Material</a>';
                        echo '</div>';
                    }
                }
            }

            // Display announcements
            if ($announcement_result->num_rows > 0) {
                while ($row = $announcement_result->fetch_assoc()) {
                    echo '<div class="module-card">';
                    echo '<i class="fa-solid fa-bullhorn"></i>';
                    echo '  <div class="module-name"> Title: ' . $row['title'] .  '</div>';
                    echo '  <div class="module-description"> Description: ' . $row['description'] . '</div>';
                    echo '  <div class="module-description">' . date('F j, Y', strtotime($row['uploaded'])) . '</div>';
                    echo '</div>';
                }
            }
        } else {
            echo '<p class="status error" style="color: #aaa;">No posts yet!</p>';
        }


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

  // Open a new tab and display the PDF
  const newTab = window.open('', '_blank');
  newTab.document.title = filename;
  newTab.document.body.innerHTML = '<embed src="' + url + '" type="application/pdf" width="100%" height="100%">';
}*/
?>