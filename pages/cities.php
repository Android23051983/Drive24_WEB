<?
require_once "../bootstrap.php";
require_once PROJECT_ROOT_PATH . "/configure/database.php";
$database = new Database();
$db = $database->getConnection();

if(isset($_POST["countryid"])) {
    $countryid = $_POST["countryid"];

    $sel = "select * from cities where countryid=$countryid";
    $res = $db->query($sel);

    echo "<option disabled selected>Выберите город...</option>";
    foreach($res as $row) {
        echo "<option value='{$row["id"]}'>{$row["city"]}</option>";
    }
}
?>