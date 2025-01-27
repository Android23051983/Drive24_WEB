<div class="container">
<h2 class='mb-5'>Выбор автомобиля</h2>
</div>
<?
require_once "bootstrap.php";
require_once PROJECT_ROOT_PATH . "/configure/database.php";
$database = new Database();
$db = $database->getConnection();
$sql = "select * from countries order by id";
$res = $db->query($sql);
?>
<div class="container">
<div class="row">
    <div class="d-flex justify-content-between align-items-center">
        <select class="form-select" style="width: 49%" name="countryid" id="countryid" onchange="showCities(this.value)">
            <option disabled selected>Выберите страну...</option>
            <?
            foreach ($res as $row) {
                echo "<option value='{$row["id"]}'>{$row["country"]}</option>";
            }
            ?>
        </select>
        <select class="form-select" style="width: 49%" name="cityid" id="cityid" onchange="showCars(this.value)">
            <option disabled selected>Выберите город...</option>
        </select>
    </div>
</div>
</div>

<div id="cars" class="d-flex"></div>



