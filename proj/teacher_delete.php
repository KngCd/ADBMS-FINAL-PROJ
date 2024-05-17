<?php
session_start();
require_once 'config.php';

$id = $_POST['id'];
$classcode = $_POST['classcode'];

// Select the class code from the class table
$query = mysqli_query($con, "SELECT classcode FROM class WHERE classcode = '$classcode' AND teacher_id = '$id'");
$row = mysqli_fetch_assoc($query);
$classcode = $row['classcode'];

// Delete the subject from the class_student table
mysqli_query($con, "DELETE FROM class WHERE classcode = '$classcode'");

// Return the success message as a JSON object
$response = array('success' => 'Subject deleted successfully');
echo json_encode($response);
?>