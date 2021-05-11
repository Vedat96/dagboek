<?php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require '../src/diaries.php';

	if (isset($_SESSION['id_gebruiker'])) {

		// nieuw object
		$story = new Diaries();
		// als de id bestaat en niet leeg is laat hij de dagboeken zien
		if (isset($_POST['id']) && !empty($_POST['id'])) {
			// maakt sessie
			$_SESSION['id_dagboek'] = $_POST['id'];
			$id_dagboek = $_SESSION['id_dagboek'];
		} elseif (!isset($_POST['id']) && isset($_SESSION['id_dagboek'])) {
			$id_dagboek = $_SESSION['id_dagboek'];
		}
		$id_dagboek = $_SESSION['id_dagboek'];
		//laat de stories zien
		$storydata = $story->showStory($id_dagboek);  
	// $storydata = $story->showStory($_SESSION['posts.id_post'], $_POST['post'], date('YY-mm-dd'));

	} else {
	header("Location: ../views/error/error.php");

}
?>