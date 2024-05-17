<?php
session_start();
require_once 'config.php';

$id = $_POST['id'];
$classcode = $_POST['classcode'];

// Disable foreign key constraint
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0;");

// Select the class code from the class table
$query = mysqli_query($con, "SELECT classcode FROM class WHERE classcode = '$classcode'");
$row = mysqli_fetch_assoc($query);
$classcode = $row['classcode']; 

// Delete associated records in the class_student table
$deleteClassStudentQuery = "DELETE FROM class_student WHERE student_id = '$id' AND classcode = '$classcode'";
mysqli_query($con, $deleteClassStudentQuery);

// Re-enable foreign key constraint
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1;");

// Return the success message as a JSON object
$response = array('success' => 'Subject deleted successfully');
echo json_encode($response);
?>