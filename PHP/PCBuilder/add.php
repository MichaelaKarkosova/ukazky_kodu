<!doctype html>
<head>
  <meta charset="utf-8">
  <title>Přidat komponentu</title>
</head>
<div style="display:none;"><endora></div>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<meta http-equiv="content-type" content="text/plain;" />
<script>
error_reporting(0);
@ini_set('display_errors', 0);
function clearform()
{
    document.getElementById("nazev").value="";
}
</script>
<script>
	function back(){
	 window.location.href = "https://89.203.248.183/"; 
}
</script>

<?php
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" rel="stylesheet"/>
<div class="page">
<?
  session_start;
  $jepridana = false;
    ini_set("allow_url_fopen", 1);
echo " </form><input type='submit'  class='button' name='zpet' value='Zpět' onClick='back();'></br>";


error_reporting(E_ALL);
     echo "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><div>
	 <form method='post' name='POST'/>
 Url z CZC: <input name='nazev' rows='5' cols='10'></textarea>
   <input type='submit' name='submit' value='Odeslat' onClick='clearform();'>";
    echo "<p>Můžeš přidat svůj hardware jednoduchým odesláním odkazu z czc. Náš systém si s ním poradí - rozezná, zda se jedná o ram, grafiku, procesor nebo základní desku a sebere o ní veškeré potřebné údaje. Pak se můžeš vrátit zpátky a přidat si ji do porovnání!";
if (isset($_POST["nazev"])){
if (strpos($_POST["nazev"], 'https://www.czc.cz/') !== false or strpos($_POST["nazev"], 'http://www.czc.cz/') !== false or strpos($_POST["nazev"], 'www.czc.cz/') !== false) {
  $czclink = true;
}
if ($czclink != true){
	echo "<script>alert('Musíš zadat link z czc!')</script>";
	
}
else{
$content = file_get_contents($_POST["nazev"]);
$typ = "";
if (strpos($content, 'Multimedialní grafické karty') !== false or strpos($content, 'třída grafických karet') !== false or strpos($content, 'Multimediální grafické karty') !== false or strpos($content, 'Herní špička grafických karet') !== false or strpos($content, 'Grafický čip') !== false) { //1
   $typ = "gpu";

}
if (strpos($content, 'Operační paměti') !== false and strpos($content, 'Typ grafické paměti:') == false ) { //1
   $typ = "ram";

}
if ($typ != "gpu"){
if (strpos($content, 'Kódové označení') !== false) {
	$typ = "cpu";
}
}

if ($typ != "cpu"){
if (strpos($content, 'Pro procesory') !== false) {
	$typ = "Základní deska";
}
}

if ($typ == "gpu"){
 getgpu(); 
}
if ($typ == "Základní deska"){
 getmb();
}
if ($typ == "cpu"){
 getcpu();
}
if ($typ == "ram"){
 getram();
}
}
}

//FUNKCEEEEEEEEEEEEEEEEEE ///////////////

