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
		</div>
	</header>
	<div style="margin: 20px;">
		<h2>U bent niet ingelogd. Log in om door te gaan of registreer als u geen account heeft.</h2>
		<h3><a href="index.php">Klik hier om terug te gaan</a></h3>
	</div>
</body>
</html>