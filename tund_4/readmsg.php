<?php
  //kutsume välja funktsioonide faili
require("functions.php");
 
$notice=listallmessages();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>anonüümse sõnumi lugemine</title>
</head>
<body style="font-family:comic sans ms;">
	<h1>sõnumi lugemine</h1>
	<hr>
<?php echo $notice; ?>
	
</body>
</html>