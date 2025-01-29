<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта пользователя
include_once "../objects/userRentalData.php";
$database = new Database();
$db = $database->getConnection();
$user = new UserRentalData($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

if (
!empty($first_name)&&
!empty($last_name)&&
!empty($email)&&
!empty($phone)&&
!empty($role)&&
!empty($date_start)&&
!empty($date_end)
) {
// устанавливаем значения свойств пользователя

$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->email = $data->email;
$user->phone = $data->phone;
$user->role = $data->role;
$user->users_cars_date_start = $data->date_start;
$user->users_cars_date_end = $data->date_end;

//создадим пользователя
if ($user->create()) {
    // установим код ответа - 201 создано
    http_response_code(201);
    // сообщим пользователю
    echo json_encode(array("message" => "Пользователь был создан."), JSON_UNESCAPED_UNICODE);
} else {
    //если не удалось создать пользователя, сообщаем 
    //устанавливаем код ответа - 503 сервис не доступен
    http_response_code(503);

    //сообщение пользователю
    echo json_encode(array("message" => "Невозможно создать пользовтеля."), JSON_UNESCAPED_UNICODE);
}
} 
// сообщим пользователю что данные неполные
else {
    // устанавливае код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать пользователя. Данные неполные."), JSON_UNESCAPED_UNICODE);
}