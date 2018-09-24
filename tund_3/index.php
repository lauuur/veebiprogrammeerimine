<?php
//echo "see on minu esimene php";
$firstname="Laur";
$lastname="Tõnisson";
$datetoday=date("d.m.Y");
$daytoday=date("d");
$weekdaynow=date("N");
$monthnow=date("m");
$yearnow=date("Y");
$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$monthnamesET=["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember"];

  //echo $weekdayNamesET[1];
  //var_dump($weekdayNamesET);
  //echo $weekdayNow;
$hournow=date("G");
$partofday = "";
if ($hournow<8){
	$partofday="varane hommik";
}
if ($hournow>=8 and $hournow<16){
	$partofday="koolipäev";
}
if ($hournow>=16){
	$partofday="ilmselt vaba aeg";
}
$picNum = mt_rand(2, 43);
  $picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
  $picEXT = ".jpg";
  $picFile = $picURL .$picNum .$picEXT;
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

<body style="background-color:#CEF6F5;font-family:comic sans ms;font-size: 12pt; text-align:center;" 
<!--background="https://www.tlu.ee/sites/default/files/styles/image_1300xn/public/%2BUudiste%20ja%20s%C3%BCndmuste%20pildid%20%28k%C3%B5igile%20kasutamiseks%29/3700x1100%20pildivalik187.jpg"-->

  <img src="https://www.tlu.ee/themes/tlu/logo.svg">
  <h1>
  <?php
  echo $firstname." ".$lastname;
  ?>, IF18
  </h1>
  <p>See leht on loodud <a href="http://tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha, ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  <?php 
  echo "<p>täna on ".$weekdayNamesET[$weekdaynow -1].", ".$daytoday." ".$monthnamesET[$monthnow -1]." ".$yearnow."</p>";
  echo "lehe avamise hetkel oli kell ".date("H:i:s").". Käes oli ".$partofday.".</p>\n";
  ?>
  <img src="<?php echo $picFile; ?>" title="TLÜ :P" alt="TLÜ Terra õppehoone">
  

  <!-- <p style="color:white;"><b>:O</b></p> 
  <img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1" title="ma õpin siin xD" alt="TLÜ Terra õppehoone" width="20%" height="20%" align="left"/>
  <img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone"> -->
  <p>mul on sõbrad, kes teevad ka veebi:
  <a href="../~patrpai" target="_blank">1</a> ja <a href="../~andrnar" target="_blank"> 2 </a></p>
   <p>Ägedad lehed: <a href="photo.php" target="_blank">photo</a>, <a href="photo2.php" target="_blank">photo2</a>, <a href="page.php" target="_blank">page</a></p>

  
</body>
</html>