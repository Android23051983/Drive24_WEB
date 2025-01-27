<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// получаем соединение с базой данных
include_once "/home/c/cx83378/websitedevel/public_html/configure/database.php";

// создание объекта пользователя
include_once "/home/c/cx83378/websitedevel/public_html/objects/car.php";
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);
//получение данных 
$data = json_decode(file_get_contents("php://input"));
// установим свойство
$car->number = $data->car_number;
// выполнение функции с запросом в БД
if ($car->read_one_number() ) {
    $car_arr = array();

    $car_arr = array(
        "id"                => $car->id,
        "model"             => $car->model,
        "number"            => $car->number,
        "cost"              => $car->cost,
        "photo"             => $car->photo,
        "role"              => $car->role,
        "city_city"         => $car->city_city,
        "country_country"   => $car->country_country
    );
    //код ответа - 200 OK
    http_response_code(200);

    //вывод в формате json
    echo json_encode($car_arr);
} else {
     // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("message" => "Автомобиль не существует"), JSON_UNESCAPED_UNICODE);
}