<?php
//session_start();
if(!isset($_SESSION['admin'])) {
	header("location:index.php?error=nologin");
	exit;
}
?>