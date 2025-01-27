<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Content-Type: application/json');
include_once '/home/c/cx83378/websitedevel/public_html/objects/car.php';
include_once '/home/c/cx83378/websitedevel/public_html/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$car = new Car($db);

//запрашиваем машину
$stmt = $car->read();
$num = $stmt->rowCount();

//проверка, найдено ли больше 0 записей
if($num >0 ) {
    $cars_arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //извлекаем строку
        extract($row);
        $car_irem = array(
            "id"            => $id,
            "model"         => $first_name,
            "number"        => $last_name,
            "cost"          => $cost           
        );
        array_push($cars_arr, $car_irem);
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