<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
require 'src/users.php';

if (isset($_SESSION['id_gebruiker'])) {
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
			<form action="forms/logout.php" method="POST">
				<input type="submit" value="Log uit" name="loguit">
			</form>
		</div>
	</header>
	<div class="nav">
	<ul>
		<li><H3><a href="diary.php">Dagboeken</a></H3></li>
		<li></H4><a href="account.php"> Mijn account</a></H4></li>
	</ul> 
	</div>
	<h1 style="padding-left: 500px;">WELCOME</style></h1>
</body>
<?php
} else {
	header("Location: relog.php");
}
?>
</html>