<?php
session_start();
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/objects/rent.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configure/database.php';

$database = new Database();
$db = $database->getConnection();

//инициализируем объект
$rent = new Rent($db);

//получаем отправленные данные для аренды

$user_id                        = $_POST['user_id']; 
$car_id                         = $_POST['car_id'];
$date_start                     = $_POST['date_start'];
$date_end                       = $_POST['date_end'];
$target_file                    = ""; 
$photo_passport_info            = "";
$photo_driving_license_info     = "";
$data_info                      = "";
$path_save_passport             = "";
$path_save_driving_license      = "";

//проверяем не занят ли тот период на который мы хатим арендовать автомобиль
//преобразовываем даты в формат понятный MySQL
$start_date = date("Y-m-d", strtotime($date_start));
$end_date   = date("Y-m-d", strtotime($date_end));

//SQL-запрос для проверки пересечения дат
$query = "SELECT COUNT(*) AS count FROM users_cars WHERE (:date_start BETWEEN date_start AND date_end OR :date_end BETWEEN date_start AND date_end OR(date_start <= :date_start AND date_end >= :date_end)) AND cars_id = :cars_id";

$stmt = $db->prepare($query);
$stmt->bindParam(':date_start', $start_date);
$stmt->bindParam(':date_end', $end_date);
$stmt->bindParam(':cars_id', $car_id);
$stmt->execute();
$res_date = $stmt->fetch(PDO::FETCH_ASSOC);
if($res_date['count']>0) {
    echo json_encode(array("message" => "Такой период дат у данной машины уже занят."), JSON_UNESCAPED_UNICODE);
} else {
    if(!empty($_FILES['passport_file']['name'])){
        $target_dir     = "/home/c/cx83378/websitedevel/public_html/images/";
        $fileName       = basename($_FILES['passport_file']['name']);
        $timeStamp      = date("YmdHi");
        $newFileName    = $timeStamp . "_ passport _" . $fileName;
        $target_file    = $target_dir . $newFileName;
        if (move_uploaded_file($_FILES['passport_file']['tmp_name'], $target_file)) {
            $photo_passport_info = "Фото паспорта добавлено в базу данных.";
        } else {
            $photo_passport_info = "Ошибка загрузки фото паспорта.";
        }
        $path_save_passport = "/images/" . $newFileName;
    }

    if(!empty($_FILES['driving_license_file']['name'])) {
        $target_dir     = "/home/c/cx83378/websitedevel/public_html/images/";
        $fileName       = basename($_FILES['driving_license_file']['name']);
        $timeStamp      = date("YmdHi");
        $newFileName    = $timeStamp . "_ driving_license _" . $fileName;
        $target_file    = $target_dir . $newFileName;
        if (move_uploaded_file($_FILES['driving_license_file']['tmp_name'], $target_file)){
            $photo_driving_license_info = "Фото прав добавлено в базу данных";
        } else {
            $photo_driving_license_info = "Ошибка загрузки фото прав";
        }
        $path_save_driving_license = "/images/" . $newFileName;
    }
    //проверяем что полученные данные не пустые
    if (!empty($user_id)&& !empty($car_id)) {
        $rent->id                               = $car_id;
        $rent->user_id                          = $user_id;
        $rent->users_cars_date_start            = $date_start;
        $rent->users_cars_date_end              = $date_end;
        $rent->users_cars_photo_passport        = $path_save_passport;
        $rent->users_cars_photo_driver_license  = $path_save_driving_license;
        $rent->users_cars_status                = 'exception';

        //арендуем автомобиль
        if ($rent->rent_car()) {
            // установим код ответа - 201 создано
            http_response_code(201);
            // сообщим пользователю
            $data_info = "Автомобиль арендован.";
        } else {
            //если не удалось создать автомобиль, сообщаем 
            //устанавливаем код ответа - 503 сервис не доступен
            http_response_code(503);

            //сообщение пользователю
            $data_info = "Невозможно арендовать автомобиль.";
        }
    }
    echo json_encode(array("message" => $photo_info . " " .  $data_info), JSON_UNESCAPED_UNICODE);
}
