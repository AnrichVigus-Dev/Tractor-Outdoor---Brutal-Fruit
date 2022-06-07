<?php
//exit();
if ((!isset($_SESSION['verified'])) || (time() - $_SESSION['login_time'] > 440000000)) {
	header("Location: adminlogin.php?verified=false");
}
?>
