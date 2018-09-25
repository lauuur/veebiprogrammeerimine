<?php
  $firstName = "Laur";
  $lastName = "Tõnisson";
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/";
  $allFiles = scandir($dirToRead);
  $picFiles = array_slice($allFiles, 2);
  $picNum = mt_rand(1,39);
  ?>
  
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
  <?php
  echo $firstName;
  echo " ";
  echo $lastName;
  ?>
  , õppetöö</title> 
</head>
<body> 
 <body style="background-color:cyan">
  <h1> 
   <?php
   echo $firstName ." " . $lastName; 
   ?>, IF18</h1>
   <p><b>random pilt corgist, kes tasakaalustab asju oma pea peal :o</b></p>
  <?php echo '<img src="'.$dirToRead.$picFiles[mt_rand(2,40)].'"alt="pilt"><br>'."\n";
  ?>
</body>
</html>