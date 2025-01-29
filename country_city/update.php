<?php
// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once "../config/database.php";
include_once "../objects/userRentalData.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$user = new UserRentalData($db);

// установим значения свойств пользователя
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->email = $data->email;
$user->phone = $data->phone;
$user->role = $data->role;
$user->users_cars_date_start = $data->date_start;
$user->users_cars_date_end = $data->date_end;

// обновление пользователя
if ($user->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Пользователь был обновлён"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить пользователя, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);
    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить пользователя"), JSON_UNESCAPED_UNICODE);
}
