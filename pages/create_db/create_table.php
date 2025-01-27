<?php
include_once '../../configure/database.php';
$database = new Database();
$db = $database->getConnection();

try {
    $sql1 = "CREATE TABLE IF NOT EXISTS cars (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        model varchar(64) NOT NULL,
        number varchar(64) NOT NULL,
        city_id int,
        photo varchar(254) NOT NULL,
        cost float NOT NULL,
        FOREIGN KEY (city_id) REFERENCES cities(id)
    );";
    $db->exec($sql1);

    $sql2 = "CREATE TABLE IF NOT EXISTS users (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        first_name varchar(64) NOT NULL,
        last_name varchar(64) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(12) NOT NULL,
        role int NOT NULL
    );";
    $db->exec($sql2);

    $sql3 = "CREATE TABLE IF NOT EXISTS users_cars (
        users_id int NOT NULL,
        cars_id int NOT NULL,
        date_start date,
        date_end date,
        photo_passport varchar(254),
        photo_driver_license varchar(254),
        PRIMARY KEY (users_id, cars_id),
        status ENUM('exception', 'active', 'inactive') DEFAULT 'inactive',
        FOREIGN KEY (users_id) REFERENCES users(id),
        FOREIGN KEY (cars_id) REFERENCES cars(id) ON DELETE CASCADE
    );";
    $db->exec($sql3);

    $sql4 = "CREATE TABLE IF NOT EXISTS countries (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        country varchar(64) NOT NULL UNIQUE
    );";
    $db->exec($sql4);

    $sql5 = "CREATE TABLE IF NOT EXISTS cities (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        city varchar(64) NOT NULL,
        countryid int,
        FOREIGN KEY (countryid) REFERENCES countries(id) ON DELETE CASCADE,
        ucity varchar(128),
        UNIQUE INDEX ucity (city, countryid)
    );";
    $db->exec($sql5);

    $sql_admin_if = "SELECT * FROM users WHERE first_name = 'admin' AND last_name = 'admin' AND email = 'admin@mail.ru'";
    $stmt = $db->query($sql_admin_if);
    $result = $stmt->fetch();
    if (!$result) {
        $sql_admin = "INSERT INTO users (first_name, last_name, email, phone, role) VALUES ('admin', 'admin', 'admin@mail.ru', '+79xxxxxxxxx', '1');";
        $db->exec($sql_admin);
    }

    echo "Таблицы проверены на наличие или создана если не существовала";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>