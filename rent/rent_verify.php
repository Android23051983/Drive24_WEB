<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once '/home/c/cx83378/websitedevel/public_html/objects/rent.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$rent = new Rent($db);

$data = json_decode(file_get_contents("php://input"));

$rent->id                   = $data->car_id;
$rent->user_id              = $data->user_id;
$rent->users_cars_status    = 'active'; 

if($rent->verifyRent()){
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Статус аренды был обновлен"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить статус, сообщим пользователю
else {
// код ответа - 503 Сервис не доступен
    http_response_code(503);
    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить статус аренды"), JSON_UNESCAPED_UNICODE);
}
