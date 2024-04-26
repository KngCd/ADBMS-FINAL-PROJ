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
            <a class="link" href="#"><i class="fa-solid fa-house"></i>Home</a>
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
      
                  // Fetch the classes joined by the student from the database
                  $query = mysqli_query($con, "SELECT subject FROM class_student cs JOIN class c ON cs.classcode = c.classcode WHERE student_id = '$id'");
                  $result = mysqli_num_rows($query);

                  // Loop through the classes and create a link for each class
                  for ($i = 0; $i < $result; $i++) {
                    $class = mysqli_fetch_assoc($query);
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $class['subject'] . '</a>';
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
                  $query = mysqli_query($con, "SELECT c.classcode, cs.classcode, cs.student_id, ac.act_id, ac.activity, ac.topic, ac.description, ac.points,
                  ac.due_date, ac.time, ac.filetype, ac.uploaded, ac.classcode, ac.teacher_id FROM class_student cs JOIN class c ON cs.classcode = c.classcode
                  JOIN activity ac ON c.classcode = ac.classcode WHERE cs.student_id = '$id'");
                  $result = mysqli_num_rows($query);

                  // Loop through the classes and create a link for each class
                  for ($i = 0; $i < $result; $i++) {
                    $class = mysqli_fetch_assoc($query);
                    echo '<a class="link2" href="#"><i class="fa fa-circle fa-fw"></i>' . $class['topic'] . ' / '.  $class['due_date'] . '</a>';
                  }
                  ?>
                </div>
            <a class="link" href="#"><i class="fa-solid fa-gear"></i>Settings</a><br><br><br><br>
            <a class="link" href="LoginSignup.php"><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</a>
          </div>

          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
          <i id="school-icon" class="fa-solid fa-book-open"></i>
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
      </div>
    </div>

    <div class="container2" id="main">
  <?php
    $id = $_SESSION['id'];

    // Fetch the teacher and the classes that the student joins
    $query = mysqli_query($con, "SELECT t.Username, c.subject, cs.classcode FROM class_student cs JOIN class c ON cs.classcode = c.classcode JOIN teachers t ON c.teacher_id = t.Id WHERE cs.student_id = '$id'");

    // Iterate through the results and display a card for each class
    while ($row = mysqli_fetch_assoc($query)) {
  ?>
      <div class="card">
      <div class="color"></div>
        <div class="container" data-color="">
        <input type="submit" class="btn" data-classcode="<?php echo $row['classcode']; ?>" value="Unenroll">
          <p><?php echo $row['Username']; ?></p><br>
          <h4><b><?php echo $row['subject']; ?></b></h4> 
          <form action="student-stream.php" method="post" class="form" id="class-stream-form-<?php echo $row['classcode']; ?>">
              <input type="hidden" name="subject" value="<?php echo $row['subject']; ?>">
              <input type="hidden" name="classcode" value="<?php echo $row['classcode']; ?>">
              <a href="#" class="submit-button" data-form-id="class-stream-form-<?php echo $row['classcode']; ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </form>
            <script>
            $(document).ready(function() {
              $('.submit-button').click(function(e) {
                e.preventDefault();

                var formId = $(this).data('form-id');
                $('#' + formId).submit();

                // Redirect to the next page
                setTimeout(function() {
                  window.location.href = "student-stream.php";
                }, 100);
              });
            });
              </script>
        </div>
      </div>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const colorDivs = document.querySelectorAll('.color');
              const containerDivs = document.querySelectorAll('.container');

              containerDivs.forEach((container, index) => {
                  let randomColor;
                  do {
                      randomColor = Math.floor(Math.random()*16777215).toString(16);
                  } while (randomColor === 'ffffff');

                  container.dataset.color = `#${randomColor}`;
                  colorDivs[index].style.backgroundColor = `#${randomColor}`;
                  localStorage.setItem('color' + index, `#${randomColor}`);
              });

              containerDivs.forEach((container, index) => {
                  const storedColor = localStorage.getItem('color' + index);
                  if (storedColor) {
                      container.dataset.color = storedColor;
                      colorDivs[index].style.backgroundColor = storedColor;
                  }
              });
          });
      </script>
      <script>
          $(document).ready(function() {
            $('.btn').off('click').click(function(e) {
              e.preventDefault();
              var classcode = $(this).data('classcode');
              var id = <?php echo $id; ?>;

              $.ajax({
                type: 'POST',
                url: 'delete_subject.php',
                data: { classcode: classcode, id: id },
                dataType: 'json',
                success: function(response) {
                  // Display the success message
                  alert(response.success);
                  location.reload();
                }
              });
            });
            });
        </script>
  <?php
    }
  ?>

</div>

</body>
</html>
