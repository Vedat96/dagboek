<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'diaries.php';
// Gebruikt ook diaries.php, om de account te verwijderen
class Users extends Diaries {

	public function connect() {

		$servername = "localhost";
		$username = "root";
		$password = "";

		try {
			//connect met database
		    $conn = new PDO("mysql:host=$servername;dbname=dagboek", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;  
	    }
	    catch(PDOException $e) {
		    return $e->getMessage();
		    
		}
	}

	public function getData($id_gebruikers){
		// maakt verbinding met database
		$conn = $this -> connect();
		//  bereid de query voor
		$sql ='SELECT * FROM gebruikers WHERE id_gebruiker = :id';
		$stmt = $conn -> prepare($sql);
		// verbind de id_gebruikers uit de database met de id
		$stmt -> bindParam(':id', $id_gebruikers);
		if($stmt -> execute()){
			$data = $stmt -> fetch(PDO::FETCH_ASSOC);
			$conn = null;
			return $data; 
		} 
		else{
			$conn = null;
			return false;
		}
	}
	public function displayUserEditForm($id_gebruiker) {
		// maakt verbinding met database
		$conn = $this->connect();
		// maakt een variabele met de verwijzing naar functie getData.
		$value = $this->getData($id_gebruiker);
		// laat de form zien
		echo '<tr>
				<form action="forms/bewerk-account.php" method="post"> 
					<td><input type="text" name="voornaam" value="'.$value['voornaam'].'"></td>
					<td><input type="text" name="tussenvoegsel" value="'.$value['tussenvoegsel'].'"></td>
					<td><input type="text" name="achternaam" value="'.$value['achternaam'].'"></td>
					<td><input type="email" name="email" value="'.$value['email'].'"></td>
					<td><input type="password" name="wachtwoord" placeholder="******"></td>
					<td><input type="submit" name="Wijzigen" value="Wijzigen"></td>
				</form>
			</tr>';
	}

	public function register($voornaam,$tussenvoegsel,$achternaam,$email,$wachtwoord){

		// hasht de wachtwoord
		$wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT, ['cost' => 12]); 
			// connect
		$conn = $this -> connect();

		$stmt = $conn->prepare('SELECT COUNT(email) AS EmailCount FROM gebruikers WHERE email = :email');
		$stmt->execute(array('email' => $_POST['email']));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		// als de aantal van de mails 0 is maakt hij een account met die mail
		if ($result['EmailCount'] == 0) {

			
			// bereid sql voor
			$sql = 'INSERT INTO gebruikers(voornaam,tussenvoegsel,achternaam, email, wachtwoord) VALUES(:voornaam,:tussenvoegsel,:achternaam,:email,:wachtwoord)';
			$stmt = $conn -> prepare($sql);
			$stmt->bindParam(':voornaam',$voornaam);
			$stmt->bindParam(':achternaam',$achternaam);
			$stmt->bindParam(':tussenvoegsel',$tussenvoegsel);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':wachtwoord',$wachtwoord);
			//voert stmt uit en geeft $id terug
			if($stmt -> execute()) {
				$id = $conn->lastInsertId();
				$conn = null;
				return $id;
			} 
			else{
				$conn = null;
				return false;
			}	
		}

			
		    // $stmt = $pdo->prepare('INSERT INTO gebruikers (email) VALUES (:email)');
		    // $stmt->execute(array('email' => $_POST['email']));
		    // echo 'Thank you for Submitting. Redirecting back to Home Page';
		// als de mail al bestaat dus meer dan 0 is, stuurt hij hem terug
		else {
		    echo("<script>alert('email bestaat al!')</script>");
 			echo("<script>window.location = '../index.php';</script>");
		}
	}

	public function login($email,$wachtwoord){
		
		$conn = $this -> connect();
		$sql = 'SELECT id_gebruiker, wachtwoord FROM gebruikers WHERE email = :email';
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':email',$email);

		if($stmt->execute()){
			//execute en dan data ophalem
		
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$conn = null;
			// alls wachtwoord klopt krijgt hji een sessie en logt in
			if(password_verify($wachtwoord, $data['wachtwoord'])){
				$_SESSION['id_gebruiker'] = $data['id_gebruiker'];
			}
			else{
				$conn = null;
				header("Location: ../index.php");
			}
			if(empty($error)){
			echo("<script>alert('Geen geldig account!')</script>");
			echo("<script>window.location = '../relog.php';</script>");
			// $error = $error . 'Email of Wachtwoord onjuist.<br>';
			// header("Location: ../relog.php");

			}
		}
		else {
			$conn = null;
			return false;
		}
	}
	
	public function editTemp($voornaam,$tussenvoegsel,$achternaam,$email,$wachtwoord){

		$conn = $this -> connect();
		$sql = 'SELECT * FROM gebruikers WHERE id_gebruiker = :id';
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':id',$id_gebruiker);


		if($stmt->execute()){
			//execute en dan data ophalem
		
			$data = $stmt->fetchAll();				
			// haalt alle data op, en returnt het
			$conn = null;
			return $data;
		}
		else{
			$conn = null;
			return false;
		}		
	}

	public function edit($id_gebruiker, $voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord) {
		// hasht wachtwoord
		$wachtwoord = Password_hash($wachtwoord, PASSWORD_BCRYPT, ['cost' => 12]);
		// maakt connectie met database
		$conn = $this->connect();
		// bereui sql voor
		$sql = 'UPDATE gebruikers SET voornaam = :vnaam, tussenvoegsel = :tnaam, achternaam = :anaam, email = :email, wachtwoord = :wwoord WHERE id_gebruiker = :id';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':vnaam', $voornaam);
		$stmt->bindParam(':tnaam', $tussenvoegsel);
		$stmt->bindParam(':anaam', $achternaam);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':wwoord', $wachtwoord);
		$stmt->bindParam(':id', $id_gebruiker);
		// voert het uit
		if ($stmt->execute()) {
			$conn = null;
			return true;
		} else {
			$conn = null;
			return false;
		}
	}

	public function deleteAccount($id_gebruiker) {
		// verbinding met database
		$conn = $this->connect();
		// bereui sql voor
		$sql_select = 'SELECT * FROM gebruikers_dagboeken WHERE id_gebruiker = :id';
		$stmt_select = $conn->prepare($sql_select);
		$stmt_select->bindParam(':id', $id_gebruiker);
		if ($stmt_select->execute()) {
			//  hier wordt de functie delete gebruikt uit diaries.php om alles te kunnen verwijderen
			while ($data = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
				$delete_dagboek = $this->delete($data['id_dagboek']);
				if ($delete_dagboek === true) {
					$conn = $this->connect();
				} else {
					return false;
				}
			}
			// bereui sql voor
			$sql_delete = 'DELETE FROM gebruikers WHERE id_gebruiker = :id';
			$stmt_delete = $conn->prepare($sql_delete);
			$stmt_delete->bindParam(':id', $id_gebruiker);
			if ($stmt_delete->execute()) {
				$conn = null;
				return true;
			} else {
				$conn = null;
				return false;
			}
		}
	}











}
	/*
	public function deleteUser($id_gebruiker){
		$conn = $this->connect();
		$sql = 'DELETE gebruikers FROM gebruikers INNER JOIN gebruikers_dagboeken ON gebruikers.id_gebruiker = gebruikers_dagboeken.id_gebruiker WHERE id_gebruiker = :id_gebruiker';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id_gebruiker', $id_gebruiker);
		if ($stmt->execute()) {
			$conn = $this->connect();
			$sql = 'DELETE dagboek FROM dagboeken WHERE id_dagboek = :id_dagboek INNER JOIN gebruikers_dagboeken ON dagboeken.id_dagboek = gebruikers_dagboeken.id_dagboek';
			$stmt1 = $conn->prepare($sql);
			$stmt1->bindParam(':id_dagboek', $id_dagboek);
			if ($stmt1->execute()) {
				$conn = $this->connect();
				$sql = 'DELETE post FROM posts WHERE id_post = :id_post INNER JOIN dagboeken_posts ON posts.id_post = dagboeken_posts.id_post';
				$stmt2 = $conn->prepare($sql);
				$stmt2->bindParam(':id_post', $id_post);
			}
			else {
			$conn = null;
			return false;
			}
		}	
		else {
			$conn = null;
			return false;
		}
	}

	dit verwijderde alleen de account en de de dagboek en verhalen.
	*/


?>


