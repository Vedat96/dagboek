<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title>Home</title>
</head>
<body>
	<header>
		<div class="navbar">
			<ul>
				<li><img src="images/dagboek.jpg" id="dagboek"></li>
				<li><H1> Mijn Dagboek</H1></li>
			</ul> 
			<!-- log in form -->
			<div class="forma">
				<h3>Log in</h3>
				<form action="forms/loginverwerk.php" method="POST">
					Email:
					<input type="text" name="email" value="" placeholder="Email">
					Wachtwoord:
					<input type="password" name="wachtwoord" value="" placeholder="Wachtwoord">
					<input type="submit" value="Aanmelden">
					
				</form> 
			</div>
		</div>
	</header>
<!-- register form -->
	<div class="formb">
		<h3>Registreer</h3>
		<form action="forms/registerverwerk.php" method="POST">
			<?php
			// de errors worden hier getoond
			if (isset($_SESSION['error_register'])) {
				echo '<p style="color:red;">' . $_SESSION['error_register'] . '</p>';
			}
			?>
			Voornaam:<br>
			<input type="text" name="voornaam" placeholder="Voornaam">	<br>
			Tussenvoegsel:<br>
			<input type="text" name="tussenvoegsel"  placeholder="Tussenvoegsel"><br>
			Achtenaam:<br>
			<input type="text" name="achternaam"  placeholder="Achtenaam"><br>
			Email:<br>
			<input type="text" name="email"  placeholder="Email"><br>
			Wachtwoord:<br>
			<input type="password" name="wachtwoord"  placeholder="Wachtwoord"><br>
			<input type="submit"  name="registreren" value="Registreren">
		</form> 
	</div>


</body>
</html>
<?php
// bij refresh zijn de errors weg
if (isset($_SESSION['error_register'])) {
	unset($_SESSION['error_register']);
}
?>