<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include_once '/home/c/cx83378/websitedevel/public_html/objects/userRentalData.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$user = new UserRentalData($db);
//получение данных от клиента
$filePath = 'incoming_data.log';
$rawData = file_get_contents("php://input");
file_put_contents($filePath, $rawData . "\n", FILE_APPEND | LOCK_EX);
$data = json_decode($rawData);

//установка данных в объект
$user->first_name   = $data->first_name;
$user->last_name    = $data->last_name;
$user->email        = $data->email;
//запрашиваем пользователей
$stmt = $user->read_client_data();
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
            "car_cost"      => $car_cost,
            "city"          => $city,
            "country"       => $country,
            "status"        => $status
        );
        array_push($users_arr, $user_irem);
    }
    //устанавливаем код ответа - 200 OK
    http_response_code(200);
    
    //передаём данные в формате JSON клиенту
    echo json_encode($users_arr);

} else {
    //установим код ответа - 404 Не найдено
    http_response_code(404);

    //сообщаем пользователю то товары не найдены
    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}

?>