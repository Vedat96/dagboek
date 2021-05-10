<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Diaries {
	
	protected function connect() {
		$servername = "localhost";
		$username = "root";
		$password = "";

		try {
			// maakt connectie met database
		    $conn = new PDO("mysql:host=$servername;dbname=dagboek", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;  
	    }
	    catch(PDOException $e) {
		    return $e->getMessage();
		    
		}
	}
	public function addDiary($naam, $id_gebruiker){

		// verbinding maken met de database
		$conn = $this -> connect();
		// de query schrijven om het dagboek aan te maken
		$sql = 'INSERT INTO dagboeken (naam) VALUES(:naam)';
		// de query en de variabelen voorbereiden
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':naam', $naam);
		/* als de query is gelukt...
		   anders de connectie sluiten en false terugsturen */
		if($stmt -> execute()) {
			// de id ophalen van de net aangemaakte dagboek
			$id_dagboek = $conn->lastInsertId();
			// de query schrijven om de koppelgegevens in te voeren
			$sql2 = 'INSERT INTO gebruikers_dagboeken (id_gebruiker, id_dagboek) VALUES (:id_g, :id_d)';
			// de query en de variabelen voorbereiden
			$stmt2 = $conn->prepare($sql2);
			$stmt2->bindParam(':id_g', $id_gebruiker);
			$stmt2->bindParam(':id_d', $id_dagboek);
			/* als de query is ingevoerd, de connectie sluiten en true terugsturen,
			   anders de connectie sluiten en false terugsturen */
			if ($stmt2->execute()) {
				$conn = null;
				return true;
			} else {
				$conn = null;
				return false;
			}
		} 
		else{
			$conn = null;
			return false;
		}	
	}
	public function showDiary($id_gebruiker){

		$conn = $this -> connect();
		$sql = 'SELECT dagboeken.id_dagboek, dagboeken.naam FROM dagboeken INNER JOIN gebruikers_dagboeken ON gebruikers_dagboeken.id_dagboek = dagboeken.id_dagboek WHERE id_gebruiker = :id';
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
	public function addStory($post,$id_dagboek){

		// verbinding maken met de database
		$conn = $this -> connect();
		// de query schrijven om het dagboek aan te maken
		$sql = 'INSERT INTO posts (post, datum) VALUES(:post, NOW())';
		// de query en de variabelen voorbereiden
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':post', $post);
		/* als de query is gelukt...
		   anders de connectie sluiten en false terugsturen */
		if($stmt -> execute()) {
			// de id ophalen van de net aangemaakte verhaal
			$id_post = $conn->lastInsertId();
			// de query schrijven om de koppelgegevens in te voeren
			$sql2 = 'INSERT INTO dagboeken_posts (id_post, id_dagboek) VALUES (:id_p, :id_d)';
			// de query en de variabelen voorbereiden
			$stmt2 = $conn->prepare($sql2);
			$stmt2->bindParam(':id_p', $id_post);
			$stmt2->bindParam(':id_d', $id_dagboek);
			/* als de query is ingevoerd, de connectie sluiten en true terugsturen,
			   anders de connectie sluiten en false terugsturen */
			if ($stmt2->execute()) {
				$conn = null;
				return true;
			} else {
				$conn = null;
				return false;
			}
		} 
		else{
			$conn = null;
			return false;
		}	
	}

	public function showStory($id_dagboek){

		$conn = $this -> connect();
		$sql = 'SELECT * FROM posts INNER JOIN dagboeken_posts ON posts.id_post = dagboeken_posts.id_post WHERE id_dagboek = :id';
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':id',$id_dagboek);

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
	public function deleteDiary($id_dagboek){
	
		$conn = $this->connect();
		$sql = 'DELETE FROM dagboeken WHERE id_dagboek = :id_dagboek';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id_dagboek', $id_dagboek);
		if ($stmt->execute()) {
			$conn = null;
			return true;
		} else {
			$conn = null;
			return false;
		}
	}

	public function delete($id_dagboek) {
		$conn = $this->connect();
		
		$sql_select = 'SELECT id_post FROM dagboeken_posts WHERE id_dagboek = :id_dagboek';
		$sql_delete_post = 'DELETE FROM posts WHERE id_post = :id_post';
		$sql_delete_diary_post = 'DELETE FROM dagboeken_posts WHERE id_post = :id_post';
		$sql_delete_diary = 'DELETE FROM dagboeken WHERE id_dagboek = :id_dagboek';
		$sql_delete_users_diaries = 'DELETE FROM gebruikers_dagboeken WHERE id_dagboek = :id_dagboek';
		
		$stmt_select = $conn->prepare($sql_select);
		$stmt_delete_post = $conn->prepare($sql_delete_post);
		$stmt_delete_diary_post = $conn->prepare($sql_delete_diary_post);
		$stmt_delete_diary = $conn->prepare($sql_delete_diary);
		$stmt_delete_users_diaries = $conn->prepare($sql_delete_users_diaries);
		$stmt_delete_users_diaries->bindParam(':id_dagboek', $id_dagboek);
		$stmt_select->bindParam(':id_dagboek', $id_dagboek);
		$stmt_delete_diary->bindParam(':id_dagboek', $id_dagboek);
		
		if ($stmt_select->execute()) {
			while ($data_select = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
				$id_post = $data_select['id_post'];
				$stmt_delete_post->bindParam(':id_post', $id_post);
				$stmt_delete_diary_post->bindParam(':id_post', $id_post);
				if ($stmt_delete_post->execute() == false || $stmt_delete_diary_post->execute() == false) {
					$conn = null;
					return false;
				}
			}
			if ($stmt_delete_diary->execute() && $stmt_delete_users_diaries->execute()) {
				$conn = null;
				return true;
			} else {
				$conn = null;
				return false;
			}
		} else {
			$conn = null;
			return false;
		}
	}
		public function deleteStory($id_dagboek){
	
		$conn = $this->connect();
		$sql = 'DELETE FROM posts WHERE id_post = :id_post';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id_post', $id_post);
		if ($stmt->execute()) {
			$conn = null;
			return true;
		} else {
			$conn = null;
			return false;
		}
	}
	public function find($id_dagboek, $datum){

		$conn = $this -> connect();
		$sql = 'SELECT * FROM posts INNER JOIN dagboeken_posts ON posts.id_post = dagboeken_posts.id_post WHERE dagboeken_posts.id_dagboek = :id AND posts.datum = :datum';
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':id',$id_dagboek);
		$stmt->bindParam(':datum',$datum);

		if($stmt->execute()){
			//execute en dan data ophalem
		
			$data = $stmt->fetchAll();

			// haalt data op, en returnt het
			return $data;
			if ($data == NULL) {
				$conn = null;
				return false;
			}
			else{
				$conn = false;
				return $data;
			}
		}
	}

    public function countStories($id_dagboek){

		$conn = $this -> connect();
		$sql = 'SELECT * FROM dagboeken_posts WHERE id_dagboek = :id';
		$stmt = $conn -> prepare($sql);
		$stmt->bindParam(':id',$id_dagboek);

		//execute en dan data ophalen
		if($stmt->execute()){
			
		// haalt alle data op, en returnt het
			$data = $stmt->rowCount();
			$conn = null;
			return $data;
		}
		else{
			$conn = null;
			return false;
		}
		$conn = null;
		return false;		
	}
	
}