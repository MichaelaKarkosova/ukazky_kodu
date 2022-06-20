<head> 
<meta charset="utf-8"><link rel="stylesheet" type="text/css" href="css/styles.css">
<div style="display:none;"><endora></div>
</head>
<?
session_start();
$_SESSION["pridat"] = null;
$dbhost = '89.203.249.188';
$dbuser = '******';
$dbpass = '**********';
$dbname = 'komponenty';
$poradi = 0;
$vysledky = array();
$vysledkyurl = array();
$vysledkyvyrobce = array("");
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$hodnota = $_GET['specify2'];
$replace = "'";
$hodnota = str_replace(';', '', $hodnota);
$hodnota = str_replace(',', '', $hodnota);
$hodnota = str_replace('(', '', $hodnota);
$hodnota = str_replace(')', '', $hodnota);
$hodnota = str_replace($replace, '', $hodnota);

$sql = "select Nazev from komponenty.".$_GET['type']." where Nazev like '%".$hodnota."%'";

$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		array_push($vysledky, $row["Nazev"]);
		array_push($vysledkyvyrobce, $row["vyrobce"]);
	}
$sql = "select url,Nazev from komponenty.".$_GET['type']." where Nazev like '%".$hodnota."%'";

$result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
		array_push($vysledkyurl, $row["url"]);
	}
    echo "<br>";
    echo "<br>";
$_SESSION["type"]= $_GET['type'];
echo $_SESSION["type"];
echo "<div class='table'>";
echo "<table border='1' style='width:auto'>";
echo "<div class='nadpis'><th>Info</th></div>";
echo "<div class='nadpis'><th>Nazev".$_SESSION["type"]."</th></div>";
echo "<th></th>";
for ($i = 0; $i < count($vysledky); $i++) {
	echo "<tr><td><form action='$vysledkyurl[$i]' method='get' target='_blank'><input type='submit' value='Info' name='Submit'></form>";
	echo "<td>".$vysledky[$i]."</td>";
echo "<td><form method='POST'><input class='inputtabulka' type='hidden' name='vyber' value='$vysledky[$i]'><input type='submit' value='Přidat k porovnání' href='http://lupework.eu/PCC/'></form></td>";
}

