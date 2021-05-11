<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	//include de file
	require'../src/users.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['wachtwoord'])) {

		// functie voor validatie
		function test_input($data) {
		    $data = trim($data);
		    $data = stripslashes($data);
		    $data = htmlspecialchars($data);
		    return $data;
		}

		$email = test_input($_POST['email']);
		$wwoord = test_input($_POST['wachtwoord']);
		// leeg variabele
		$error = '';

		if (empty($email)) {
			$error = $error . 'Email is verplicht.<br>';	
		}
		if (empty($wwoord)) {
			$error = $error . 'Wachtwoord is verplicht.<br>';	
		}
		if (empty($error)) {
			$user=new Users();
			$email= $_POST['email'];
			$wachtwoord= $_POST['wachtwoord'];
			$login=$user->login($_POST['email'],$_POST['wachtwoord']);

			header('Location: ../views/welcome.php');
		// geeft error
		} 
		// if (!empty($email) && !empty($wwoord) && !empty($error)) {
		// 	$error = $error . 'Email of Wachtwoord onjuist.<br>';
		// }

		else {
			$_SESSION['error_register'] = $error;
			header('Location: ../views/relog.php');
		}
		// elseif(empty($error)){
		// 	echo("<script>alert('Geen geldig account!')</script>");
		// 	echo("<script>window.location = '../relog.php';</script>");
		
		// }

		
		// elseif ($_SERVER['REQUEST_URI'] === '../relog.php') {
		    
		//  // echo("<script>alert('Account bestaat niet')</script>");
		//  // echo("<script>window.location = 'home.php';</script>");
		// }
	} else {
		header('Location: ../views/index.php');
	}

	// echo '<br>gebruiker '.$_SESSION['id_gebruiker'];
	// if('email == :email'){
	// 	header('Location: ../welcome.php');
	// }
	// else{
	// 	return;
	// 	echo 'try again'
	// }

	// else{
	// 	echo "Wachtwoord niet correct";
	// 	echo password_hash("wachtwoord", PASSWORD_DEFAULT);
	// }
?>