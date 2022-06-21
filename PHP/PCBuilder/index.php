
<?php

final class ErrorMessageBox
{
    private static ?string $message = NULL;

    public static function get(): ?string
    {
        return self::$message;
    }

    public static function set(?string $message): void
    {
        self::$message = $message;

    }
    public static function ThrowError($nadpis, $text, $remove1, $remove2, $url, $url2, $ignore) : void{
                echo '<script>';

                echo '$( function() {';
                echo '$( "#dialog-confirm" ).dialog({';
                echo 'resizable: false,';
                echo 'draggable: false,';
                echo 'height: "auto",';
                echo 'width: 460,';
                echo 'modal: true,';
                echo "buttons: {";
                echo '"Odstranit '.$remove1.'": function() { ';

                echo 'window.location.href = "'.$url.'"';

                echo "},";
                if ($ignore != ""){
                    echo '"ignorovat": function() {';

                    echo 'window.location.href = "ignoreram/";';
                    echo '},';
                }

                echo '"Odstranit '.$remove2.'": function() {';
                echo 'window.location.href = "'.$url2.'"';
                echo "}";

                echo "}";
                echo "});";
                echo "} );";
                echo "</script>";
                echo "</head>";
                echo "<body>";
                echo '<div id="dialog-confirm" title="'.$nadpis.'"';
                echo '<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0px 20px 20px 5px;"></span>'.$text.'</p>';
                echo '</div>';

            }

}

final class htmlHandler{

    public static function head(){
       echo '<head>
    <script src="js/errorBox.js"></script>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="jquery.confirm/jquery.confirm.css" />
<meta charset="utf-8"><link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/custom.js"></script>

  </head>
<a href="add.php" class="button">Přidat komponentu</a>
<input type="submit" name="jj" class="button" value="Hodnocení zdroje" onClick="zdrojhodnoceni();">
<br>';

    }
    public static function polozky(){
        $dbdriver = new DatabaseData();
        echo "<body>
       </form>
    </p><form method='get' name='specify2' style='width:auto;display:block;'></form><b><div class='polozky' align='right'>Tvoje položky</b><div class ='items'>";
        $dbdriver->getActive();
echo "</big></div></body>";
        echo "<a href='clear.php'>Vyčistit</a>";

}
    public static function GenerateSelector() :void{


        echo "</div>";
    echo "<p>&nbsp;</p> <p>&nbsp;</p> ";
    ?></div>Deska: <input type="text" name="specify2" style='width:auto;display:block' class='input' oninput="show(this.value,'board')"></input></p>Procesor: <input type="text" name="specify2" class='input' style='width:auto;display:block' oninput="show(this.value,'cpu')"></input></p>Grafická karta: <input class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'gpu')"></input></p>RAM: <input  class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'ram')"></input></form><div id="specify"></div></form></p>
    <?php
    }

    public static function powerconsumption(){
        $dbdata = new DatabaseData();
        $tdpgpu = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "TDP", "gpu");
        $tdpcpu =  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "TDP", "cpu");
    	$_SESSION["celkovetdp"] = $tdpcpu+$tdpgpu;
	    echo "Max spotřeba:<p><div class='spotreba'>".$_SESSION['celkovetdp']." W</div>";
    }
}
class IDGenerator{

    public ?string $userid = "";


    public function getUserid(): string{
        return $this->userid;
    }

    public function __construct(?string $useridid){

        if (empty($useridid)){
            $this->userid = $this->generateRandomString();
            $_SESSION["id"] = $this->userid;
        }
        else{
            $this->userid = $useridid;
            $_SESSION["id"] = $this->userid;
        }
    }

