<?php

include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//получение неактивных записей
$query = "SELECT users_id, cars_id, date_end FROM users_cars WHERE status = 'inactive'";
$stmt = $db->query($query);

$rows = $stmt->fetchAll();
foreach($rows as $row) {
    $endDate = new DateTime($row['date_end']);
    $today = new DateTime();
   if($endDate >= $today) {
        $query = 'UPDATE users_cars SET status = "active" WHERE users_id = :users_id AND cars_id = :cars_id ';
        $stmt = $db->prepare($query);
        $stmt->bindParam(":users_id", $row['users_id']);
        $stmt->bindParam(":cars_id", $row['cars_id']);
        $stmt->execute();
   }
}
//получение неактивных записей
$query = "SELECT users_id, cars_id, date_end FROM users_cars WHERE status = 'active'";
$stmt = $db->query($query);

$rows = $stmt->fetchAll();
foreach($rows as $row) {
    $endDate = new DateTime($row['date_end']);
    $today = new DateTime();
   if($endDate < $today) {
        $query = 'UPDATE users_cars SET status = "inactive" WHERE users_id = :users_id AND cars_id = :cars_id ';
        $stmt = $db->prepare($query);
        $stmt->bindParam(":users_id", $row['users_id']);
        $stmt->bindParam(":cars_id", $row['cars_id']);
        $stmt->execute();
   } 
}
