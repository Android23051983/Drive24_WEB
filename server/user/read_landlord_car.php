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

//получение данных от клиента
$data = json_decode(file_get_contents("php://input"));
//установка данных в объект
$user->first_name   = $data->first_name;
$user->last_name    = $data->last_name;
$user->email        = $data->email;

$stmt = $user->read_landlord_car();
$num = $stmt->rowCount();
if($num > 0) {
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

    //передаёи данные о в формате JSON клиенту
    echo json_encode($users_arr);
    
} else {
    //установим код ответа - 404 Не найдено
    http_response_code(404);
}

?>