function getgpu(){
	echo "<meta http-equiv='content-type' content='text/plain;' />";
		///
	$dbhost = '89.203.249.188';
$dbuser = '******';
$dbpass = '************';
$dbname = 'komponenty';
	
///
		$jepridana = false;
	
Echo "<h1>Získané informace</h1></p>";
echo "Typ: Grafická karta</p>";	
$content = file_get_contents($_POST["nazev"]);
$del="Power Board cca";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$tdp_tmp=substr($content, $pos+strlen($del)-11, $real);
$tdp_tmp= preg_replace('/\D/', '', $tdp_tmp);
$tdp = (int)$tdp_tmp;
if ($tdp == 0){
	echo "Neuvedeno - vloženo 250</p>";
	$tdp = 250;
}
else{
		echo "TDP: ".$tdp."</p>";
}
	$del="Standard sběrnice";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$pcie=substr($content, $pos+strlen($del)-11, $real);
$pcie= preg_replace('/\D/', '', $pcie);
$pcie = str_replace("0", ".0", $pcie);
echo "Verze PCI-E: ".$pcie."</p>";


	$del="Výrobce grafického čipu:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+1205;
$cip=substr($content, $pos+strlen($del)-15, $real);
$cip = preg_replace('/[^A-Za-z0-9\-]/', '', $cip);
$cip = str_replace("strong","",$cip);
$cip = str_replace("span", "" ,$cip);
if (strpos($cip, 'AMD') !== false) {
    $cip = "AMD";
}
if (strpos($cip, 'NVIDIA') !== false) {
    $cip = "NVIDIA";
}
if (strpos($cip, 'Nvidia') !== false) {
    $cip = "NVIDIA";
}
echo "Výrobce čipu: ".$cip."</p>";



	$del="Výrobce:";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$vyrobce =substr($content, $pos+strlen($del), $real);
$vyrobceset = false;
if (strpos($vyrobce, 'MSI') !== false) {
	$vyrobce = "MSI";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Zotac') !== false) {
	$vyrobce = "Zotac";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'GIGABYTE') !== false) {
	$vyrobce = "GIGABYTE";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'ASUS') !== false) {
	$vyrobce = "Asus";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'EVGA') !== false) {
	$vyrobce = "EVGA";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Gainward') !== false) {
	$vyrobce = "Gainward";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PALIT') !== false) {
	$vyrobce = "PALIT";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'ASRock') !== false) {
	$vyrobce = "ASRock";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'XFX') !== false) {
	$vyrobce = "XFX";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PNY') !== false) {
	$vyrobce = "PNY";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'HP') !== false) {
	$vyrobce = "HP";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Sapphire') !== false) {
	$vyrobce = "Saphirre";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'AMD') !== false) {
	$vyrobce = "AMD";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PALiT') !== false) {
	$vyrobce = "Palit";
	$vyrobceset = true;
}
if ($vyrobceset == true){
	echo "Výrobce: ".$vyrobce."</p>";
}
   else{
    echo "Výrobce: Neznamý</p>";
}


$del='title="Název produktu:"';
$pos=strpos($content, 'title="Název produktu:');
$real = strlen($content)-strlen($content)+150;
$nazev=substr($content, $pos+strlen($del), $real);
$nazevc = "";
for ($i = 0; $i < strlen($nazev); $i++){
	if ($nazev[$i] != '"' &&  $nazev[$i] != '+'){
		 $nazevc = "".$nazevc."".$nazev[$i]."";
	}
else{
	break;
}

}

	$del="Velikost grafické paměti [MB]:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+400;
$pamet=substr($content, $pos+strlen($del)-11, $real);
$pamet = preg_replace('/\D/', '', $pamet);
$pamet = str_replace("strong","",$pamet);
$pamet = str_replace("span", "" ,$pamet);
$pamet= (int)$pamet;
$pamet = $pamet/1024;

echo "Velikost paměti: " .$pamet." GB</p>";

	$del="Rychlost grafického čipu [MHz]:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+400;
$rychlostcip=substr($content, $pos+strlen($del)-11, $real);
$rychlostcip = preg_replace('/\D/', '', $rychlostcip);
$rychlostcip = str_replace("strong","",$rychlostcip);
$rychlostcip = str_replace("span", "" ,$rychlostcip);
$rychlostcip= (int)$rychlostcip;

echo "Rychlost čipu: " .$rychlostcip." MHZ</p>";

	$del="Typ grafické paměti:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$gddr=substr($content, $pos+strlen($del)-11, $real);
$gddr = preg_replace('/\D/', '', $gddr);
$gddr = str_replace("strong","",$gddr);
$gddr = str_replace("span", "" ,$gddr);
$gddr= (int)$gddr;

echo "Typ paměti: GDDR" .$gddr."</p>";
$nazevc = str_replace("- Použité zboží", "", $nazevc);
$nazevc = str_replace("- Rozbalené zboží", "", $nazevc);
echo "Název: ".$nazevc."";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.gpu where Nazev = '".$nazevc."'";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
	 if ( $jepridana != true){
	 echo "<script>alert('Graficka karta ".$nazevc." se již v databázi nachází!');</script>";
	 $jepridana = true;
	 break;
	 }
 }
if ($jepridana != true){
$sql = "insert into komponenty.gpu (Vyrobce,Nazev, rychlost_cip, pcie,gddr,pamet,TDP,cip,url) values ('".$vyrobce."','".$nazevc."',".$rychlostcip.",'".$pcie."',".$gddr.",".$pamet.",".$tdp.",'".$cip."','".$_POST["nazev"]."')";
echo "<script>alert('Graficka karta ".$nazevc." byla úspěšně přidána!');</script>";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {

	}
}

}

