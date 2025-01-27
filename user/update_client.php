<?php
// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключение файла для соединения с базой и файл с объектом
include_once '/home/c/cx83378/websitedevel/public_html/objects/user.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();


// подготовка объекта
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

// установим значения свойств пользователя
$user->id                       = $data->id;
$user->first_name               = $data->first_name;
$user->last_name                = $data->last_name;
$user->email                    = $data->email;
$user->phone                    = $data->phone;
$user->car_id                   = $data->car_id;
$user->users_cars_date_start    = $data->date_start;
$user->users_cars_date_end      = $data->date_end;
// обновление пользователя
if ($user->update_client()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Пользователь и его данные были обновлены"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить пользователя, сообщим пользователю
else {
// код ответа - 503 Сервис не доступен
    http_response_code(503);
     // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить пользователя и его данные"), JSON_UNESCAPED_UNICODE);
}