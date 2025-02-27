<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
require_once $_SERVER['DOCUMENT_ROOT'] . "/configure/database.php";

// создание объекта и передача ему коннекта для работы с базой данных
require_once $_SERVER['DOCUMENT_ROOT'] . "/server/objects/country_city.php";
$database = new Database();
$db = $database->getConnection();

$country = new CountryCity($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// проверяем, есть ли в базе сущность, которую мы пытаемся добавить
$stmt = $db->prepare("SELECT COUNT(*) FROM countries WHERE country = :country");
$stmt->bindParam(":country", $data->country);
$stmt->execute();

// проверяем, была ли найдена указанная страна
if ($stmt->fetchColumn() > 0) {
    echo json_encode(array("message" => "Такая страна уже есть в базе данных."), JSON_UNESCAPED_UNICODE);
} else {
    // проверяем, что переменная data не пустая
    if (!empty($data->country)) {
        // устанавливаем значение свойства страны
        $country->country = $data->country;

        // создадим страну
        if ($country->create_country()) {
            // установим код ответа - 201 создано
            http_response_code(201);
            // сообщим пользователю
            echo json_encode(array("message" => "Страна была создана."), JSON_UNESCAPED_UNICODE);
        } else {
            // если не удалось создать страну, сообщаем
            // устанавливаем код ответа - 503 сервис недоступен
            http_response_code(503);

            // сообщение пользователю
            echo json_encode(array("message" => "Невозможно создать страну."), JSON_UNESCAPED_UNICODE);
        }
    } else {
        // сообщим пользователю, что данные неполные
        // устанавливаем код ответа - 400 неверный запрос
        http_response_code(400);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать страну. Данные неполные."), JSON_UNESCAPED_UNICODE);
    }
}
?>