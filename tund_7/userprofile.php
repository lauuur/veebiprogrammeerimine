<?php
  require("functions.php");
  //kui pole sisse logitud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  $mydescription="";
  $mybgcolor="";
  $mycolor="";
  
  
  $notice = null;
	if (isset($_POST["submitMessage"])){
		if($_POST["description"]!="Kirjelda ennast: " and !empty($_POST["description"])){
			$message = test_input($_POST["description"]);
			$bgcolor = test_input($_POST["bgcolor"]);
			$textcolor = test_input($_POST["textcolor"]);
			$notice = description($message, $bgcolor,$textcolor);	
		}else{
			$notice = "Kirjuta midagi";
			}
	}
	
	$message = "";
	$bgcolor="#FFFFFF";
	$textcolor="#000000";
	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Profiili loomine</title>
	</head>
	<body>
    <h1>Profiili loomine</h1>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]." ".$_SESSION["lastName"];?></p>
	<!--<form method="POST" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">-->
	<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?>Kirjelda ennast: </textarea>
	<br>
	<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>">
	<br>
	<label>Minu valitud tekstivärv: </label><input name="color" type="color" value="<?php echo $mycolor; ?>">
	<br>
	<input type="submit" name="submitMessage" value="Loo profiil">
	<br>
	<p><a href="main.php">Tagasi pealehele</a></p>
	<br>
  </body>
</html>