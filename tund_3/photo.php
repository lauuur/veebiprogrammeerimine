<?php
  $firstName = "Laur";
  $lastName = "Tõnisson";
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/";
  $allFiles = scandir($dirToRead);
  $picFiles = array_slice($allFiles, 2);
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
   <p><b>corgi, kes tasakaalustab asju oma pea peal :o</b></p>
 <?php
	//var_dump($picFiles);  
	//<img src="../../pics/" alt="pilt">
   for ($i = 0; $i < count ($picFiles) ; $i ++ ){
   echo '<img src="' .$dirToRead .$picFiles [$i] .'" alt="pilt">'; 
   }
   ?>
</body>
</html>