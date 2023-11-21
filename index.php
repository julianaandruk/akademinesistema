<?php
session_start();
 
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
	header("location: views/dashboard.php");
} else {
	header("location: views/login.php");
}

exit;
?>