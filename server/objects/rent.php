<?php
session_start();
class Rent
{
    // подключение к базе данных и таблице "products"
    private $conn;

    // свойства объекта необходимыяе для аренды автомобиля
    public $id;
    public $user_id;
    public $users_cars_date_start;
    public $users_cars_date_end;
    public $users_cars_photo_passport;
    public $users_cars_photo_driver_license;
    public $users_cars_status;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function rent_car(){
        $query = "INSERT INTO users_cars(cars_id, users_id, date_start, date_end, photo_passport, photo_driver_license, status) VALUES (:cars_id, :users_id, :date_start, :date_end, :photo_passport, :photo_driver_license, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cars_id', $this->id);
        $stmt->bindParam(':users_id', $this->user_id);
        $stmt->bindParam(':date_start', $this->users_cars_date_start);
        $stmt->bindParam(':date_end', $this->users_cars_date_end);
        $stmt->bindParam(':photo_passport', $this->users_cars_photo_passport);
        $stmt->bindParam(':photo_driver_license', $this->users_cars_photo_driver_license);
        $stmt->bindParam(':status', $this->users_cars_status);
        if($stmt->execute()){
        return true;
        }
        return false;
    }

    function verifyRent() {
        $query = "UPDATE users_cars SET status = :status WHERE users_id = :users_id AND cars_id = :cars_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->users_cars_status);
        $stmt->bindParam(":users_id", $this->user_id);
        $stmt->bindParam(":cars_id", $this->id);

        if($stmt->execute()){
        return true;
        }
        return false;

    }
}