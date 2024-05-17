<?php
// Get the file from the database
include ('config.php');
$file = $_GET['file'];
$id = $_SESSION['id'];
$module_name = $_GET['module_name'];
$filetype = $_GET['filetype'];

// Assuming you have a database connection established
$query = "SELECT * FROM modules WHERE module = '$file'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

// Get the file data
$file_data = $row['module'];

// Set the headers for the download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'. $module_name. '.'. $filetype. '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Output the file data to the browser
echo $file_data;

exit;
?>