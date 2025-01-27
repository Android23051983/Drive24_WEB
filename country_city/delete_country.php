<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
include_once '/home/c/cx83378/websitedevel/public_html/objects/country_city.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$country = new CountryCity($db);

// получаем id сущности
$data = json_decode(file_get_contents("php://input"));

// установим id сущности для удаления
$country->countryid = $data->countryid;

// удаление сущности
if ($country->delete_country()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Страна была удалёна"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить товар
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить пользователя"));
}