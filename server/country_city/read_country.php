<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/objects/country_city.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$city = new CountryCity($db);

//запрашиваем пользователей
$stmt = $city->read_country();
$num = $stmt->rowCount();

//проверка, найдено ли больше 0 записей
if($num >0 ) {
    $cities_arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //извлекаем строку
        extract($row);
        $city_irem = array(
            "countryid" => $countryid,
            "country"   => $country
        );
        array_push($cities_arr, $city_irem);
    }
    //устанавливаем код ответа - 200 OK
    http_response_code(200);
    
    //выводим данные о товаре в формате JSON
    echo json_encode($cities_arr);

} else {
    //установим код ответа - 404 Не найдено
    http_response_code(404);

    //сообщаем пользователю то товары не найдены
    echo json_encode(array("message" => "Города не найдены."), JSON_UNESCAPED_UNICODE);
}

?>