function getcpu(){
		echo "<meta http-equiv='content-type' content='text/plain;' />";
		///

///
Echo "<h1>Získané informace</h1></p>";
echo "Typ: Procesor</p>";	
	$jepridana = false;
	    $content = file_get_contents($_POST["nazev"]);
	 $del="Udává počet instrukcí, které dokáže čip vykonat za 1 sekundu. Všeobecně platí, čím vyšší frekvence, tým vyšší pracovní výkon";
$pos=strpos($content, $del); 
$real = strlen($content)-strlen($content)+250;
$frekvence_tmp=substr($content, $pos+strlen($del)-11, $real);
$value = strpos($tfrekvence_tmp, 'Technologie, která umožňuje jednotlivým jádrům procesoru běžet rychleji, než je jejich základní frekvence, za předpokladu, že to okolnosti (aktuální spotřeba jader nebo teplota) dovolují. Díky této technologii dochází ke zvýšení výkonu v jedno i více vláknových operacích') ;
$frekvence_tmp= preg_replace('/\D/', '', $frekvence_tmp);
$frekvence = (int)$frekvence_tmp; 
$del="Technologie, která umožňuje jednotlivým jádrům procesoru běžet rychleji, než je jejich základní frekvence, za předpokladu, že to okolnosti (aktuální spotřeba jader nebo teplota) dovolují. Díky této technologii dochází ke zvýšení výkonu v jedno i více vláknových operacích";
$pos=strpos($content, $del);
$frekvenceset = false;
$real = strlen($content)-strlen($content)+250;
$tfrekvence_tmp=substr($content, $pos+strlen($del), $real);
if (strpos($tfrekvence_tmp, '<strong>') !== false) {
$frekvenceset = true;
}
$tfrekvence_tmp= preg_replace('/\D/', '', $tfrekvence_tmp);
$tfrekvence = (int)$tfrekvence_tmp;
if ($frekvenceset != false) {
    echo "Frekvence: ".$frekvence." - ".$tfrekvence_tmp."</p>";
}
else{
	echo "Frekvence: ".$frekvence."</p>";
	$tfrekvence = 0;
}
$del="Max. TDP (Thermal Design Power) [W]:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$ttdp_tmp=substr($content, $pos+strlen($del), $real);
$ttdp_tmp= preg_replace('/\D/', '', $ttdp_tmp);
$ttdp = (int)$ttdp_tmp;
if ($ttdp != 0){
echo "TDP:".$ttdp." W</p>";
}
else{
	$del="Průměrné TDP (W)";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$ttdp_tmp=substr($content, $pos+strlen($del), $real);
$ttdp_tmp= preg_replace('/\D/', '', $ttdp_tmp);
$ttdp = (int)$ttdp_tmp;
echo "TDP:".$ttdp." W</p>";
}

$del="Jádro je základem každého procesoru a vypočítává veškeré úlohy. Pro nenáročné uživatele je vhodný procesor s jedním nebo dvěma jádry. Pro náročnější uživatele jsou vhodné dvě až čtyři jádra. Pokud často pracujete s videem, grafickými programy nebo sledujete filmy ve vysoké kvalitě a hrajete nejnovější herní tituly, volte procesory minimálně čtyřjádrové a více. Pro nejnáročnější aplikace nebo do serverů jsou vhodné procesory s 6 jádry a více.";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$jadra_tmp=substr($content, $pos+strlen($del), $real);
$jadra_tmp= preg_replace('/\D/', '', $jadra_tmp);
$jadra = (int)$jadra_tmp;
echo "Počet jader: ".$jadra."</p>";
$del="Procesory kromě jader pracují také s vlákny. To znamená, že jednojádrový procesor je schopen zpracovávat například dvě vlákna operací paralelně. Je tak maximálně zefektivněné paralelní zpracován dat u aplikací, které podporují zpracování více vláken.";
$pos=strpos($content, $del);
	
if (strpos($content, 'Počet vláken') !== false) {
$real = strlen($content)-strlen($content)+250;
	
$vlakna_tmp=substr($content, $pos+strlen($del), $real);
$vlakna_tmp= preg_replace('/\D/', '', $vlakna_tmp);
$vlakna = (int)$vlakna_tmp;
echo "Počet vláken: ".$vlakna."</p>";
}
else{
	$vlakna = $jadra;
echo "Počet vláken: ".$vlakna."</p>";
}
	$del="<span>Výrobce";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$cpu=substr($content, $pos+strlen($del)-11, $real);
$cpu = preg_replace('/[^A-Za-z0-9\-]/', '', $cpu);
if (strpos($cpu, 'AMD') !== false) {
	$cpu = "AMD";
}
if (strpos($cpu, 'Intel') !== false) {
	$cpu = "Intel";
}
echo "Výrobce: ".$cpu."</p>";

$del='title="Název produktu:"';
$pos=strpos($content, 'title="Název produktu: ');
$real = strlen($content)-strlen($content)+500;
$nazev=substr($content, $pos+strlen($del), $real);
$nazevc = "";
for ($i = 0; $i < strlen($nazev); $i++){
	if ($nazev[$i] != '"' &&  $nazev[$i] != '+' && $nazev[$i] != '"'){
		 $nazevc = "".$nazevc."".$nazev[$i]."";
	}
else{
	break;
}

}
echo "Název: ".$nazevc."</p>";

	$del="Integrované GPU";
$pos=strpos($content, $del);
$bool;
$real = strlen($content)-strlen($content)+150;
$igpu=substr($content, $pos+strlen($del)-15, $real);
$bool = strpos($igpu, 'rované GPU');
if ($bool == 4) {
	$igpu = "ANO";
}
else{
	$igpu = "NE";
}

echo "Integrovaná grafika: ".$igpu."</p>";


	$del="Patice:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$patice=substr($content, $pos+strlen($del), $real);
for ($i = 0; $i < strlen($patice); $i++){
	if ($patice[$i] != '/' &&  $patice[$i] != '/' && $patice[$i] != '/'){
		 $paticec = "".$paticec."".$patice[$i]."";

	}
else{
	break;
}
}
$paticec = str_replace("<strong>", "", $paticec);
$paticec = str_replace("<", "", $paticec);
$paticec = str_replace("LGA", "", $paticec);
$paticec = str_replace("Socket", "", $paticec);
$paticec = str_replace("socket", "", $paticec);
$paticec = str_replace(" ", "", $paticec);
echo "Patice: ".$paticec."</p>";

	$del="Podpora chipsetu:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+300;
$chipset=substr($content, $pos+strlen($del), $real);
if (strpos($content, 'Podpora chipsetu') !== false) {
for ($i = 0; $i < strlen($chipset); $i++){
	if ($chipset[$i] != '/' &&  $chipset[$i] != '/' && $chipset[$i] != '/'){
		$chipsetc = "".$chipsetc."".$chipset[$i]."";
     
	}
else{
	break;
}
}
$chipsetc = str_replace("<strong>", "", $chipsetc);
$chipsetc = str_replace("<", "", $chipsetc);
echo "Podporuje chipsety: " .$chipsetc."";
$chipsetc = str_replace("", "", $chipsetc);

}
else{
	$chipsetc = "";
}

$sql = "select * from komponenty.cpu where Nazev = '".$nazevc."'";

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$result = $conn->query($sql);
	
 while($row = $result->fetch_assoc()) {
	 if ( $jepridana != true){
	 echo "<script>alert('Procesor ".$nazevc." se již v databázi nachází!');</script>";
	 $jepridana = true;
	 break;
	 }
 }
 if ( $jepridana != true){
	 $paticec = preg_replace("/[\n\r]/","",$paticec); 
$sql = "insert into komponenty.cpu (Vyrobce, Nazev, Patice, chipsety, igpu, TDP, jadra, vlakna, frekvence, turbo, url) values ('".$cpu."', '".$nazevc."', '".$paticec."', '".$chipsetc."', '".$igpu."', ".$ttdp.", ".$jadra.",".$vlakna.", ".$frekvence.", ".$tfrekvence.",'".$_POST["nazev"]."')";
	 $result = $conn->query($sql);
	 echo "<script>alert('Procesor ".$nazevc." byl úspěšně přidán do databáze!');</script>";
}
}

