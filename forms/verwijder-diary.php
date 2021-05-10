<?php
	// $user = new Users();
	// $deleteDD = $_POST('Verwijderen');
	// $deletedata = $user->deleteDiary($deleteDD, $_SESSION['id_dagboek']);
	// if ($deletedata === true) {
	// 	header('Location: ../bye.php');
	// } else {
	// 	echo 'Het verwijderen van uw verhaal is mislukt.';
	// }
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();

	require '../src/diaries.php';


if (isset($_SESSION['id_gebruiker'])) {

	$deleteDD = new Diaries();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    //something posted

	    if (isset($_POST['deleteDiary'])) {
	    	// verwijdert alleen de diary
	    	$deletedata = $deleteDD->delete($_POST['id']); //MOET POST ZIJN
	        header('Location: ../diary.php');
	        
	    } else {
	        echo 'niet gelukt';
	    }
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
} else {
	header("Location: ../error.php");
}
?>