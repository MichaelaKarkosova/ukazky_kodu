
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<meta http-equiv="content-type" content="text/plain;" />

<script>

function clearform()
{
    document.getElementById("nazev").value="";
}
</script>
<script>
function back(){
	location.href = "./";
}
</script>
<script>
function ranky(){
	location.href = "/ranks.php";
}
</script>
<?php
//hodnocení kvality zdroje pomocí odkazu z czc.
$GLOBALS['certifikacebody'] = 0;
$GLOBALS['dbhost'] = '******';
$GLOBALS['dbuser'] = '******';
$GLOBALS['dbpass'] = '******';
$GLOBALS['dbname'] = 'komponenty';
ini_set("allow_url_fopen", 1);
$vysledek = 0;
echo "<input type='submit' class='button' name='ranky' value='Ranky' onClick='ranky();'> ";
echo "
  
<input type='submit' class='button' name='zpet' value='Zpět' onClick='back();'>
	 <form method='post' name='POST'/>
  <p>&nbsp;</p> <p>&nbsp;</p><p>&nbsp;</p>  Url z CZC: <input name='nazev' rows='5' cols='10'></textarea>
   <input type='submit' name='submit' value='Odeslat' onClick='clearform();'>";
echo "<p>Pošli nám odkaz na zdroj a my ti o něm zjistíme informace a ohodnotíme.</p>";
ini_set('display_errors', false);
error_reporting(E_ALL);
if (isset($_POST["nazev"])){
	 $hodnoceno = false;
	 //kontrola, zda url obsahuje url czc
if (strpos($_POST["nazev"], 'https://www.czc.cz/') !== false or strpos($_POST["nazev"], 'http://www.czc.cz/') !== false or strpos($_POST["nazev"], 'www.czc.cz/') !== false) {
  $czclink = true;
}
if ($czclink != true){
	echo "<script>alert('Musíš zadat link z czc!')</script>";
	
}
else{
	//stáhne si obsah odkazu
    $content = file_get_contents($_POST["nazev"]);

    $del='title="Název produktu:"';
    //najde, kde je nazev produktu
    $pos=strpos($content, 'title="Název produktu:');
    $real = strlen($content)-strlen($content)+150;
    $nazev=substr($content, $pos+strlen($del), $real);
    $nazevc = "";
    $vyrobcec= "";
    $modelc= "";
    //korektura názvu
    for ($i = 0; $i < strlen($nazev); $i++){
	    if ($nazev[$i] != '"' and $nazev[$i] != '+'){
		    $nazevc = "".$nazevc."".$nazev[$i]."";
	    }
        else{
	        break;
        }
    }
    //korektura výrobce
    $vyrobce = $nazev;
    for ($i = 0; $i < strlen($vyrobce); $i++){
	    if ($vyrobce[$i] != ' ' and $vyrobce[$i] != '+'){
		    $vyrobcec= "".$vyrobcec."".$vyrobce[$i]."";
	    }
        else{
	        break;
        }

    }
    //korektura modelu
    $model = $nazev;
    for ($i = 0; $i < strlen($model); $i++){
	    if ($model[$i] != '-' and $model[$i] != '+'){
		    $modelc= "".$modelc."".$model[$i]."";
	    }
        else{
	        break;
        }
    }
    //korektura některých znaků v modelu
    $modelc = str_replace(" ", "", $modelc);
    $modelc = str_replace(",bílý", "", $modelc);
    $modelc = str_replace($vyrobcec, "", $modelc);

    $modelc = str_replace(" - ", "", $modelc);
    $modelc = preg_replace('/[0-9]+/', '', $modelc);
    $modelcc = "";
    for ($i = 0; $i < strlen($modelc); $i++){
	    if ($modelc[$i] != '-' and $modelc[$i] != '+'){
		    $modelcc= "".$modelcc."".$modelc[$i]."";
	    }
        else{
	        break;
        }

    }


    $sql  = "select * from komponenty.rank where (serie = '".$modelcc."') or (znacka = '".$vyrobcec."' and serie='*')";
    $conn = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
	    $bodymodel = $row['rating'];
	 
    }
    $bodymodel  = (int)$bodymodel;
    $content = file_get_contents($_POST["nazev"]);

    $del='Výkon zdroje [W]:</span>';
    $pos=strpos($content, $del);
    $real = strlen($content)-strlen($content)+150;
    $kapacita=substr($content, $pos+strlen($del), $real);
    $kapacita = str_replace("<strong>", "", $kapacita);
    $kapacita = str_replace(" ", "", $kapacita);
    $kapacita = preg_replace('/\s+/', '', $kapacita);
    $kapacita = preg_replace('~\D~', '', $kapacita);
    for ($i = 0; $i < strlen($kapacita); $i++){
	    if ($kapacita[$i] != '<' and $kapacita[$i] != '+'){
		    $kapacitac = "".$kapacitac."".$kapacita[$i]."";
	    }
        else{
	        break;
        }

    }
    $kapacitac = (int)$kapacitac;

    $content = file_get_contents($_POST["nazev"]);
//echo htmlentities($content);
    $del='Záruka:</span>';
    $CWNotset = false;
    $pos=strpos($content, $del);
    $real = strlen($content)-strlen($content)+150;
    $zaruka=substr($content, $pos+strlen($del), $real);
    $zaruka = str_replace("<strong>", "", $zaruka);
    $zaruka = preg_replace('/\D/', '', $zaruka);
    $zaruka = (int)$zaruka;
    bodyzaruka($zaruka);
    $del=htmlentities('cena bez DPH:');
    $pos=strpos($content, $del);
    $real = strlen($content)-strlen($content)+40;
    $cenax=substr($content, $pos+strlen($del), $real);
    //echo "real: ".$cenax."";
    $cenax = str_replace("Kč", "", $cenax);
    $cenax = str_replace(" ", "", $cenax);
    $cenax = str_replace("<strong>", "", $cenax);
    $cenax = preg_replace('/\D/', '', $cenax);
    $cena = (int)$cenax;
    $cena = (21*$cena/100)+$cena;
    $del='Energetická efektivita:';

    //přidělování bodů za certifikaci
    $content = file_get_contents($_POST["nazev"]);
    $del = "80 PLUS GOLD";
        if (strpos($content, $del) !== false){
            $certt = 4;
	        $content = str_replace($content, "", $content);
        }
    $del = "80 Plus Gold";
        if (strpos($content, $del) !== false){
            $certt = 4;
	        $content = str_replace($content, "", $content);
    }
    $del = "80 PLUS BRONZE";
        if (strpos($content, $del) !== false){
            $certt = 2;
            $content = str_replace($content, "", $content);
        }
    $del = "80PLUS BRONZE";
    if (strpos($content, $del) !== false){
        $certt = 2;
        $content = str_replace($content, "", $content);
    }
    $del = "80 Plus Bronze";
    if (strpos($content, $del) !== false){
        $certt = 2;
	    $content = str_replace($content, "", $content);
    }
    $del = "80 PLUS SILVER";
    if (strpos($content, $del) !== false){
        $certt = 3;
	    $content = str_replace($content, "", $content);
    }
    $del = "80 Plus Silver";
    if (strpos($content, $del) !== false){
        $certt = 3;
        $content = str_replace($content, "", $content);
    }
    $del = "80PLUS SILVER";
    if (strpos($content, $del) !== false){
        $certt = 3;
        $content = str_replace($content, "", $content);
    }
    $del = "80 PLUS TITANIUM";
    if (strpos($content, $del) !== false){
        $certt = 6;
        $content = str_replace($content, "", $content);
    }
    $del = "80 Plus Titanium";
    if (strpos($content, $del) !== false){
        $certt = 6;
        $content = str_replace($content, "", $content);
    }
    $del = "80Plus Titanium";
    if (strpos($content, $del) !== false){
        $certt = 6;
        $content = str_replace($content, "", $content);
    }
    $del = "80 PLUS PLATINUM";
    if (strpos($content, $del) !== false){
        $certt = 5;
        $content = str_replace($content, "", $content);
    }
    $del = "80 Plus Platinum";
    if (strpos($content, $del) !== false){
        $certt = 5;
        $content = str_replace($content, "", $content);
    }
    $del = "80Plus Platinum";
    if (strpos($content, $del) !== false){
        $certt = 5;
        $content = str_replace($content, "", $content);
    }
    $del = "80 PLUS";
    if (strpos($content, $del) !== false){
        $certt = 1;
        $content = str_replace($content, "", $content);
    }
    $del = "80PLUS";
   if (strpos($content, $del) !== false){
       $certt = 1;
    	$content = str_replace($content, "", $content);
    }
    $del = "80 Plus";
   if (strpos($content, $del) !== false){
        $certt = 1;
	    $content = str_replace($content, "", $content);
    }
    if (empty($certt)){
	    $certt = 0;
    }

    $zaruka = (int)$zaruka;
    if ($cena == 0){
	     $CWNotset = true;
    }
    else{
        CW($cena,$kapacita);
    }
    echo "<h1>Název zdroje: ".$nazevc."</p></h1>";
    echo "Body za záruku: ".$GLOBALS['bodyzaruka']."/10</p>";
    if ($CWNotset == true){
        echo "<b>Neznámá cena! Nelze udělit body za cenu za watt!</b></p>";
    }
    else{
        echo "Cena za watt: " .$GLOBALS['cenazawatt']." kč</p>";
    }
    echo "Body za certifikaci: ".$certt."/6</p>";
    echo "Body za model: ".$bodymodel."/10</p>";

    $vysledek = $bodymodel+$GLOBALS['certifikacebody']+$GLOBALS['kapacitabody']+$GLOBALS['bodycw']+$GLOBALS['bodyzaruka']+$certt;
    vysledek($vysledek);
    echo "Celkem: ".$vysledek."</p>";
	$sql = "select * from pocet where nazev='".$nazevc."'";
    $conn = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
	$pocetnotnull = false;
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
	    $pocetnotnull = true;
	    $pocet = $row["pocet"];
    	 $pocet = $pocet+1;
    	 $sql = "update pocet set pocet=".$pocet.", cenacca=".$cena.", cert=".$certt." where nazev='".$nazevc."'";
    }

	if ($pocetnotnull != true){
		$pocet = 1;
		$sql = "insert into pocet (nazev, pocet, celkem, cenacca, cert) values ('".$nazevc."', ".$pocet.", ".$vysledek.", ".$cena.", ".$certt.")";
	}

	$conn = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
    $result = $conn->query($sql);
    $pocet = $pocet+1;
    }
}

