<?php
require("config.php");

$result = mysqli_query($con, "SELECT * FROM logs ORDER BY id ASC");
while($row=mysqli_fetch_array($result)){
	
	echo "<span class='uname'><b>" . $row['username'] . "</b></span>: <span class='msg'>" . $row['msg'] . "</span></br></br>";
}
mysqli_close($con);
?>