function getmb(){
			///
				echo "<meta http-equiv='content-type' content='text/plain;' />";

///
		$jepridana = false;
	
Echo "<h1>Získané informace</h1></p>";
echo "Typ: Základní deska</p>";	
$content = file_get_contents($_POST["nazev"]);
$del="Maximální frekvence operační paměti [MHz]:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$rammax_tmp=substr($content, $pos+strlen($del)-11, $real);
$rammax_tmp= preg_replace('/\D/', '', $rammax_tmp);
$rammax = (int)$rammax_tmp;
echo "Max frekvence RAM: ".$rammax."</p>";
$del="Počet paměťových slotů:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$ramsloty=substr($content, $pos+strlen($del), $real);
$ramsloty= preg_replace('/\D/', '', $ramsloty);
$ramsloty = str_replace("0", ".0", $ramsloty);
echo "Počet ram slotů: ".$ramsloty."</p>";
$del="Pro procesory";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+125;
$cpu=substr($content, $pos+strlen($del)+30, $real);
$cpu = preg_replace('/[^A-Za-z0-9\-]/', '', $cpu);
$cpu = str_replace("strong","",$cpu);
$cpu = str_replace("span", "" ,$cpu);
if (strpos($cpu, 'AMD') !== false) {
    $cpu = "AMD";
}
if (strpos($cpu, 'Intel') !== false) {
    $cpu = "Intel";
}
echo "Pro procesory: ".$cpu."</p>";



	$del="Výrobce:";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$vyrobce =substr($content, $pos+strlen($del)-11, $real);
$vyrobceset = false;
if (strpos($vyrobce, 'MSI') !== false) {
	$vyrobce = "MSI";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Zotac') !== false) {
	$vyrobce = "Zotac";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'GIGABYTE') !== false) {
	$vyrobce = "GIGABYTE";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'ASUS') !== false) {
	$vyrobce = "Asus";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'EVGA') !== false) {
	$vyrobce = "EVGA";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Gainward') !== false) {
	$vyrobce = "Gainward";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PALIT') !== false) {
	$vyrobce = "PALIT";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'ASRock') !== false) {
	$vyrobce = "ASRock";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'XFX') !== false) {
	$vyrobce = "XFX";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PNY') !== false) {
	$vyrobce = "PNY";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'HP') !== false) {
	$vyrobce = "HP";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'Sapphire') !== false) {
	$vyrobce = "Saphirre";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'AMD') !== false) {
	$vyrobce = "AMD";
	$vyrobceset = true;
}
if (strpos($vyrobce, 'PALiT') !== false) {
	$vyrobce = "Palit";
	$vyrobceset = true;
}
if ($vyrobceset == true){
	echo "Výrobce: ".$vyrobce."</p>";
}
   else{
    echo "Výrobce: Neznamý</p>";
}

