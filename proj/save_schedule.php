<?php 
    require_once('config.php');
    session_start();
    $teacher_id = $_SESSION['id'];
    if($_SERVER['REQUEST_METHOD'] !='POST'){
        echo "<script> alert('Error: No data to save.'); window.location.href='calendar.php';</script>";
        $con->close();
        exit;
    }

    extract($_POST);
    $allday = isset($allday);

    if(empty($id)){
        $sql = "INSERT INTO tbl_events (`title`,`description`,`start_datetime`,`end_datetime`, teacher_id) VALUES ('$title','$description','$start_datetime','$end_datetime', $teacher_id)";
    }else{
        $sql = "UPDATE tbl_events set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";

    }

    $save = $con->query($sql);

    if($save){
        echo "<script> alert('Schedule Successfully Saved.'); window.location.href='calendar.php';</script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$con->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
    
    $con->close();
?>