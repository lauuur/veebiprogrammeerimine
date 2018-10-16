<?php

//laen andmebaasi info
require("../../../config.php");
//echo $GLOBALS["serverUsername"];

$database="if18_laur_to_1";


//võtan kasutusele sessiooni
session_start();

//kasutajate profiilid
function description($message, $bgcolor, $textcolor){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt1 = $mysqli->prepare("SELECT userid, description, bgcolor, txtcolor FROM vpuserprofiles");
		echo $mysqli->error;
		$stmt2 ->bind_result($useridFromDb,$message,$bgcolor,$textcolor);
		
		if($stmt1->fetch()){
			$stmt2 = $mysqli->prepare("UPDATE description, bgcolor, txtcolor FROM vpuserprofiles VALUES(?,?,?)");
			echo $mysqli->error;
			$stmt2->bind_param("sss",$message,$bgcolor,$textcolor);
			if($stmt1->execute()){
				$notice = 'Kirjeldus: "'.$message.'" on uuendatud';
			}
		}else{
			$stmt2 = $mysqli->prepare("INSERT INTO vpuserprofiles(userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $mysqli->error;
			$stmt2->bind_param("isss",$_SESSION["userId"],$message,$bgcolor,$textcolor);
			if($stmt2->execute()){
				$notice = 'Kirjeldus: "'.$message.'" on salvestatud';
			}
			$stmt1->close();
			$stmt2->close();
			$mysqli->close();
			return $notice;
			}		
	 }
/*function adduserprofile(){
	$asd="";
	$notice="";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("INSERT INTO vpuserprofiles(userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
	$stmt->execute();
	if ($stmt->execute()){
		$notice='profiil: "' .$asd. '" on salvestatud.';
	} else{
		$notice="profiili loomisel tekkis tõrge: ". $stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
}*/

//valideeritud sõnumid kasutajate kaupa
function readallvalidatedmessagesbyuser(){
$msghtml="";
$totalhtml="";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$stmt=$mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");
echo $mysqli->error;
$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
$stmt2=$mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
echo $mysqli->error;
$stmt2->bind_param("i", $idFromDb);
$stmt2->bind_result($msgFromDb, $acceptedFromDb);
$stmt->execute();
//et hoida andmebaasist loetud andmeid pisut kauem mälus, et  saaks edasi kasutada
$stmt->store_result();

while ($stmt->fetch()){
	
	$msghtml.="<h3>".$firstnameFromDb." ".$lastnameFromDb."</h3>\n";
	$stmt2->execute();
	while ($stmt2->fetch()){
	$msghtml.="<p><b>";
		if($acceptedFromDb==1){
		$msghtml.="Lubatud: ";
		}else{
		$msghtml.="Keelatud: ";
		}
		$msghtml.="</b>".$msgFromDb."</p>\n";
	
	}
	
}
$stmt2->close();
$stmt->close();
$mysqli->close();
return $msghtml;
}

//kasutajate nimekiri
  function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id !=?");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function allvalidmessages(){
	$html = "";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=? ORDER BY accepttime DESC");
	echo $mysqli->error;
	$stmt->bind_param("i", $valid);
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Kontrollitud sõnumeid pole.</p>";
	}
	return $html;
  }
  
  function validatemsg($editId, $validation){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?");
	$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: validatemsg.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }

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