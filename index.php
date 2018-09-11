<?php
//echo "see on minu esimene php";
$firstname="Laur";
$lastname="Tõnisson";
$datetoday=date("d.m.Y");
$hournow=date("G");
if ($hournow<8){
	$partofday="varane hommik";
}
if ($hournow>=8 and $hournow<16){
	$partofday="koolipäev";
}
if ($hournow>=16){
	$partofday="ilmselt vaba aeg";
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>
  <?php
   echo $firstname." ".$lastname;
  ?>, õppetöö
  </title>
</head>

<body style="background-color:powderblue;font-family:comic sans ms;font-size: 12pt; text-align:center;" 
background="https://www.tlu.ee/sites/default/files/styles/image_1300xn/public/%2BUudiste%20ja%20s%C3%BCndmuste%20pildid%20%28k%C3%B5igile%20kasutamiseks%29/3700x1100%20pildivalik187.jpg">

  <img src="https://www.tlu.ee/themes/tlu/logo.svg">
  <h1>
  <?php
  echo $firstname." ".$lastname;
  ?>, IF18
  </h1>
  <p>See leht on loodud <a href="http://tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha, ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  <?php 
  echo "<p>tänane kuupäev on ".$datetoday."</p>";
  echo "lehe avamise hetkel oli kell ".date("H:i:s").". Käes oli ".$partofday.".</p>\n";
  ?>
  <!-- <p style="color:white;"><b>:O</b></p> -->
  <img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1" title="ma õpin siin xD" alt="TLÜ Terra õppehoone" width="20%" height="20%" align="left"/>
  <!-- <img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone"> -->
  <span style="background-color:cyan;"> mul on sõbrad, kes teevad ka veebi:
  <a href="../~patrpai" target="_blank">1</a> ja <a href="../~andrnar" target="_blank"> 2 </a></span>
  
  
</body>
</html>