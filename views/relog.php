<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title>Home</title>
</head>
<body>
	<?php include 'partials/menu.php'; ?>

	<div class="container" style="text-align: right; position: absolute; display: block; margin: auto;">
	<h1>Probeer het opnieuw</h1>
</div>
	<!-- log in form -->
	<div class="formc">
		<h2>Log in</h2>
		<form action="../forms/loginverwerk.php" method="POST">
			Email:
			<input type="text" name="email" value="" placeholder="Email">
			Wachtwoord:
			<input type="password" name="wachtwoord" value="" placeholder="Wachtwoord">
			<input type="submit" value="Aanmelden">
			<?php
			// geeft de errors hier aan
			if (isset($_SESSION['error_register'])) {
				echo '<p style="color:red;">' . $_SESSION['error_register'] . '</p>';
			}
			?>
		</form> 
	</div>
</body>
</html>
<?php
// bij refresh worden de error niet meer getoond
if (isset($_SESSION['error_register'])) {
	unset($_SESSION['error_register']);
}
?>