if (strpos($content, 'M.2 PCI-E') !== false) {
	$mam2 = "ANO";
	
}
else{
		$mam2 = "NE";
}
echo "M.2: " .$mam2."</p>";
	$del="Patice:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$patice=substr($content, $pos+strlen($del), $real);
for ($i = 0; $i < strlen($patice); $i++){
	if ($patice[$i] != '/' &&  $patice[$i] != '/' && $patice[$i] != '/'){
		 $paticec = "".$paticec."".$patice[$i]."";

	}
else{
	break;
}
}
$paticec = str_replace("<strong>", "", $paticec);
$paticec = str_replace("<", "", $paticec);
$paticec = str_replace("LGA", "", $paticec);
$paticec = str_replace("Socket", "", $paticec);
$paticec = str_replace("socket", "", $paticec);
$paticec = str_replace(" ", "", $paticec);
echo "Patice: ".$paticec."</p>";
	$del="Typ paměti:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$ddr =substr($content, $pos+strlen($del), $real);

for ($i = 0; $i < strlen($ddr); $i++){
	if ($ddr[$i] != '/' &&  $ddr[$i] != '/' && $ddr[$i] != '/'){
		 $ddrc = "".$ddrc."".$ddr[$i]."";

	}
else{
	break;
}
}
$ddrc = str_replace("<strong>", "", $ddrc);
$ddrc = str_replace("<", "", $ddrc);
$ddrc= preg_replace('/\D/', '', $ddrc);
$ddrc = (int)$ddrc;
echo "DDR:" .$ddrc."</p>";
	$del="Čipová sada:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$chipset =substr($content, $pos+strlen($del), $real);

