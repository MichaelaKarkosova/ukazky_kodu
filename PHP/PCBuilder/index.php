<!doctype html>
<head>
  <meta charset="utf-8">
  <title>Kontrola kompatibility</title>
</head>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="jquery.confirm/jquery.confirm.css" />
<meta charset="utf-8"><link rel="stylesheet" type="text/css" href="css/styles.css">

<?


error_reporting(0);
session_start();
$_SESSION["frekvenceramek"] = 0;
$set = false; 
$frekvencemax = 0;
$potvrzeno = false;
$_SESSION["deska"] = 0;
?><script>
function zdroje()
{
var ahoj = "";
   window.location.href = "https://89.203.248.183/spotreba.php";
}
function zdrojhodnoceni()
{
   window.location.href = "https://89.203.248.183/rate.php";
}
function show(str, type) {
 var xhttp;
 if (str == '') {
    document.getElementById('specify2').innerHTML = '';
   return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
 console.log(this.responseText+' '+this.readyState+' '+this.status);
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById('specify').innerHTML = this.responseText;
    }
  }
;
	
xhttp.open('GET', 'naseptavac.php?type='+type+'&specify2='+str, true);
  xhttp.send();
}
</script>
<html>
  </head>
  <body>
    <a href="add.php" class="button">Přidat komponentu</a>
       </form>
    <input type='submit' name='jj' class='button' value='Hodnocení zdroje' onClick='zdrojhodnoceni();'>
</p><form method='get' name='specify2' style='width:auto;display:block;'><b><big><p class='polozky' align="right">Tvoje položky</b></p><div class ="items"></big></form>

<?

if (isset($_POST["vyber"])){
	  $_SESSION["pridat"] = $_POST["vyber"];
}     
	$_SESSION["chipsecompatt"] = false;
$dbhost = '89.203.249.188';
$dbuser = 'admin';
$dbpass = '*********';
$dbname = 'komponenty';
$potvrzeno = false;
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where id ='".$_SESSION["id"]."'";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		echo "".$row["polozka"]."</p>";
	}
	echo "<a href='clear.php'>Vyčistit</a>";
	echo "</div>";
echo "<p>&nbsp;</p> <p>&nbsp;</p> ";
?></div>Deska: <input type="text" name="specify2" style='width:auto;display:block' class='input' oninput="show(this.value,'board')"></input></p>Procesor: <input type="text" name="specify2" class='input' style='width:auto;display:block' oninput="show(this.value,'cpu')"></input></p>Grafická karta: <input class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'gpu')"></input></p>RAM: <input  class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'ram')"></input></form><div id="specify"></p>
<?$conn = new mysqli($dbhost,
					 $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='cpu')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select patice, TDP from komponenty.cpu where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$patice=$row["patice"];
		$_SESSION["cputdp"]=$row["TDP"];
	}
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='cpu')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select TDP from komponenty.cpu where Nazev ='".$name."'";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$tdp=$row["TDP"];
	}
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='cpu')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select chipsety from komponenty.cpu where (Nazev ='".$name."')";
$result = $conn->query($sql);
$_SESSION["cpu"] = $name;
$_SESSION["chipsety"] = "";
    while($row = $result->fetch_assoc()) {
		$pole=$row["chipsety"];
		$pole = str_replace(" ", "", $pole);
		$pole = str_replace(",", "", $pole);
		$pole = str_replace("chipset","", $pole); 
		$potvrzeno = true;
		
        $_SESSION["chipsety"] = "".$_SESSION["chipsety"]."".$pole."";
		
	}

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='board')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select patice from komponenty.board where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$paticeboard=$row["patice"];
	}
$sql = "select format from komponenty.board where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$format=$row["format"];
	}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select TDP from komponenty.cpu where Nazev ='".$name."'";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$tdp=$row["TDP"];
	}
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select pcie from komponenty.board where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$pcieboard=$row["pcie"];
	}
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='gpu')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$sql = "select pcie,TDP from komponenty.gpu where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$pciegpu=$row["pcie"];
		$_SESSION["gputdp"]=$row["TDP"];
	}
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select chipset from komponenty.board where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$_SESSION["chipset"]=$row["chipset"];
	}
     $_SESSION["chipset"] = str_replace(" ", "", $_SESSION["chipset"]);
$sql = "select ramspeed from komponenty.board where Nazev ='".$name."'";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$frekvencemax=$row["ramspeed"];

	}
