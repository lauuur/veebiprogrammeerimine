<?php
  require("functions.php");
  //kui pole sisse logitud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  $mydescription="";
  $mybgcolor="";
  $mytxtcolor="";
  
  
  /*$notice = null;
	if (isset($_POST["submitMessage"])){
		if($_POST["description"]!="Kirjelda ennast: " and !empty($_POST["description"])){
			$message = test_input($_POST["description"]);
			$bgcolor = test_input($_POST["bgcolor"]);
			$textcolor = test_input($_POST["textcolor"]);
			$notice = description($message, $bgcolor,$textcolor);	
		}else{
			$notice = "Kirjuta midagi";
			}
	}*/
	
	 //väljalogimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_1.php");
	exit();
  }
  
  $mydescription = "Pole tutvustust lisanud!";
  $mybgcolor = "#FFFFFF";
  $mytxtcolor = "#000000";
  
  if(isset($_POST["submitProfile"])){
	$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $mydescription = $_POST["description"];
	}
	$mybgcolor = $_POST["bgcolor"];
	$mytxtcolor = $_POST["txtcolor"];
  } else {
	$myprofile = showmyprofile();
	if($myprofile->description != ""){
	  $mydescription = $myprofile->description;
    }
    if($myprofile->bgcolor != ""){
	  $mybgcolor = $myprofile->bgcolor;
    }
    if($myprofile->txtcolor != ""){
	  $mytxtcolor = $myprofile->txtcolor;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Profiili loomine</title>
	<style>
	  <?php
        echo "body{background-color: " .$mybgcolor ."; \n";
		echo "color: " .$mytxtcolor ."} \n";
	  ?>
	</style>
	</head>
	<body>
    <h1>Profiili loomine</h1>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]." ".$_SESSION["lastName"];?></p>
	<!--<form method="POST" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">-->
	<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?>Kirjelda ennast: </textarea>
	<br>
	<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>">
	<br>
	<label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mycolor; ?>">
	<br>
	<input type="submit" name="submitProfile" value="Salvesta profiil">
	<br>
	<p><a href="main.php">Tagasi pealehele</a></p>
	<br>
  </body>
</html>