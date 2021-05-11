<?php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
if (isset($_SESSION['id_gebruiker'])) {

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addStoryName'])) {
		$naam = test_input($_POST["addStoryName"]);

		require '../src/diaries.php';
		
		$diary = new Diaries();
		$create = $diary->addDiary($naam, $_SESSION['id_gebruiker']);
		if ($create == true) {
			header('Location: ../views/diary.php');

		} else {
			echo "nope";
		}
	} else {
		header('Location: ../views/index.php');
	}



} else {
	header("Location: ../views/error/error.php");

}
?>