if (strpos($_SESSION["chipsety"], $_SESSION["chipset"]) !== false) {
	$_SESSION["chipsecompatt"] = true;
}
$sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."') and (type='board')";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$set = true;
}
 	if (isset($_SESSION["chipset"]) and $_SESSION["chipset"] != null and isset($_SESSION["chipsety"]) and $potvrzeno == true and $set == true){

		if ($_SESSION["chipsecompatt"]!=true){
			?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      draggable: false,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "https://89.203.248.183/clearmb/"; 
        },
        "Odstranit procesor": function() {
          window.location.href = "https://89.203.248.183/clearcpu/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
<?
  if (isset($_SESSION["cpu"])){
echo "<div id='dialog-confirm' title='Zjištěna nekompatibilita!'>";
  echo "<p><span class='ui-icon ui-icon-alert' style='float:left; margin:12px 12px 20px 0;'></span>Chipset procesoru není kompatibilní s deskou. Co si přeješ odstranit?</p>";
echo "</div>";
 
  } 

		}
	}
		
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='ram')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$sql = "select DDR from komponenty.ram where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$ddr=$row["DDR"];
	}
$sql = "select kusy from komponenty.ram where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$sloty=$row["kusy"];
	}
$sql = "select frekvence from komponenty.ram where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$frekvence=$row["frekvence"];
		$_SESSION["frekvenceramek"] = $frekvence;
	}
   if ($_SESSION["frekvenceramek"] != 0){
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='ram')";
$result = $conn->query($sql);
   while($row = $result->fetch_assoc()) {
	   $_SESSION["nazevramek"] = $row["polozka"];
   }
   
$sql = "select * from komponenty.ram where nazev ='". $_SESSION["nazevramek"]."'"; 
$result = $conn->query($sql);
   while($row = $result->fetch_assoc()) {
	   $_SESSION["frekvenceramek"] = $row["frekvence"];
   }
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='board')";
$result = $conn->query($sql);
   while($row = $result->fetch_assoc()) {
	   $_SESSION["deska"] = $row["polozka"];
   }
   $sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='ram')";
   $result = $conn->query($sql);
   while($row = $result->fetch_assoc()) {
	  $nazev = $row["polozka"];
   }
   $sql = "select * from komponenty.ram where Nazev='".$nazev."'";
   $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
	  $afrekvenceram= $row["frekvence"];
   }
      $sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='board')";
   $result = $conn->query($sql);
   while($row = $result->fetch_assoc()) {
	  $nazev = $row["polozka"];
   }
      $sql = "select * from komponenty.board where Nazev='".$nazev."'";
	  $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
	  $afrekvenceboard= $row["ramspeed"];
   }

  if ($afrekvenceram > $afrekvenceboard){
	 if ($_SESSION["ignoreram"] != true){
		 if ($frekvencemax != 0){
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      draggable: false,
      height: "auto",
      width: 460,
      modal: true,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "clearmb/"; 
        },
        "ignorovat": function() {
          window.location.href = "ignoreram/"; 
        },
        "Odstranit RAM": function() {
          window.location.href = "clearram/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
 
<div id="dialog-confirm" title="Zjištěna nevhodná kombinace">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Tyto RAM mají větší rychlost než podporuje deska, je tedy možné, že pojedou na nižší frekvenci. Co si přeješ udělat?</p>
</div>
 

<?  
	  }
	 }
  }
   }
if (isset($paticeboard)){
	if (isset($patice)){
if ($paticeboard != $patice){
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      draggable: false,
      modal: true,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "clearmb/"; 
        },
        "Odstranit procesor": function() {
          window.location.href = "clearcpu/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
 <?
 if (isset($_SESSION["cpu"])){
echo "<div id='dialog-confirm' title='Zjištěna nekompatibilita!'>";
echo "  <p><span class='ui-icon ui-icon-alert' style='float:left; margin:12px 12px 20px 0;'></span>Procesor není kompatibilní s deskou. Co si přeješ odstranit?</p>";
echo "</div>";

 }

}
	}
}
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION["id"]."') and (type='gpu')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$name=$row["polozka"];
	}
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if (isset($pciegpu)){
	if (isset($pcieboard)){
if ($pciegpu != $pcieboard){
		if ($_SESSION["ignorovat"] != true){
	echo '
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 460,
      modal: true,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "clearmb/"; 
        },
        "Odstranit grafiku": function() {
          window.location.href = "cleargpu/"; 
        },
        "Ignorovat": function() {
          window.location.href = "ignore/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
 
<div id="dialog-confirm" title="Zjištěna nevhodná kombinace!">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Základní deska má nižší verzi PCI-E než grafická karta, tím může docházet ke zpomalení grafiky. Co si přeješ dělat?</p>
</div>';
 
		}

}
}
}
$sql = "select * from komponenty.vlozeno where (id ='".$_SESSION['id']."' and type='board')";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$name = $row["polozka"];
}