//funkce na výpočet ceny za watt a přidělení bodů
function CW($cena,$kapacita){
    $cenawatt = $cena/$kapacita;
    $GLOBALS['cenazawatt'] = $cenawatt;
    if ($cenawatt > 8){
	 	 $GLOBALS['bodycw'] = 10;
    }
 
    else if ($cenawatt <8  && $cenawatt > 7.2){
		 $GLOBALS['bodycw'] = 9;
		 $cenawatt = 0;
    }
    else if ($cenawatt <7.3  && $cenawatt > 6.7){
		 $GLOBALS['bodycw'] = 8;
         $cenawatt = 0;
    }
    else if ($cenawatt <6.8  && $cenawatt > 6){
		 $GLOBALS['bodycw'] = 7;
         $cenawatt = 0;
    }
    else if ($cenawatt <6.1 && $cenawatt > 5.4){
		 $GLOBALS['bodycw'] = 6;
         $cenawatt = 0;
    }
    else if ($cenawatt <5.5  && $cenawatt > 4.2){
		 $GLOBALS['bodycw'] = 5;
         $cenawatt = 0;
    }
    else if ($cenawatt <4.3  && $cenawatt > 3){
		 $GLOBALS['bodycw'] = 4;
         $cenawatt = 0;
    }
    else if ($cenawatt <3.1 && $cenawatt > 2.7){
		 $GLOBALS['bodycw'] = 3;
         $cenawatt = 0;
      }
    else if ($cenawatt <2.8 && $cenawatt > 2){
          $GLOBALS['bodycw'] = 2;
        $cenawatt = 0;
    }
    else{
	 	$GLOBALS['bodycw'] = 1;
 }


 

}
//funkce na přidělení bodů za záruku
function bodyzaruka($zaruka){
		if ($zaruka == 1){
		 $GLOBALS['bodyzaruka'] = 1;
		 $zaruka = NULL;
	}
    	 else if ($zaruka == 2){
		 $GLOBALS['bodyzaruka'] = 2;
		 		 $zaruka = NULL;
	}
		  else  if ($zaruka == 3){
		 $GLOBALS['bodyzaruka'] = 3;
		 		 $zaruka = NULL;
	}
		  else  if ($zaruka == 4){
		 $GLOBALS['bodyzaruka'] = 4;
		 $zaruka = NULL;
	}
		else if ($zaruka == 5){
		 $GLOBALS['bodyzaruka'] = 5;
		 $zaruka = NULL;
	}
		  else  if ($zaruka == 6){
		 $GLOBALS['bodyzaruka'] = 5;
		 $zaruka = NULL;
	}
	   else if ($zaruka == 7){
		 $GLOBALS['bodyzaruka'] = 7;
		 $zaruka = NULL;
	}
		else if ($zaruka == 8){
		 $GLOBALS['bodyzaruka'] = 8;
		 $zaruka = NULL;

	 }
		else if ($zaruka == 9){
		 $GLOBALS['bodyzaruka'] = 8;
		 $zaruka = NULL;

	 }
	 else if ($zaruka >9){
		 $GLOBALS['bodyzaruka'] = 10;
		 $zaruka = NULL;

	 }




}

