<?php 
    require_once('config.php');
    session_start();
    $student_id = $_SESSION['id'];
    if($_SERVER['REQUEST_METHOD'] !='POST'){
        echo "<script> alert('Error: No data to save.'); window.location.href='calendar_s.php';</script>";
        $con->close();
        exit;
    }

    extract($_POST);
    $allday = isset($allday);

    if(empty($id)){
        $sql = "INSERT INTO tbl_events2 (`title`,`description`,`start_datetime`,`end_datetime`, student_id) VALUES ('$title','$description','$start_datetime','$end_datetime', $student_id)";
    }else{
        $sql = "UPDATE tbl_events2 set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";

    }

    $save = $con->query($sql);

    if($save){
        echo "<script> alert('Schedule Successfully Saved.'); window.location.href='calendar_s.php';</script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$con->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
    
    $con->close();
?>