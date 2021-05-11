<header>
	<div class="navbar">
		<ul>
			<li><img src="../images/dagboek.jpg" id="dagboek"></li>
			<li><H1> Mijn Dagboek</H1></li>
		</ul> 

		<?php 
if (isset($_SESSION['id_gebruiker'])) {
?>
		<form action="../forms/logout.php" method="POST">
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

<?php } ?>