///funkce na přidělení bodů za certifikaci
function bodycertifikace($certifikace){
	if ($certifikace == "BRONZE"){
		$GLOBALS['certifikacebody'] = 2;
       exit(0);

	}
	else if ($certifikace = "SILVER"){
		$GLOBALS['certifikacebody'] = 3;
	}
	else if ($certifikace == "GOLD"){
		$GLOBALS['certifikacebody'] = 4;
       exit(0);
	}
	else if ($certifikace == "PLATINUM"){
		$GLOBALS['certifikacebody'] = 5;
		       exit(0);
	}
	else if ($certifikace == "TITANIUM"){
		$GLOBALS['certifikacebody'] = 6;
		       exit(0);
	}
	else if ($certifikace == ""){
		$GLOBALS['certifikacebody'] = 0;
		       exit(0);
	}
	else if ($certifikace == "80 PLUS"){
		$GLOBALS['certifikacebody'] = 1;
       exit(0);

	}

	
}
///funkce na převedení zdroje na kategorii
function vysledek($vysledek){
	$vysledek = str_replace(10, "Risk", $vysledek);
	$vysledek = str_replace(11, "Podprůměr", $vysledek);
	$vysledek = str_replace(12, "Podprůměr", $vysledek);
	$vysledek = str_replace(13, "Podprůměr", $vysledek);
	$vysledek = str_replace(14, "Podprůměr", $vysledek);	
	$vysledek = str_replace(15, "Průměr", $vysledek);
	$vysledek = str_replace(16, "Průměr", $vysledek);
	$vysledek = str_replace(17, "Průměr", $vysledek);
	$vysledek = str_replace(18, "Průměr", $vysledek);
	$vysledek = str_replace(19, "Průměr", $vysledek);
	$vysledek = str_replace(20, "Průměr", $vysledek);
	$vysledek = str_replace(21, "Nadprůměr", $vysledek);
	$vysledek = str_replace(22, "Nadprůměr", $vysledek);
	$vysledek = str_replace(23, "Nadprůměr", $vysledek);
	$vysledek = str_replace(24, "Výborný", $vysledek);
	$vysledek = str_replace(25, "Výborný", $vysledek);
	$vysledek = str_replace(26, "Výborný", $vysledek);
	$vysledek = str_replace(27, "Výborný", $vysledek);
	$vysledek = str_replace(28, "Výborný", $vysledek);
	$vysledek = str_replace(29, "TOP", $vysledek);
	$vysledek = str_replace(30, "TOP", $vysledek);
	$vysledek = str_replace(31, "TOP", $vysledek);
	$vysledek = str_replace(32, "TOP", $vysledek);
	$vysledek = str_replace(33, "TOP", $vysledek);
	$vysledek = str_replace(34, "TOP", $vysledek);
	$vysledek = str_replace(35, "TOP", $vysledek);
	$vysledek = str_replace(36, "TOP", $vysledek);
	$vysledek = str_replace(1, "Odpad", $vysledek);
	$vysledek = str_replace(2, "Odpad", $vysledek);
	$vysledek = str_replace(3, "Odpad", $vysledek);
	$vysledek = str_replace(4, "Odpad", $vysledek);
	$vysledek = str_replace(5, "Odpad", $vysledek);
	$vysledek = str_replace(6, "Odpad", $vysledek);
	$vysledek = str_replace(7, "Risk", $vysledek);
	$vysledek = str_replace(8, "Risk", $vysledek);
	$vysledek = str_replace(9, "Risk", $vysledek);
	$vysledek = str_replace(0, "Odpad", $vysledek);
	echo "<h2>Hodnocení zdroje: ".$vysledek."</p></h2>";

}
//seznam nejlepších zdrojů
echo "<h1>Nejlepší zdroje</h1>";

