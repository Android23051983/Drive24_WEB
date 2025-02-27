<?php
session_start();
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . "/configure/database.php";
$database = new Database();
$db = $database->getConnection();
if (isset($_POST["cityid"])) {
    $cityid = $_POST["cityid"];
    $sel = "select co.country, ci.city, ca.id as carid, ca.model, ca.photo, ca.cost from countries co, cities ci, cars ca where co.id=ci.countryid AND ci.id = ca.city_id AND ca.city_id = $cityid";
    $res = $db->query($sel);
    $user_first_name    = $_SESSION['user']->first_name;
    $user_last_name     = $_SESSION['user']->last_name;
    $user_email         = $_SESSION['user']->default_email;
    $user_role          = $_SESSION['user']->role;
    $user_sel = "SELECT id FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email AND role = :role";
    $stmt = $db->prepare($user_sel);
    $stmt->bindParam(":first_name", $user_first_name);
    $stmt->bindParam(":last_name", $user_last_name);
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":role", $user_role);
    $stmt->execute();
    $user_row = $stmt->fetch(PDO::FETCH_ASSOC);
    while($row = $res->fetch()){
        echo "<div class='row m-2' style='display: flex; flex-wrap: nowrap;'>";
    if (isset($row["carid"])) {
        echo " <div class='col-sm-6 col-md-4 col-lg-3 mt-2'>
            <div class='card' style='width: 20rem; border-color: black;'>
            <img src='".$row['photo'] ."' class='card-img-top bg-light rounded-top img-fluid' alt='". $row['photo']."'>
            <div class='card-body bg-light rounded-bottom'> 
            <h5 class='card-title'>" . $row["model"] . "</h5>
            <p class='card-text'> г." . $row["city"] . ", " . $row["country"] . "</p>
            <p class='card-text fw-bold fs-3'>" . $row["cost"] . " руб./сутки</p>";
        if(!empty($_SESSION["user"]) && $_SESSION['user']->role == 123){
        echo " <a href='index.php?page=8&id=" . $row["carid"] . "&user_id=" .$user_row["id"] . "' class='btn btn-info mb-3 border border-dark' >Арендовать</a>";                
        }
        echo " 
        </div>
        </div>
        </div>              
        </div>";
        } else {
        echo '<h3 class="text-center text-danger" style="line-height:56vh">В выбранном городе отсутствуют автомобили.</h3>';
        echo "</div>";
    } 
    }
}