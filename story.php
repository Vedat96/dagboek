<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
// storydata.php wordt geinclude
require 'forms/storydata.php';
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
				<!-- <li><a href="index.php">Log in</a></li>
				<li><a href="register.php">Register</a></li> -->
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
			<li><H3><a href="account.php"> Mijn account</a></H3></li>
		</ul> 
	</div>
	<hr>
	<div class="container">
		<!-- form voor zoeken -->
		<form class= "search" method="POST">
			<input type="text" value="" name="datum" placeholder="2003/12/30">
			<input type="submit" name="find" value="Zoek">
			<br><br>
			<table class="myTable">
				<thead>
					<th>Date	</th>
					<th>Stories </th>
				</thead>
				<tbody>
				<?php
					// als er wat in find zit dan wordt dat getoond
					if (isset($_POST['find'])){
						$searchdata = $story->find($id_dagboek, $_POST['datum']);
					
						foreach ($searchdata as $value) {
							echo "<tr>
							<td>" . $value['datum'] . "</td>
							<td>" . $value['post'] . "</td>
							</tr>";
						}
					}
				?>
				</tbody>
			</table>
		</form>

	<!-- form om een verhaal toe te voegen -->
		<form action="forms/verhaal-aanmaken.php" class= "addbutton" method="POST">
			Voeg een verhaal toe
			<input type="text" value="" required name="addStory">
			<button> Opslaan</button>
		</form>
		<br>

		<table class="myTable">
			<thead>
	 			<th>Date</th>
				<th>Stories</th>
			</thead>
			<tbody>
				<!-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Zoek naar datum.." title="Type in a name"> -->

				<!-- als er een verhaal bestaat wordt die getoond en in een tabel gezet -->
				<?php
					if($storydata != false){
						foreach ($storydata as $value) {
							echo '
									<tr> 
										<td>'.$value['datum'].'</td> 
										<td>'.$value['post'].'</td> 
										<input type="hidden" name="id" value="'.$value['id_dagboek'].'"> 
									</tr> ';
						}
					}
				?>
	<!-- 			<script>
				function myFunction() {
					var input, filter, table, tr, td, i;
					input = document.getElementById("myInput");
					filter = input.value.toUpperCase();
					table = document.getElementById("myTable");
					tr = table.getElementsByTagName("tr");
					for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td")[0];
				    	if (td) {
				    		if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				        		tr[i].style.display = "";
				      			} else {
				        		tr[i].style.display = "none";
				      			}
				    		}       
				  		}
					}
				
				</script> -->
			</tbody>
		</table>
	</div>
</body>
<?php
// bij geen sessie kan je niet deze site io.
} else {
	header("Location: error.php");
}
?>
</html>