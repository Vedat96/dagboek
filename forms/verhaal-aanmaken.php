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
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addStory'])) {
		$post = test_input($_POST["addStory"]);

		require '../src/diaries.php';
		// nieuw object, maakt nieuw verhaal
		$story = new Diaries();
		$create = $story->addStory($post, $_SESSION['id_dagboek']);
		if ($create == true) {
			header('Location: ../story.php');

		} else {
			echo "nope";
		}
	} else {
		header('Location: ../index.php');
	}
} else {
	header("Location: ../error.php");
}
?>