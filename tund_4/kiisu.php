<?php
  //kutsume välja funktsioonide faili
require("functions.php");
 $cats=showcats();
$notice=null;
$catname=null;
$catcolor = null;
$catlength= null;
 
  if (isset($_POST["submitMessage"])){
		if($_POST["nimi"]!=empty($_POST["nimi"]) and $_POST["v2rv"]!=empty($_POST["v2rv"]) and $_POST["saba"]!=empty($_POST["saba"])){
			$catname = test_input($_POST["nimi"]);
			$catcolor=test_input($_POST["v2rv"]);
			$catlength=test_input($_POST["saba"]);
			$notice = addcat($catname,$catcolor,$catlength);
			
		}else{
			$notice = "Kirjuta midagi";
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>kiisude lisamine</title>
</head>
<body style="font-family:comic sans ms;">
	<h1>kiisude lisamine</h1>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>kasside lisamine:</label>
	  <br>
	 <p>Kassi nimi</p>
	<input type="text" name="nimi">
	<p>Kassi värv</p>
	<input type="text" name="v2rv">
	<p>Kassi saba pikkus</p>
	<input type="number" name="saba">
	  <br>
	  <input type="submit" name="submitMessage" value="salvesta kass">
    </form>
	<hr>
	<p><?php echo $notice; ?></p>
	<p><?php foreach($cats as $cat): ?>

                <?= $cat['id_kiisu'] ?> <?= $cat['nimi'] ?> <?= $cat['v2rv'] ?> <?= $cat['saba'] ?><br>
            <?php endforeach; ?></p>
	
</body>
</html>