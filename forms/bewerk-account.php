<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// include een ander file
	require '../src/users.php';
if (isset($_SESSION['id_gebruiker'])) {


	// als er iets word gepost en het bestaat gaat het wat doen
	 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Wijzigen'])){


		function test_input($data) {
		    $data = trim($data);
		    $data = stripslashes($data);
		    $data = htmlspecialchars($data);
		    return $data;
		}

		$vnaam = test_input($_POST['voornaam']);
		$tnaam = test_input($_POST['tussenvoegsel']);
		$anaam = test_input($_POST['achternaam']);
		$email = test_input($_POST['email']);
		$wwoord = test_input($_POST['wachtwoord']);

		// een lege variabele, zodat je wat in kan zetten
		$error = '';
		// validatie: als iets leegs is en niet match met de regex geeft het een error
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
	    // als er geen error is dan worden de gegevens gewijzigd, met de functie edit
		if (empty($error)) {

			$user = new Users();
			$editdata = $user->edit($_SESSION['id_gebruiker'], $_POST['voornaam'], $_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['email'],$_POST['wachtwoord']);
			// als de gegevns zijn gewijzigd wordt het doorgestuurd
			if ($editdata === true) {
				header('Location: ../account.php');
				echo 'gegevens zijn gewijzigd';
			} else {
				echo 'Het wijzigen van uw gegevens is mislukt.';
			}
			// als er errors zijm worden die getoont
		} else {
			$_SESSION['error_register'] = $error;
			header('Location: ../account.php');
		}

	} else {
		echo "nope";
	}
} else {
	header("Location: ../error.php");

}
?>