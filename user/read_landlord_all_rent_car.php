<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключим файл для соединения с базой и объектом 
include_once '/home/c/cx83378/websitedevel/public_html/objects/user.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

// получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$user = new User($db);

// получаем id товара
$data = json_decode(file_get_contents("php://input"));

// установим полученных данных
$user->first_name   = $data->first_name;
$user->last_name    = $data->last_name;
$user->email        = $data->email;

//запрашиваем пользователей
$stmt = $user->read_landlord_all_rent_car();
$num = $stmt->rowCount();

//проверка, найдено ли больше 0 записей
if($num >0 ) {
    $users_arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //извлекаем строку
        extract($row);
        $user_irem = array(
            "id"            => $id,
            "first_name"    => $first_name,
            "last_name"     => $last_name,
            "email"         => $email,
            "phone"         => $phone,
            "role"          => $role,
            "date_start"    => $date_start,
            "date_end"      => $date_end,
            "car_id"        => $car_id,
            "car_model"     => $car_model,
            "car_number"    => $car_number,
            "city"          => $city,
            "country"       => $country
        );
        array_push($users_arr, $user_irem);
    }
    //устанавливаем код ответа - 200 OK
    http_response_code(200);
    
    //выводим данные о товаре в формате JSON
    echo json_encode($users_arr);

} else {
    //установим код ответа - 404 Не найдено
    http_response_code(404);

    //сообщаем пользователю то товары не найдены
    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}