    function generateRandomString($length = 15) {
            $_SESSION["id"] = $this->userid;
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
final class CompatibilityChecker{

    static function checkForCompatibility(){
        $comparer = new Comparer();
        $dbdata = new DatabaseData();
        $boardchipset = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "chipset", "board");
        $cpuchipset =  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "chipsety", "cpu");


        $chipsetkompatibilni =  $comparer->compareValues($boardchipset, $cpuchipset);
        $boardpatice = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "patice", "board");
        $cpupatice=  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "patice", "cpu");

        $paticekompatibilni =  $comparer->compareValues($boardpatice, $cpupatice);

        $boardpcie = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "pcie", "board");
        $gpupcie= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "pcie", "gpu");
        $pciekompatibilni =  $comparer->compareValues($boardpcie, $gpupcie);


        $boardddr= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "ddr", "board");
        $ramddr= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "DDR", "ram");

        $ddrkompatibilni = $comparer->compareValues($boardddr, $ramddr);

        if (!$paticekompatibilni){
            if ($GLOBALS['active'] != true){
                ErrorMessageBox::throwError("Zjištěna nekompatibilita!","Deska není kompatibilní s procesorem.", "procesor", "desku", "clear/clearcpu.php", "clear/clearmb.php","");
            }
        }
        else if (!$chipsetkompatibilni){
            if ($GLOBALS['active'] != true){
                ErrorMessageBox::throwError("Zjištěna nekompatibilita!","Chipset desky neni kompatibilni s procesorem.", "cpu", "desku", "clear/clearcpu.php", "clear/clearmb.php", "");
            }
        }
        else if (!$pciekompatibilni) {
            if ($_SESSION["ignorovat"] != true) {
                ErrorMessageBox::throwError("Zjištěna nevhodná kombinace", "Verze PCI-E je nižší, než na grafické kartě. PC bude fungovat, ale deska může zpomalovat grafickou kartu. ", "gpu", "desku", "clear/clearcgu.php", "clear/clearmb.php", "gpu");

            }
        }
        else if (!$ddrkompatibilni) {
            if ($_SESSION["ignorovat"] != true) {
                ErrorMessageBox::throwError("Zjištěna nekompatibilita!","Verze DDR nesouhlasí, PC nebude fungovat.", "desku", "ram", "clear/clearmb.php", "clear/clearram.php", "");
            }
        }
    }

}

class DatabaseData{
    public function __construct(){
    }

//výpis z "vlozeno"

    function getActive(){
        $db = Connection::get();
        $db->getConnection(); // vrací mysqli
        $sql = "select polozka, id from komponenty.vlozeno where id = '".$_SESSION['id']."'";
        $db->GetSQLResult($sql);

    }
    function ReplaceActive(){
        $_SESSION["pridat"] = $_POST["vyber"];
        $db = Connection::get();
        $db->getConnection(); // vrací mysqli
        if ($_SESSION["pridat"]!=NULL){
            if (isset($_SESSION["id"])){
                $sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."' and type='".$_SESSION["type"]."')";
                $result = $db->executeQuery($sql);
                //Comparer::show_array($result);
                while($row = $result->fetch_assoc()) {
                     $typ = $row["type"];
                }
                if (isset($typ)){
                   $sql = "update komponenty.vlozeno set polozka='".$_SESSION["pridat"]."' where type='".$_SESSION["type"]."'";
                }
                else{
                    $sql = "insert into komponenty.vlozeno (id, polozka, type) values ('".$_SESSION["id"]."', '".$_SESSION["pridat"]."', '".$_SESSION["type"]."')";
                }
               $db->executeQuery($sql);
                $_SESSION["pridat"] = null;
                $_SESSION["type"] = null;
                $_POST["vyber"]=NULL;
                //header("Refresh:0");
            }
        }

    }



//odstranění empty z databáze vybraných produktů podle ID
    function removeEmpty(string $id){

        $db = Connection::get();
        $db->getConnection(); // vrací mysqli

        $db->executeQuery("delete from komponenty.vlozeno where id like '%".$id."%' and polozka = ''");
    }


//porovnání věcí v seznamu s deskou
//hwtype = cpu/gpu/ram
    function GetValuesFromDB(string $table1, string $row1, string $row2, ?string $hwtype) : string{
        $db = Connection::get();

        //vzít název komponenty
        $sql = "select ".$row1." from komponenty.".$table1." where (id ='".$_SESSION["id"]."') and (type='".$hwtype."')";
        $result = $db->getConnection()->query($sql);
        $firstvalue = "";
        $secondvalue = "";
        while($row = $result->fetch_assoc()) {
            $firstvalue = $row[$row1];
        }

        $sql = "select ".$row2." from komponenty.".$hwtype." where Nazev ='".$firstvalue."'";
        $result = $db->getConnection()->query($sql);
        while($row = $result->fetch_assoc()) {
            $secondvalue = $row[$row2];

        }
        return $secondvalue;
    }

