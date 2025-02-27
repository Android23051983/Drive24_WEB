<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
require_once $_SERVER['DOCUMENT_ROOT'] . "/configure/database.php";

// создание объекта пользователя
require_once $_SERVER['DOCUMENT_ROOT'] . "/server/objects/passport.php";
$database = new Database();
$db = $database->getConnection();
$passport = new Passport($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));
if ($data){
    $passport->series = $data->series;
    $passport->issued = $data->issued;
    $passport->address = $data->address;
}
// создадим паспорт пользователя
if ($passport->update()) {
    // установим код ответа - 201 создано
    http_response_code(201);
    // сообщим пользователю
    echo json_encode(array("message" => "Паспорт паспорта был обновлён."), JSON_UNESCAPED_UNICODE);
} else {
    //если не удалось создать пользователя, сообщаем 
    //устанавливаем код ответа - 503 сервис не доступен
    http_response_code(503);

    //сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить паспорт пользователя."), JSON_UNESCAPED_UNICODE);

}