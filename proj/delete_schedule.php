<?php 
    require_once('config.php');
    session_start();
    $teacher_id = $_SESSION['id'];

    if(!isset($_GET['id'])){
        echo "<script> alert('Undefined Schedule ID.'); location.replace('./') </script>";
        $con->close();
        exit;
    }

    $delete = $con->query("DELETE FROM tbl_events where id = '{$_GET['id']}'");

    if($delete){
        echo "<script> alert('Event has deleted successfully.'); window.location.href='calendar.php'; </script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$con->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
    
    $con->close();
?>