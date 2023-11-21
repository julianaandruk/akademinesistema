<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
	header("location: login.php");
	exit;
}

require("../core/user.php");
$user = new User($_SESSION["uid"]);
$profile = $user->get();

if ($profile["role"] == 1) {
	header("location: admin/groups.php");
	exit();
} else if ($profile["role"] == 2) {
	header("location: teacher/groups.php");
	exit();
} else {
	header("location: student/summary.php");
	exit();
}
?>