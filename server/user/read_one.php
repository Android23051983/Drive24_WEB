<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/objects/userRentalData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configure/database.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$user = new UserRentalData($db);

// установим свойство ID записи для чтения
$data = json_decode(file_get_contents("php://input"));
$user->id       = $data->userId;
//выполнение метода
$stmt = $user->read_one();
//проверка что данные получены и заполнение данными ответ

if (!empty($user->first_name)) {
    $user_arr = array();

    $user_arr = array(
        "id"                => $user->id,
        "first_name"        => $user->first_name,
        "last_name"         => $user->last_name
    );

     //код ответа - 200 OK
    http_response_code(200);

    //вывод в формате json
    echo json_encode($user_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("message" => "Пользователь не существует"), JSON_UNESCAPED_UNICODE);
}