    function selectFromDb($tablename, $selected_items, $id, $name, $toReturn, $type){
        $db = Connection::get();
        if ($name != ""){
            $sql = "select ".$selected_items." from komponenty.".$tablename." where (Nazev ='".$name."')";
            $result = $db->executeQuery($sql); // vratí výsledek dotazu
            $allvalues = $result->fetch_assoc();

        }
        else {
            $sql = "select * from komponenty.".$tablename." where (id ='".$id."') and (type='".$type."')";
            $result = $db->executeQuery($sql); // vratí výsledek dotazu
            $allvalues = $result->fetch_assoc();
        }

        return $allvalues[$toReturn];
    }


}

class Comparer{

    static function show_array($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    public string $comparervalue1;
    public string $comparervalue2;
    public array $value2result;
    public array $value1result;

    public function __construct(){
    }

    function compareValues(?string $comparervalue1, ?string $comparervalue2): bool{
        $this->comparervalue1 = $comparervalue1;
        $this->comparervalue2 = $comparervalue2;
        $allok = true;
        //první kontrola, zda jsou obě hodnoty nastaveny - zda má opravudu uživatel vybrané obě komponenty
        if (empty($comparervalue1) | empty($comparervalue2)) {
            return true;
        }
        //konverze na pole
        $this->value1result = explode(", ", $comparervalue1);
        $this->value2result = explode(", ", $comparervalue2);
        foreach ($this->value1result as $b) {
            if (in_array($b, $this->value2result, true)) {
                return true;
            }
            else{
            }
            return false;
        }
        return false;
    }
}

final class Connection{
    private string $host;

    private string $user;

    private string $password;

    private string $dbName;

    private ?mysqli $connection = NULL;

    // Zde je v privátní statické property uložená JEDINÁ instance třídy Connection
    private static ?self $instance = NULL;

    /**
     * Constructor je privátní, nelze tedy zavolat "new Connection(...)"
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbName
     */
    private function __construct(string $host, string $user, string $password, string $dbName){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    /**
     * Setup => nastaví se přístupy k DB a vytvoří se singleton
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbName
     *
     * @return void
     */
    public static function setup(string $host, string $user, string $password, string $dbName): void {
        if (NULL !== self::$instance) {
            throw new RuntimeException('Database already setuped.');
        }

        self::$instance = new self($host, $user, $password, $dbName);
    }

    /**
     * Vrací singleton
     *
     * @return static
     */
    public static function get(): self {
        if (NULL === self::$instance) {
            throw new RuntimeException('Database is not setuped.');
        }

        return self::$instance;
    }

    /**
     * Shortcut metoda pro ->getConnection()->query()
     *
     * @param string $query
     *
     * @return bool|\mysqli_result
     */
    public function executeQuery(string $query) {
        return $this->getConnection()->query($query);

    }

    /**
     * Vrací mysqli, pokud není zatím vytvořená, tak ji vytvoří
     *
     * @return \mysqli
     */
    public function getConnection(): mysqli{
        if (NULL === $this->connection) {
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbName);
        }

        return $this->connection;
    }

    public function GetSQLResult($sql) : void{
       $result = $this->getConnection()->query($sql);
        while($row = $result->fetch_assoc()) {
              echo "<p>".$row["polozka"]."</p>";
        }
    }
}

    // --------------------- ZAČÁTEK APPKY -----------------

error_reporting(0);

session_start();

//načíst <head>
htmlHandler::head();


//připojení k db
Connection::setup('*******', '*******e','*******','komponenty');
//instance třídy
$dbdriver = new DatabaseData();
//generování userID
if (empty($_SESSION["id"])) {
    $idgeneratorService = new IDGenerator(NULL);
}
else{
    $idgeneratorService = new IDGenerator($_SESSION["id"]);
}
//vyčištění empty hodnot z db
$dbdriver->removeEmpty($_SESSION['id']);


//updatovat komponenty, pokud došlo ke změně - session obsahuje novou komponentu
if (isset($_SESSION["type"])){
    $dbdriver->ReplaceActive();
}



//kontrola kompatibility
CompatibilityChecker::checkForCompatibility();

//vygenerujeme formulář - vyhledávací pole
htmlHandler::GenerateSelector();


//generujeme spotřebu
htmlhandler::powerconsumption();


//generujeme html položek
htmlHandler::polozky();


?>
