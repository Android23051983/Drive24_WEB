<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "/home/c/cx83378/websitedevel/public_html/configure/database.php";

// создание объекта пользователя
include_once "/home/c/cx83378/websitedevel/public_html/objects/car.php";
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

// получаем отправленные данные

$model          = $_POST['model'];
$number         = $_POST['number'];
$countryId      = $_POST['countryId'];
$cityId         = $_POST['cityId'];
$cost           = $_POST['cost'];
$target_file    = ""; 
$photo_info     = "";
$data_info      = "";
$path_save      = "";
//проверяем есть ли в базе сущность которую мы пытаемся добавить
$stmt = $db->prepare("SELECT COUNT(*) FROM cars WHERE model = :model AND number = :number");
$stmt->bindParam(":model", $model);
$stmt->bindParam(":number", $number);
$stmt->execute();

//проверяем был ли найден автомобиль с указанными моделью и номером
if($stmt->fetchColumn() > 0){
    echo json_encode(array("message" => "Такой автомобиль уже есть в базе данных."), JSON_UNESCAPED_UNICODE);
}else{
//сохраняем переданную фото машины
if(!empty($_FILES['file']['name'])){
    $target_dir     = "/home/c/cx83378/websitedevel/public_html/images/";
    $fileName       = basename($_FILES['file']['name']);
    $timeStamp      = date("YmdHi");
    $newFileName    = $timeStamp . "_" . $fileName;
    $target_file    = $target_dir . $newFileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $photo_info = "Фото добавлено в базу данных.";
    } else {
        $photo_info = "Ошибка загрузки файла.";
    }
    $path_save = "/images/" . $newFileName; 
}
//проверяем что полученные данные не пустые
    if (!empty($model)&& !empty($number)&& !empty($target_file)) {
    // устанавливаем значения свойств пользователя

    $car->model     = $model;
    $car->number    = $number;
    $car->city_id   = $cityId;
    $car->cost      = $cost;
    $car->photo     = $path_save;
    

    //создадим автомобиль
    if ($car->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);
        // сообщим пользователю
        $data_info = "Автомобиль был создан.";
    } else {
        //если не удалось создать автомобиль, сообщаем 
        //устанавливаем код ответа - 503 сервис не доступен
        http_response_code(503);

        //сообщение пользователю
        $data_info = "Невозможно создать автомобиль.";
    }
    // сообщим пользователю что данные неполные
    } else {
        // устанавливае код ответа - 400 неверный запрос
        http_response_code(400);

        // сообщим пользователю
        $data_info = "Невозможно создать автомобиль. Данные неполные.";
    }
     echo json_encode(array("message" => $photo_info . " " .  $data_info), JSON_UNESCAPED_UNICODE);
}