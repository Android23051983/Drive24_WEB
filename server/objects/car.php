<?php
session_start();
class Car
{
    // подключение к базе данных и таблице "products"
    private $conn;

    // свойства объекта
    public $id;
    public $model;
    public $number;
    public $city_id;
    public $cost;
    public $photo;
    public $city_city;
    public $country_country;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
    // выбираем все записи
    $query = "SELECT ca.id, ca.model, ca.number, ca.cost, ca.photo, ci.city as city_city, co.country as country_country FROM cars as ca, cities as ci, countries as co WHERE ci.id = ca.city_id AND co.id = ci.countryid";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
    }

    function read_one()
    {
       if (!$this->id) {
            return false;
        }
        // выбираем запись
        $query = "SELECT ca.id, ca.model, ca.number, ca.cost, ca.photo, ci.city as city_city, co.country as country_country FROM cars as ca, cities as ci, countries as co WHERE ci.id = ca.city_id AND co.id = ci.countryid AND ca.id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        // выполняем запрос
        $stmt->execute();
        //получение данных из выполненного запроса
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
        isset($row['model']) ? $this->model = $row['model'] : null;
        isset($row['number']) ? $this->number = $row['number'] : null;
        isset($row['cost']) ? $this->cost = $row['cost'] : null;
        isset($row['photo']) ? $this->photo = $row['photo'] : null;
        isset($row['city_city']) ? $this->city_city = $row['city_city'] : null;
        isset($row['country_country']) ? $this->country_country = $row['country_country'] : null;
        }
    }

    function read_one_number()
    {
        // выбираем запись
        $query = "SELECT ca.id, ca.model, ca.number, ca.cost, ca.photo, ci.city as city_city, co.country as country_country FROM cars as ca 
        JOIN cities AS ci ON ci.id = ca.city_id
        JOIN countries AS co ON co.id = ci.countryid
        WHERE ca.number = :number";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":number", $this->number);
    
        // Выполняем запрос
        $stmt->execute();
        //получение данных из выполненного запроса
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
        isset($row['model']) ? $this->model = $row['model'] : null;
        isset($row['number']) ? $this->number = $row['number'] : null;
        isset($row['cost']) ? $this->cost = $row['cost'] : null;
        isset($row['photo']) ? $this->photo = $row['photo'] : null;
        isset($row['city_city']) ? $this->city_city = $row['city_city'] : null;
        isset($row['country_country']) ? $this->country_country = $row['country_country'] : null;
        return true;
        }
        return false;
    }

    function create() {
    try{
    $this->conn->beginTransaction();
    //запрос для вставки (создания) записей
    $query = "INSERT INTO cars (model, number, city_id, cost, photo) VALUES (:model, :number, :city_id, :cost, :photo)";
    //подготовка запроса
    $stmt = $this->conn->prepare($query);    
    //привязка значений
    $stmt->bindParam(":model", $this->model);
    $stmt->bindParam(":number", $this->number);
    $stmt->bindParam(":city_id", $this->city_id);
    $stmt->bindParam(":cost", $this->cost);
    $stmt->bindParam(":photo", $this->photo);

    //выполняем запрос
    $stmt->execute();
        $insertedCarId = $this->conn->lastInsertId();
        $first_name = $_SESSION['user']->first_name;
        $last_name = $_SESSION['user']->last_name;
        $email = $_SESSION['user']->default_email;
        $query_user = "SELECT id as user_id FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email";
        $stmt = $this->conn->prepare($query_user);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $UserId = $row['user_id'];
        $query_users_cars = "INSERT INTO users_cars (users_id, cars_id) VALUES (:users_id, :cars_id)";
        $stmt=$this->conn->prepare($query_users_cars);
        $stmt->bindParam(":users_id", $UserId);
        $stmt->bindParam(":cars_id", $insertedCarId);
        $stmt->execute();
        $this->conn->commit();
        return true;
    
    } catch (PDOException $e){
        $this->conn->rollBack();
        return false;
    }
}

    function delete(){
        //запрос для удаления записи
        $query = "DELETE FROM cars WHERE id = :id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);
        //очистка
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()){
            return true;
        }

        return false;

    }

   function update(){}
}