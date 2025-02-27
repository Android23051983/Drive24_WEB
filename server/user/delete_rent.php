<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/objects/userRentalData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$user = new UserRentalData($db);

// получаем id товара
$data = json_decode(file_get_contents("php://input"));

// установим id товара для удаления
$user->id       = $data->user_id;
$user->car_id   = $data->car_id; 

// удаление товара
if ($user->delete_rent()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Пользователь был удалён"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить товар
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить пользователя"));
}