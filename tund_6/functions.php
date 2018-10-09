<?php

//laen andmebaasi info
require("../../../config.php");
//echo $GLOBALS["serverUsername"];

$database="if18_laur_to_1";


//võtan kasutusele sessiooni
session_start();

//loen sõnumi valideerimiseks
  function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }

//valideerimata sõnumite lugemine
  function readallunvalidatedmessages(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC");
	echo $mysqli->error;
	$stmt->bind_result($id, $msg);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
	}
	$notice.="</ul>\n";
	$stmt->close();
	$mysqli->close();
	return $notice;
  }



//tekstsisestuse kontroll
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	
}

function saveamsg($msg) {
	$notice="";
	//serveriühendus(server, kasutaja, parool, andmebaas)
	$mysqli=new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistan ette SQL käsu
	$stmt=$mysqli->prepare("INSERT INTO vpamsg(message) VALUES(?)");
	echo $mysqli->error;
	//asendame SQL käsus küsimärgi päris infoga(andmetüüp, andmed ise)
	//s-string, i-integer, d-decimal
	$stmt->bind_param("s", $msg);
	if ($stmt->execute()){
		$notice='sõnum: "' .$msg. '" on salvestatud.';
	} else{
		$notice="sõnumi salvestamisel tekkis tõrge: ". $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
	
}

function listallmessages(){
	$msgHTML="";
	$mysqli=new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	$stmt->fetch();
	while($stmt->fetch()){
	$msgHTML.="<p>".$msg."</p>\n";

	}
	$stmt->close();
	$mysqli->close();
	return $msgHTML;	
	
}

function addcat($catname, $catcolor,$catlength){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kiisu(nimi, v2rv, saba) VALUES(?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $catname,$catcolor,$catlength);
		$stmt->execute();
		$stmt->close();
	}
		
function showcats(){
		 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT * FROM kiisu");
		$id = "";
		$name = "";
		$color = "";
		$tail_length = "";
		$stmt-> bind_result($id, $name,$color,$tail_length);
		$stmt -> execute();
		while($stmt->fetch()) {
        $cats[] = [
            'id_kiisu' => $id,
            'nimi' => $name,
            'v2rv' => $color,
            'saba' => $tail_length];
		}
		$stmt->close();
		return $cats;
	
	}

	function signup($firstName, $lastName, $birthDate, $gender, $email, $password){
		$notice="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers(firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//valmistame parooli ette salvestamiseks, krüpteerime, teeme räsi(hash)
		$options=[
		"cost"=>12,
		"salt"=>substr(sha1(rand()), 0, 22),];
		$pwdhash=password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice="Uue kasutaja lisamine õnnestus";
		}else{
			$notice="Kasutaja lisamisel tekkis viga: ". $stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	//sisselogimine
	function signin($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
		$mysqli->error;
		$stmt->bind_param("s",$email);
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		if($stmt->execute()){
			//kui õnnestus andmebaasi lugemine
			if($stmt->fetch()){
				//kasutaja leiti, kontrollime parooli
				if(password_verify($password, $passwordFromDb)){
					//parool õige
					$notice="Sisselogimine õnnestus!";
					$_SESSION["userId"]=$idFromDb;
					$_SESSION["firstName"]=$firstnameFromDb;
					$_SESSION["lastName"]=$lastnameFromDb;
					$stmt->close();
					$mysqli->close();
					header("Location: main.php");
					exit();
				}else{
					$notice = "Vale parool!";
				}
			}else{
				$notice="Sellist kasutajat (".$email.") ei leitud!";
			}
		} else {
		$notice = "Tekkis tehniline viga".$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice; 
	 }
	
?>