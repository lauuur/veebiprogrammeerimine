<?php

//laen andmebaasi info
require("../../../config.php");
//echo $GLOBALS["serverUsername"];

$database="if18_laur_to_1";

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

?>