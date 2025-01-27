<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// получаем соединение с базой данных
include_once "/home/c/cx83378/websitedevel/public_html/configure/database.php";

// создание объекта и передача ему коннекта для работы с базой данных
include_once "/home/c/cx83378/websitedevel/public_html/objects/country_city.php";
$database = new Database();
$db = $database->getConnection();

$city = new CountryCity($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

//проверяем есть ли в базе сущность которую мы пытаемся добавить
$stmt = $db->prepare("SELECT COUNT(*) FROM cities WHERE city = :city ");
$stmt->bindParam(":city", $data->city);
$stmt->execute();
//проверяем был ли найден автомобиль с указанными моделью и номером
if($stmt->fetchColumn() > 0){
    echo json_encode(array("message" => "Такой город уже есть в базе данных."), JSON_UNESCAPED_UNICODE);
} else{
//проверяем что переменная data не пустая
if (
!empty($data->city) &&
!empty($data->countryid)
) {
// устанавливаем значения свойств пользователя

$city->city = $data->city;
$city->city_countryid = $data->countryid;

//создадим сущности
if($city->create_city()) {
    // установим код ответа - 201 создано
    http_response_code(201);
    // сообщим пользователю
    echo json_encode(array("message" => "Город был создан."), JSON_UNESCAPED_UNICODE);
} else {
    //если не удалось создать пользователя, сообщаем 
    //устанавливаем код ответа - 503 сервис не доступен
    http_response_code(503);

    //сообщение пользователю
     echo json_encode(array("message" => "Невозможно создать город."), JSON_UNESCAPED_UNICODE);
}
} 
// сообщим пользователю что данные неполные
else {
    // устанавливае код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать автомобиль. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
}