for ($i = 0; $i < strlen($chipset); $i++){
	if ($chipset[$i] != '/' &&  $chipset[$i] != '/' && $chipset[$i] != '/'){
		 $chipsetc = "".$chipsetc."".$chipset[$i]."";

	}
else{
	break;
}
}
$chipsetc = str_replace("</strong>", "", $chipsetc);
$chipsetc = str_replace("<strong>", "", $chipsetc);
$chipsetc = str_replace("<", "", $chipsetc);
$chipsetc = str_replace("  ", "", $chipsetc);
echo "Chipset:" .$chipsetc."</p>";

	$del="Maximální velikost paměti [GB]:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$maxram =substr($content, $pos+strlen($del), $real);

for ($i = 0; $i < strlen($maxram); $i++){
	if ($maxram[$i] != '/' &&  $maxram[$i] != '/' && $maxram[$i] != '/'){
		 $maxramc = "".$maxramc."".$maxram[$i]."";

	}
else{
	break;
}
}
$maxramc = str_replace("<strong>", "", $maxramc);
$maxramc = str_replace("<", "", $maxramc);
$maxramc= preg_replace('/\D/', '', $maxramc);
$maxramc = (int)$maxramc;
echo "Maximální počet RAM:" .$maxramc. " GB</p>";
	$del="Formát základní desky:</span>";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$format =substr($content, $pos+strlen($del), $real);
$format = str_replace("<strong>", "", $format);
for ($i = 0; $i < strlen($format); $i++){
	if ($format[$i] != '<' &&  $format[$i] != '/' && $format[$i] != '/'){
		 $formatd = "".$formatd."".$format[$i]."";
	}
else{
	break;
}
}
echo "Formát základní desky:".$formatd."</p>";
	$del="Maximální frekvence operační paměti [MHz]:";
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$rammaxfrekv =substr($content, $pos+strlen($del), $real);
$rammaxfrekv = str_replace("<strong>", "", $rammaxfrekv);
$rammaxfrekv = str_replace("<", "", $rammaxfrekv);
$rammaxfrekv= preg_replace('/\D/', '', $rammaxfrekv);
$rammaxfrekv = (int)$rammaxfrekv;
echo "Maximální frekvence RAM: " .$rammaxfrekv. "MHZ</p>";	$del="Standard sběrnice";
if (strpos($content, 'PCI-E 3.x:') !== false) {
  echo "Verze PCI-E: 3.0</p>";
  $pcie = "3.0</p>";
}
else{
	  echo "Verze PCI-E: 2.0</p>";
	    $pcie = "2.0</p>";
}
$del='title="Název produktu: ';
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$nazev =substr($content, $pos+strlen($del), $real);
for ($i = 0; $i < strlen($nazev); $i++){
	if ($nazev[$i] != '"' &&  $nazev[$i] != '+' && $nazev[$i] != '"'){
		 $nazevc = "".$nazevc."".$nazev[$i]."";
	}
else{
	break;
}
}
$nazevc = str_replace("- Použité zboží", "", $nazevc);
$nazevc = str_replace("- Rozbalené zboží", "", $nazevc);
echo "Název:" .$nazevc."</p>";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.board where Nazev = '".$nazevc."'";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
	 if ( $jepridana != true){
	 echo "<script>alert('Základní deska ".$nazevc." se již v databázi nachází!');</script>";
	 $jepridana = true;
	 break;
	 }
 }

if ($jepridana != true){
	  if (strpos($content, 'Pro procesory') !== false) {
		$cpu = str_replace(" ", "", $cpu);
		$cpu = str_replace(" ", "", $cpu);
		$formatd = str_replace(" ", "", $formatd);
      $chipsetc = preg_replace('/\s+/', '', $chipsetc);
$paticec=  preg_replace('/\s+/', '', $paticec); 	  
$sql = "insert into komponenty.board (Vyrobce, cpu, Nazev, patice, chipset, ramsloty, ddr,ramspeed,pcie,format,maxram,M2,url) values ('".$vyrobce."', '".$cpu."', '".$nazevc."', '".$paticec."', '".$chipsetc."', ".$ramsloty.", ".$ddrc.",".$rammaxfrekv.", '".$pcie."', '".$formatd."', ".$maxramc.", '".$mam2."',  '".$_POST["nazev"]."')";
echo "<script>alert('Základní deska ".$nazevc." byla úspěšně přidána!');</script>";
$result = $conn->query($sql);
	  }
	 

}




} //KONEC FCE!!!

