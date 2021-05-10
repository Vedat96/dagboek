<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include users.php
require 'src/users.php';
// als er sessie is voert hij de pagina uit anders stuurt hij hem weg
if (isset($_SESSION['id_gebruiker'])) {
// nieuw object
$user = new Users();
?>
<!DOCTYPE html>
<html>
<head>
<!-- 	 include css -->
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
			<form action="forms/logout.php" method="POST">
				<input type="submit" value="Log uit" name="loguit">
			</form>
		</div>
	</header>
	<div class="nav">
	<ul>
		<li><H3><a href="diary.php">Dagboeken</a></H3></li>
		<li><H3><a href="account.php">Mijn account</a></H3></li>
	</ul> 
	</div>
	<div class="container">
		<table class="Gegevens">
			<form action="forms/bewerk-account.php" method="POST">
				<?php
				//als er een error is geeft hij het hier aan
	 			if (isset($_SESSION['error_register'])) {
	 				echo '<p style="color:red;">' . $_SESSION['error_register'] . '</p>';
	  			}
	 			?>
				<th>Voornaam</th>
				<th>Tussenvoegsel</th>
				<th>Achternaam</th>
				<th>Email</th>
				<th>Wachtwoord</th>
				<th></th>

				<?php
					$user->displayUserEditForm($_SESSION['id_gebruiker']);
				?>
			</tbody>
		</table>
		</div>
		<form action="forms/verwijder-account.php" method="post">
			<input type="submit" class="DeleteAccount" value="Verwijder account" name="DeleteAccount">
		</form>
	</div>
</body>
<?php
} else {
	// als er geen sessie is wordt je naar error.php gestuurd
	header("Location:error.php");
}?>

</html>
<?php 
// als de pagina gerefresht wordt zie je de errors niet meer
if (isset($_SESSION['error_register'])) {
	unset($_SESSION['error_register']);
}
?>