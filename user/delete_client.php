<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
include_once '/home/c/cx83378/websitedevel/public_html/objects/user.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$user = new User($db);

// получаем id товара
$data = json_decode(file_get_contents("php://input"));

// установим id товара для удаления
$user->id = $data->id;

// удаление товара
if ($user->delete()) {
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