$sql = "select * from komponenty.board where (Nazev ='".$name."')";
$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		$ddrdeska=$row["ddr"];

	}

if (isset($ddrdeska)){
	if (isset($ddr)){
		if ($format == "Micro ATX"){
			$pocetslotu = 2;
		}
			if ($format == "ATX"){
			$pocetslotu = 4;
		}

		if ($ddrdeska != $ddr){
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      draggable: false,
      modal: true,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "clearmb/"; 
        },
        "Odstranit ramky": function() {
          window.location.href = "clearram/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
 
<div id="dialog-confirm" title="Zjištěna nekompatibilita!">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Tyto ram paměti nejsou kompatibilní, protože nesouhlasí DDR. Co si přeješ odstranit?</p>
</div>
 

<?
			}

	}
}

if (isset($tdpmax)){
	if (isset($tdp)){
if ($tdp > $tdpmax){
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      draggable: false,
      modal: true,
      buttons: {
        "Odstranit desku": function() {
          window.location.href = "clearmb/"; 
        },
        "Odstranit procesor": function() {
          window.location.href = "clearcpu/"; 
        }
      }
    });
  } );
  </script>
  </head>
<body>
 
<div id="dialog-confirm" title="Zjištěna nekompatibilita!">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Procesor není kompatibilní s deskou. Co si přeješ odstranit?</p>
</div>
 

<?
}
	}
	}


$sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."' and type='board')";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
		$_SESSION["mbtdp"] = 80; 
 }
$sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."' and type='ram')";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
		$_SESSION["nameram"] = $row["polozka"];
 }
 $sql = "select * from komponenty.ram where nazev='".$_SESSION["nameram"]."'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
		$_SESSION["ddrram"] = $row["DDR"];
 }
   if ($_SESSION["ddrram"] == 3){
	   $_SESSION["ramtdp"] = 6;
   }
    if ($_SESSION["ddrram"] == 4){
	   $_SESSION["ramtdp"] = 9;
   }
   if (!isset($frekvence)){
	   $_SESSION["ramtdp"] = 0;
   }
	$_SESSION["celkovetdp"] = $_SESSION["gputdp"]+$_SESSION["cputdp"]+$_SESSION["mbtdp"]+$_SESSION["ramtdp"];
	echo "Max spotřeba:<p><div class='spotreba'>".$_SESSION['celkovetdp']." W</div><form method='get'>
	 <input type='submit' name='submit' value='Další informace' onClick='zdroje();'>
";

if ($_SESSION["pridat"]!=NULL){

	if (isset($_SESSION["id"])){
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."' and type='".$_SESSION["type"]."')";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
	 $typ = $row["polozka"];
 }
 if (isset($typ)){
	 $sql = "update komponenty.vlozeno set polozka='".$_SESSION["pridat"]."' where type='".$_SESSION["type"]."'";
	  }
	else{
$sql = "insert into komponenty.vlozeno (id, polozka, type) values ('".$_SESSION["id"]."', '".$_SESSION["pridat"]."', '".$_SESSION["type"]."')";
	}
$result = $conn->query($sql);
	header ('Location: https://89.203.248.183');
$_SESSION["pridat"] = null;
$_SESSION["type"] = null;
$_POST["vyber"]=NULL;
}
else{
	function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0;
 $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
}
echo "</div>";
	$_SESSION["id"] = generateRandomString();
	$_SESSION["ignorovat"] = false;
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "insert into komponenty.vlozeno (id, polozka, type) values ('".$_SESSION["id"]."', '".$_SESSION["pridat"]."','".$_SESSION["type"]."')";
header ('Location: https://89.203.248.183');
$result = $conn->query($sql);
	$_SESSION["pridat"] = null;

}
  $_POST["vyber"] = null;
  $_SESSION["type"] = null;
  $_GET["type"] = null;
?>
