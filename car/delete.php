<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "/home/c/cx83378/websitedevel/public_html/configure/database.php";

// создание объекта пользователя
include_once "/home/c/cx83378/websitedevel/public_html/objects/car.php";
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

// получаем id товара
$data = json_decode(file_get_contents("php://input"));

// установим id товара для удаления
$car->id = $data->id;

// удаление товара
if ($car->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Машина была удалён"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить товар
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить машину"));
}