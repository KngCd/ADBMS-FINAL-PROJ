<?php
    session_start();
    require_once 'config.php';

    $id = $_SESSION['id'];
    $act_id = $_POST['act_id'];
    $classcode = $_POST['classcode'];

    // Find the marks_id of the row containing the act_id, student_id and classcode
    /*$query = mysqli_query($con,"SELECT marks_id FROM activitylog WHERE student_id = $id AND activity_id = $act_id AND classcode = '$classcode'");
    $row = mysqli_fetch_assoc($query);
    $marks_id = $row['marks_id'];*/

    // Delete the activity from the activitylog table
    $delete_al = "DELETE FROM activitylog WHERE student_id = $id AND activity_id = $act_id AND classcode = '$classcode'";
    mysqli_query($con, $delete_al);

    // Delete the grade from the activitygrade table
    $delete_ag = "DELETE FROM activitygrade WHERE act_id = $act_id AND student_id = $id";
    mysqli_query($con, $delete_ag);

    echo "<script>alert('Activity Unsubmitted successfully!'); window.location.href = 'SHome.php';</script>";
?>