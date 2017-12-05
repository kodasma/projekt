<?php
	require("../../config.php");
	$database = "if17_kodakevi";
	$photo_dir = "../images/";
	
	session_start();
	
	//SISSELOGIMISE FUNKTSIOON
	function signIn($email, $password){
		$notice = "";
		//ühendus serveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password FROM projectusers WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kontrollime vastavust
		if ($stmt->fetch()){
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				$notice = "Logisite sisse!";
				
				//määran sessiooni muutujad
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				//liigume edasi pealehele (main.php)
				header("Location:upload.php");
				exit();
			} else {
				$notice = "Vale salasõna!";
			}
		} else {
			$notice = 'Sellise kasutajatunnusega "' .$email .'"pole registreeritud!';
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO projectusers (firstname, lastname, birthday, email, password) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sssss", $signupFirstName, $signupFamilyName, $signupBirthDate, $signupEmail, $signupPassword);
		if($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga:" .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}

	//Kõikide looma lugude lugemine
  function readAllStories() {
    $ideasHTML = "";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    //$stmt = $mysqli->prepare("SELECT idea, ideaColor FROM vpuserideas WHERE userid = ?");
    $stmt = $mysqli->prepare("SELECT filename, story FROM projectphotos WHERE userid = ? ORDER BY id DESC");
    $stmt->bind_param("i", $_SESSION["userId"]);
    $stmt->bind_result($filename, $story);
    $stmt->execute();
    //$result = array();
    while ($stmt->fetch()) {
      #$ideasHTML .= '<p>' .$filename ." " .$story ."</p> \n";
	  $ideasHTML .= '<img src="' .$GLOBALS["photo_dir"] .$filename .'" alt="' .$story .'">';
      //link: <a href="ideaedit.php?id=4"> Toimeta </a>
    }
    $stmt->close();
    $mysqli->close();
    return $ideasHTML;
  }
	
	function saveStory($story, $filename){
		//echo $color;
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO projectphotos (userid, filename, story) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss", $_SESSION["userId"], $filename, $story);
		if($stmt->execute()){
			$notice = "Lugu on salvestatud!";
		} else {
			$notice = "Loo salvestamisel tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function test_input($data){
		$data = trim($data); //ebavajalikud tühikud jms eemaldada
		$data = stripslashes($data);//kaldkriipsud jms eemaldada
		$data = htmlspecialchars($data);//keelatud sümbolid
		return $data;
	}
?>