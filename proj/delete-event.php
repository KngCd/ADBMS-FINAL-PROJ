<?php
require_once "config.php";

$id = $_POST['id'];
$sqlDelete = "DELETE from tbl_events WHERE id=".$id;

mysqli_query($con, $sqlDelete);
echo mysqli_affected_rows($con);

mysqli_close($con);
?>