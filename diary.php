<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
require 'forms/diarydata.php';
// als er sessie is voert hij de pagina uit anders stuurt hij hem weg
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
			<li><H3><a href="account.php">Mijn account</a></H3></li>
		</ul> 
	</div>
	<div class="container">
		<form action="forms/dagboek-aanmaken.php" class= "addbutton" method="POST">
			Voeg een dagboek toe
			<!-- button om een nieuw verhaal toe te voegen -->
			<input type="text" value="" required name="addStoryName">
			<button> Opslaan</button>
		</form>
		<hr>
		<table class="diary">
			<thead>
				<th>Aantal verhalen</th> 
				<th>Dagboeken</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				// $var = 0;
				// foreach ($diarydata as $value) {
				// 	$var = $var + 1;
				// }
					 // $var = count($diarydata);

				// als diarydata bestaat, dus de dagboeken dan laat hij ze zien in de tabel
					if($diarydata != false){
						foreach ($diarydata as $value) {
							echo '<tr>
									<form action="story.php" method="post"> 
										<td>'.$diary->countStories($value['id_dagboek']).'</td>
										<td><input type="submit" value="'.$value['naam'].'"></td>
										<input type="hidden" name="id" value="'.$value['id_dagboek'].'">	
									</form>
									<form action= "forms/verwijder-diary.php" method="post">
										<td><input type="hidden" name="id" value="'.$value['id_dagboek'].'"><input type="submit" value="Verwijderen" name="deleteDiary"></td>
									</form>
								</tr>';
						}		
					}	
				?>
			</tbody>
		</table>
	</div>
</body>
<?php
} else {
	header("Location: error.php");
}
?>
</html>