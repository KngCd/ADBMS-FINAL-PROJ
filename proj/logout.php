<?php
session_start();

include ('config.php');

// Insert the logout timestamp
$logout_timestamp = date('Y-m-d H:i:s');
$user_id = $_SESSION['id'];
$query = "INSERT INTO logout_log (user_id, logout_time) VALUES (?, NOW())";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Clear the session variables and redirect to the login page
session_unset();
session_destroy();
header("Location: LoginSignup.php");
exit();
?>