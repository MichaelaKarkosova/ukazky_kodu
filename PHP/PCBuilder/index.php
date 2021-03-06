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

public static function GenerateHead(){
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
<a href="add.php" class="button">P??idat komponentu</a>
<input type="submit" name="jj" class="button" value="Hodnocen?? zdroje" onClick="zdrojhodnoceni();">
<br>';

}
public static function GetItems(){
    $dbdriver = new DatabaseData();
    echo "<body>
       </form>
    </p><form method='get' name='specify2' style='width:auto;display:block;'></form><b><div class='polozky' align='right'>Tvoje polo??ky</b><div class ='items'>";
    $dbdriver->GetActive();
    echo "</big></div></body>";
    echo "<a href='clear.php'>Vy??istit</a>";

}
public static function GenerateSelector() :void{


echo "</div>";
echo "<p>&nbsp;</p> <p>&nbsp;</p> ";
?></div>Deska: <input type="text" name="specify2" style='width:auto;display:block' class='input' oninput="show(this.value,'board')"></input></p>Procesor: <input type="text" name="specify2" class='input' style='width:auto;display:block' oninput="show(this.value,'cpu')"></input></p>Grafick?? karta: <input class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'gpu')"></input></p>RAM: <input  class='input' type="text" style='width:auto;display:block' name="specify2" oninput="show(this.value,'ram')"></input></form><div id="specify"></div></form></p>
<?php
}

public static function UpdatePowerConsumption(){
    $dbdata = new DatabaseData();
    $tdpgpu = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "TDP", "gpu");
    $tdpcpu =  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "TDP", "cpu");
    $_SESSION["celkovetdp"] = $tdpcpu+$tdpgpu;
    echo "Max spot??eba:<p><div class='spotreba'>".$_SESSION['celkovetdp']." W</div>";
}
}
class IDGenerator{

    public ?string $userid = "";


    public function GetUserid(): string{
        return $this->userid;
    }

    public function __construct(?string $useridid){

        if (empty($useridid)){
            $this->userid = $this->GenerateRandomString();
            $_SESSION["id"] = $this->userid;
        }
        else{
            $this->userid = $useridid;
            $_SESSION["id"] = $this->userid;
        }
    }

    function GenerateRandomString($length = 15) {
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

    static function CheckForCompatibility(){
        $comparer = new Comparer();
        $dbdata = new DatabaseData();
        $board_chipset = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "chipset", "board");
        $cpu_chipset =  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "chipsety", "cpu");


        $chipset_compatible =  $comparer->CompareValues($board_chipset, $cpu_chipset);
        $board_socket = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "patice", "board");
        $cpu_socket=  $dbdata->GetValuesFromDB("vlozeno",  "polozka", "patice", "cpu");

        $socket_compatible =  $comparer->CompareValues($board_socket, $cpu_socket);

        $board_pcie = $dbdata->GetValuesFromDB("vlozeno",  "polozka", "pcie", "board");
        $gpu_pcie= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "pcie", "gpu");
        $pcie_compatible =  $comparer->CompareValues($board_pcie, $gpu_pcie);


        $board_ddr= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "ddr", "board");
        $ram_ddr= $dbdata->GetValuesFromDB("vlozeno",  "polozka", "DDR", "ram");

        $ddr_compatible = $comparer->CompareValues($board_ddr, $ram_ddr);

        if (!$socket_compatible){
            if ($GLOBALS['active'] != true){
                ErrorMessageBox::throwError("Zji??t??na nekompatibilita!","Deska nen?? kompatibiln?? s procesorem.", "procesor", "desku", "clear/clearcpu.php", "clear/clearmb.php","");
            }
        }
        else if (!$chipset_compatible){
            if ($GLOBALS['active'] != true){
                ErrorMessageBox::throwError("Zji??t??na nekompatibilita!","Chipset desky neni _compatible s procesorem.", "cpu", "desku", "clear/clearcpu.php", "clear/clearmb.php", "");
            }
        }
        else if (!$pcie_compatible) {
            if ($_SESSION["ignorovat"] != true) {
                ErrorMessageBox::throwError("Zji??t??na nevhodn?? kombinace", "Verze PCI-E je ni??????, ne?? na grafick?? kart??. PC bude fungovat, ale deska m????e zpomalovat grafickou kartu. ", "gpu", "desku", "clear/clearcgu.php", "clear/clearmb.php", "gpu");

            }
        }
        else if (!$ddr_compatible) {
            if ($_SESSION["ignorovat"] != true) {
                ErrorMessageBox::throwError("Zji??t??na nekompatibilita!","Verze DDR nesouhlas??, PC nebude fungovat.", "desku", "ram", "clear/clearmb.php", "clear/clearram.php", "");
            }
        }
    }

}

class DatabaseData{
    public function __construct(){
    }

//v??pis z "vlozeno"

