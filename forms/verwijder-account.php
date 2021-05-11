<?php
// 	ini_set('display_errors', 1);
// 	ini_set('display_startup_errors', 1);
// 	error_reporting(E_ALL);
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteAccount'])) {
// 	$deleteacc = test_input($_POST["DeleteAccount"]);

// 	require '../src/diaries.php';
	
// 	$deleteacc = new Diaries();
// 	$deletedata = $deleteacc->deleteDiary($deleteacc, $_SESSION['id_gebruiker']);
// 	if ($deletedata == true) {
// 		header('Location: index.php');
// 		session_destroy(); 

// 	} else {
// 		echo "nope";
// 	}
// } else {
// 	header('Location: ../index.php');
// }


  // $deleteSS = new Diaries();
  // $deleteS = $deleteSS->deleteStory($_SESSION['id_dagboek']);


  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

	require '../src/users.php';


if (isset($_SESSION['id_gebruiker'])) {

  	// verwijdet account
  	$deleteacc = new Users();
  	$deletedata = $deleteacc->deleteAccount($_SESSION['id_gebruiker']);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          //something posted

      if (isset($_POST['DeleteAccount'])) {
        // /$deleteAllData = $deleteacc->deleteAll($_SESSION['id_gebruiker']);
        // stopt de sessie als er op verijder wordt geklikt
          session_destroy(); 
          header('Location: ../views/bye.php');
          
      } else {
          echo 'niet gelukt';
      }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
} else {
  header("Location: ../views/error/error.php");
}
?>