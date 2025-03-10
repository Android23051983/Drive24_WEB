<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once '/home/c/cx83378/websitedevel/public_html/objects/userRentalData.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$user = new UserRentalData($db);

// установим свойство ID записи для чтения
$data = json_decode(file_get_contents("php://input"));
$user->id       = $data->userId;
$user->car_id   = $data->carId;


// получим детали товара
$stmt = $user->read_client_one();

if (!empty($user->id)) {
    $user_arr = array();

    $user_arr = array(
        "id"                     => $user->id,
        "first_name"             => $user->first_name,
        "last_name"              => $user->last_name,
        "email"                  => $user->email,
        "phone"                  => $user->phone,
        "role"                   => $user->role,
        "date_start"             => $user->users_cars_date_start,
        "date_end"               => $user->users_cars_date_end,
        "car_id"                 => $user->car_id,
        "car_model"              => $user->car_model,
        "car_number"             => $user->car_number,
        "car_city_id"            => $user->car_city_id,
        "car_cost"               => $user->car_cost,
        "city_id"                => $user->city_id,
        "city_city"              => $user->city_city,
        "cit_country"    	    => $user->city_countryid,
        "country_id"     	    => $user->country_id,
        "country_country"        => $user->country_country,
        "photo_passport"         => $user->users_cars_photo_passport,
        "photo_driver_license"   => $user->users_cars_photo_driving_license,
        "status"                 => $user->users_cars_status
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