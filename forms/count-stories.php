<?php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require '../src/diaries.php';
if (isset($_SESSION['id_gebruiker'])) {

	// $story = new Diaries();
	// $storydata = $story->showStory($id_dagboek);  

	$cars=array('SELECT COUNT(id_post) AS NumberOfProducts FROM posts WHERE id_dagboek = :id_dagboek');
	echo count($cars);

} else {
	header("Location: ../views/error/error.php");

}
?>