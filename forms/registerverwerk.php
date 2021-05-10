<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	// session_start();
	require'../src/users.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['voornaam'], $_POST['tussenvoegsel'], $_POST['achternaam'], $_POST['email'], $_POST['wachtwoord'])) {
		// start validatie functie
		function test_input($data) {
		    $data = trim($data);
		    $data = stripslashes($data);
		    $data = htmlspecialchars($data);
		    return $data;
		}
		// maakt variabeles
		$vnaam = test_input($_POST['voornaam']);
		$tnaam = test_input($_POST['tussenvoegsel']);
		$anaam = test_input($_POST['achternaam']);
		$email = test_input($_POST['email']);
		$wwoord = test_input($_POST['wachtwoord']);
		// lege variable voor de error, zodat er wat in kan en later als het leeg is wat mee kan
		$error = '';
		// validatie met de errors
		if (empty($vnaam)) {
			$error = $error . 'Voornaam is verplicht.<br>';
		}
		elseif (!preg_match("/^[a-zA-Z ]*$/",$vnaam)) {
	    	$error = $error . 'Alleen letters en spaties zijn toegestaan (voornaam) <br>';
	    }
		if (!preg_match("/^[a-zA-Z ]*$/",$tnaam)) {
	    	$error = $error . 'Alleen letters en spaties zijn toegestaan (tussenvoegsel) <br>';
	    }
		if (empty($anaam)) {
			$error = $error . 'Achternaam is verplicht.<br>';
		}
		elseif (!preg_match("/^[a-zA-Z ]*$/",$anaam)) {
	    	$error = $error . 'Alleen letters en spaties zijn toegestaan (achternaam) <br>';
	    }
		if (empty($email)) {
			$error = $error . 'Email is verplicht.<br>';	
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = $error . 'Email is niet correct <br>';
		}

		if (empty($wwoord)) {
			$error = $error . 'Wachtwoord is verplicht.<br>';	
		}
		elseif (strlen($_POST["wachtwoord"]) <= '3') {
	        $error = $error . 'Je wachtwoord moet minstens 4 karakters hebben! ';
	    }
	    // als er geen errors zijn maakt hij een nieuw account aan
		if (empty($error)) {
			$user=new Users();
			$voornaam= test_input($vnaam);
			$tussenvoegsel= test_input($tnaam);
			$achternaam= test_input($anaam);
			$email= test_input($email);
			$wachtwoord= test_input($wwoord);
			$create = $user->register($voornaam, $tussenvoegsel,$achternaam,$email,$wachtwoord);
			if (is_numeric($create)){
				$_SESSION['id_gebruiker'] = $create;
				header('Location: ../welcome.php');
			} else {
				echo "mislukt";
			}
		// geeft errors 
		} else {
			$_SESSION['error_register'] = $error;
			header('Location: ../');
		}
	} else {
		header('Location: ../');
	}


?>