$conn = new mysqli($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
$sql = "select * from komponenty.pocet order by celkem desc";
$result = $conn->query($sql);

$poradi = 0;
$stredni = false;
$strednis = false;
$unsafe = false;
$fuj = false;

echo "------------ TOP zdroje ------------</p>" ;
 while($row = $result->fetch_assoc()){
	  $poradi = $poradi+1;
	  $celkem  = (int)$row["celkem"];
      if ($celkem < 27){
          if ($stredni == false){
		     echo "------------  Vyšší střední třída --------</p>";
             $stredni = true;
          }
      }
      if ($celkem < 22){
			 if ($strednis == false){
	        	 echo "------------  Střední třída --------</p>";
	            $strednis = true;
		        }
	    }
      if ($celkem < 15){
          if ($lowend == false){
		        echo "------------  Low End--------</p>";
	            $lowend = true;
		    }
	    }
	 
      if ($celkem < 11){
          if ($unsafe == false){
		        echo "------------  Riskantní --------</p>";
	            $unsafe= true;
          }
	 }
	 
	 if ($celkem < 6){
		  if ($fuj == false){
		     echo "------------ !! VELICE NEBEZPEČNÉ !! --------</p>";
		    $fuj = true;
	    }
	 }
	 echo "".$poradi.". ".$row["nazev"]." - ".$row["celkem"]."</p>";
 }
