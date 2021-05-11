<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	require '../src/diaries.php';
if (isset($_SESSION['id_gebruiker'])) {

	$diary = new Diaries();
	$diarydata = $diary->showDiary($_SESSION['id_gebruiker']);  

	// $postData = $diary->showStory();

// $diary = $getDiary->fetchAll();
// foreach ($diaries as $diary) {
//     echo $diary['naam'] . '<br />';
// }

} else {
	header("Location: ../views/error/error.php");

}
?>