function getram(){
		echo "<meta http-equiv='content-type' content='text/plain;' />";
		///
///
Echo "<h1>Získané informace</h1></p>";
echo "Typ: Operační paměť</p>";	
	$jepridana = false;
	    $content = file_get_contents($_POST["nazev"]);
$del="Pracovní frekvence [MHz]:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$frekvence_tmp=substr($content, $pos+strlen($del)-11, $real);
$frekvence_tmp= preg_replace('/\D/', '', $frekvence_tmp);
$frekvence = (int)$frekvence_tmp;
echo "Frekvence RAM: ".$frekvence." MHZ</p>";
$del="Počet modulů RAM:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$moduly_tmp=substr($content, $pos+strlen($del)-11, $real);
$moduly_tmp= preg_replace('/\D/', '', $moduly_tmp);
$moduly = (int)$moduly_tmp;
echo "Počet modulů: ".$moduly."</p>";

$del="Celková kapacita paměti [GB]:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$kapacita_tmp=substr($content, $pos+strlen($del)-11, $real);
$kapacita_tmp= preg_replace('/\D/', '', $kapacita_tmp);
$kapacita = (int)$kapacita_tmp;
echo "Celková kapacita: ".$kapacita." GB </p>";

$del="Typ paměti:";
$pos=strpos($content, $del);
$real = strlen($content)-strlen($content)+250;
$DDR_tmp=substr($content, $pos+strlen($del)-11, $real);
$DDR_tmp= preg_replace('/\D/', '', $DDR_tmp);
$DDR = (int)$DDR_tmp;
echo "DDR: ".$DDR."</p>";
$del='title="Název produktu: ';
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$nazev =substr($content, $pos+strlen($del), $real);
for ($i = 0; $i < strlen($nazev); $i++){
	if ($nazev[$i] != '"' &&  $nazev[$i] != '+' && $nazev[$i] != '"'){
		 $nazevc = "".$nazevc."".$nazev[$i]."";
	}
else{
	break;
}
}
$nazevc = str_replace("- Použité zboží", "", $nazevc);
$nazevc = str_replace("- Rozbalené zboží", "", $nazevc);
echo "Název:" .$nazevc."</p>";

$del='title="Název produktu: ';
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+150;
$vyrobce =substr($content, $pos+strlen($del), $real);
for ($i = 0; $i < strlen($vyrobce); $i++){
	if ($vyrobce[$i] != '"' &&  $vyrobce[$i] != ' ' && $vyrobce[$i] != ','){
		 $vyrobcec = "".$vyrobcec."".$vyrobce[$i]."";
	}
else{
	break;
}
}
$vyrobcec = str_replace("- Použité zboží", "", $vyrobcec);
$vyrobcec = str_replace("- Rozbalené zboží", "", $vyrobcec);
echo "Výrobce:" .$vyrobcec."</p>";

$del='Využití paměti:';
$pos=strpos($content, $del);

$real = strlen($content)-strlen($content)+180;
$sodimm =substr($content, $pos+strlen($del), $real);
if (strpos($sodimm, 'PC') !== false) {
	$urceno = "PC";
	$sodimm = "NE";
	
}
else{
	$urceno = "Notebook";
		$sodimm = "ANO";
}	
echo "Určeno pro: ".$urceno."";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$sql = "select * from komponenty.ram where Nazev = '".$nazevc."'";
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
	 if ( $jepridana != true){
	 echo "<script>alert('RAM ".$nazevc." se již v databázi nachází!');</script>";
	 $jepridana = true;
	 break;
	 }
 }

if ($jepridana != true){		$cpu = str_replace(" ", "", $cpu);
		$cpu = str_replace(" ", "", $cpu);
		$formatd = str_replace(" ", "", $formatd);
$sql = "insert into komponenty.ram (frekvence, Nazev, DDR, vyrobce,sodim,kusy,pocet,url) values (".$frekvence.", '".$nazevc."', ".$DDR.", '".$vyrobcec."', '".$sodimm."', ".$moduly.", ".$kapacita.",  '".$_POST["nazev"]."')";
//header('location: index.php'); 
$result = $conn->query($sql);
	  }
	 

}
