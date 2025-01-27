<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// подключение файла для соединения с базой и файл с объектом
include_once '/home/c/cx83378/websitedevel/public_html/objects/user.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';
// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$user = new User($db);
//читаем поток данных от пользлвателя
$data = json_decode(file_get_contents("php://input"));
// установим свойство для авторизации
$user->first_name   = $data->login; 
$user->email        = $data->email;
//выполняем авторизацию 
if($user->login_admin()) {
    // код ответа - 200 ok
    http_response_code(200);
    $_SESSION['admin'] = true;
    
} else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);
}


