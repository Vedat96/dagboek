<?php 
//sessie wordt onderbroken

	session_start();
	session_destroy();
	header("location:../index.php");

?>