    function GetActive(){
        $db = Connection::get();
        $db->GetConnection(); // vrac?? mysqli
        $sql = "select polozka, id from komponenty.vlozeno where id = '".$_SESSION['id']."'";
        $db->GetSQLResult($sql);

    }
    function ReplaceActive(){
        $_SESSION["toadd"] = $_POST["vyber"];
        $db = Connection::get();
        $db->GetConnection(); // vrac?? mysqli
        if ($_SESSION["toadd"]!=NULL){
            if (isset($_SESSION["id"])){
                $sql = "select * from komponenty.vlozeno where (id='".$_SESSION["id"]."' and type='".$_SESSION["type"]."')";
                $result = $db->ExecuteQuery($sql);
                //Comparer::show_array($result);
                while($row = $result->fetch_assoc()) {
                    $typ = $row["type"];
                }
                if (isset($typ)){
                    $sql = "update komponenty.vlozeno set polozka='".$_SESSION["toadd"]."' where type='".$_SESSION["type"]."'";
                }
                else{
                    $sql = "insert into komponenty.vlozeno (id, polozka, type) values ('".$_SESSION["id"]."', '".$_SESSION["toadd"]."', '".$_SESSION["type"]."')";
                }
                $db->ExecuteQuery($sql);
                $_SESSION["toadd"] = null;
                $_SESSION["type"] = null;
                $_POST["vyber"]=NULL;
                //header("Refresh:0");
            }
        }

    }



//odstran??n?? empty z datab??ze vybran??ch produkt?? podle ID
    function RemoveEmpty(string $id){

        $db = Connection::get();
        $db->GetConnection(); // vrac?? mysqli

        $db->ExecuteQuery("delete from komponenty.vlozeno where id like '%".$id."%' and polozka = ''");
    }


//porovn??n?? v??c?? v seznamu s deskou
//hwtype = cpu/gpu/ram
    function GetValuesFromDB(string $table1, string $row1, string $row2, ?string $hwtype) : string{
        $db = Connection::get();

        //vz??t n??zev komponenty
        $sql = "select ".$row1." from komponenty.".$table1." where (id ='".$_SESSION["id"]."') and (type='".$hwtype."')";
        $result = $db->GetConnection()->query($sql);
        $firstvalue = "";
        $secondvalue = "";
        while($row = $result->fetch_assoc()) {
            $firstvalue = $row[$row1];
        }

        $sql = "select ".$row2." from komponenty.".$hwtype." where Nazev ='".$firstvalue."'";
        $result = $db->GetConnection()->query($sql);
        while($row = $result->fetch_assoc()) {
            $secondvalue = $row[$row2];

        }
        return $secondvalue;
    }

    function SelectFromDb($tablename, $selected_items, $id, $name, $toReturn, $type){
        $db = Connection::get();
        if ($name != ""){
            $sql = "select ".$selected_items." from komponenty.".$tablename." where (Nazev ='".$name."')";
            $result = $db->ExecuteQuery($sql); // vrat?? v??sledek dotazu
            $allvalues = $result->fetch_assoc();

        }
        else {
            $sql = "select * from komponenty.".$tablename." where (id ='".$id."') and (type='".$type."')";
            $result = $db->ExecuteQuery($sql); // vrat?? v??sledek dotazu
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

    function CompareValues(?string $comparervalue1, ?string $comparervalue2): bool{
        $this->comparervalue1 = $comparervalue1;
        $this->comparervalue2 = $comparervalue2;
        $allok = true;
        //prvn?? kontrola, zda jsou ob?? hodnoty nastaveny - zda m?? opravudu u??ivatel vybran?? ob?? komponenty
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

    // Zde je v priv??tn?? statick?? property ulo??en?? JEDIN?? instance t????dy Connection
    private static ?self $instance = NULL;

    /**
     * Constructor je priv??tn??, nelze tedy zavolat "new Connection(...)"
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
     * Setup => nastav?? se p????stupy k DB a vytvo???? se singleton
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
     * Vrac?? singleton
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
     * Shortcut metoda pro ->GetConnection()->query()
     *
     * @param string $query
     *
     * @return bool|\mysqli_result
     */
    public function ExecuteQuery(string $query) {
       return $this->GetConnection()->query($query);
    }

    /**
     * Vrac?? mysqli, pokud nen?? zat??m vytvo??en??, tak ji vytvo????
     *
     * @return \mysqli
     */
    public function GetConnection(): mysqli{
        if (NULL === $this->connection) {
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbName);
        }

        return $this->connection;
    }

    public function GetSQLResult($sql) : void{
        $result = $this->GetConnection()->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<p>".$row["polozka"]."</p>";
        }
    }
}

// --------------------- ZA????TEK APPKY -----------------

error_reporting(1);

session_start();

//na????st <head>
htmlHandler::GenerateHead();


//p??ipojen?? k db
Connection::setup('*******', '*******','*********','komponenty');
//instance t????dy
$dbdriver = new DatabaseData();
//generov??n?? userID
if (empty($_SESSION["id"])) {
    $idgeneratorService = new IDGenerator(NULL);
}
else{
    $idgeneratorService = new IDGenerator($_SESSION["id"]);
}
//vy??i??t??n?? empty hodnot z db
$dbdriver->RemoveEmpty($_SESSION['id']);


//updatovat komponenty, pokud do??lo ke zm??n?? - session obsahuje novou komponentu
if (isset($_SESSION["type"])){
    $dbdriver->ReplaceActive();
}


//kontrola kompatibility
CompatibilityChecker::CheckForCompatibility();

//vygenerujeme formul???? - vyhled??vac?? pole
htmlHandler::GenerateSelector();


//generujeme spot??ebu
htmlhandler::UpdatePowerConsumption();


//generujeme html polo??ek
htmlHandler::GetItems();


?>
