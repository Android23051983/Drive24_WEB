<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/objects/userRentalData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$user = new UserRentalData($db);

//запрашиваем пользователей
$stmt = $user->read_client();
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
            "email"        	=> $email,
            "phone"         => $phone,
            "role"          => $role,
            "date_start" 	=> $date_start,
            "date_end"   	=> $date_end,
            "car_id"        => $car_id,
            "car_model"     => $car_model,
            "car_number"    => $car_number,
            "city"          => $city,
            "country"       => $country,
            "status"        => $status
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

?>