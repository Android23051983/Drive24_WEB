<?php
class CountryCity
{

    // подключение к базе данных и таблице "products"
    private $conn;

    // свойства объекта
    public $countryid;
    public $cityid;
    public $country;
    public $city;
    public $city_countryid;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read_city(){
    // выбираем все записи
    $query = "SELECT ci.id as cityid, ci.city, ci.countryid as city_countryid, co.id as countryid, co.country 
    FROM cities as ci, countries as co WHERE ci.countryid = co.id AND ci.countryid = :countryid";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);
    $this->city_countryid = htmlspecialchars(strip_tags($this->city_countryid));
    $stmt->bindParam(":countryid", $this->city_countryid);
    // выполняем запрос
    $stmt->execute();
    return $stmt;
    }

    function read_country(){
        // выбираем все записи
    $query = "SELECT co.id as countryid, co.country 
    FROM countries as co";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
    }
    //функция создания страны
    function create_country() {
    //запрос для вставки (создания) записей
    $query = "INSERT INTO countries (country) VALUES (:country)";
    //подготовка запроса
    $stmt = $this->conn->prepare($query);
    //очистка
    $this->country = htmlspecialchars(strip_tags($this->country));
    //привязка значений
    $stmt->bindParam(":country", $this->country);

    //выполняем запрос
    if($stmt->execute()) {
        return true;
    }

    return false;
    }
    
    //функция создания города (доработать до передачи страны при добавлении в виде id страны)
    function create_city() {
    //запрос для вставки (создания) записей
    $query = "INSERT INTO cities (city, countryid) VALUES (:city, :city_countryid)";
    //подготовка запроса
    $stmt = $this->conn->prepare($query);
    //очистка
    $this->city = htmlspecialchars(strip_tags($this->city));
    $this->city_countryid = htmlspecialchars(strip_tags($this->city_countryid));
    
    //привязка значений
    $stmt->bindParam(":city", $this->city);
    $stmt->bindParam(":city_countryid", $this->city_countryid);

    //выполняем запрос
    if($stmt->execute()) {
        return true;
    }

    return false;
    }

    function delete_country() {
        //запрос для удаления записи
        $query = "DELETE FROM countries WHERE id = :id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->countryid = htmlspecialchars(strip_tags($this->countryid));

        //привязываем id записи для удаления
        $stmt->bindParam(':id', $this->countryid);

        //выполняем запрос
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete_city() {
        //запрос для удаления записи
        $query = "DELETE FROM cities WHERE id = :id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);

        //очистка
        $this->cityid = htmlspecialchars(strip_tags($this->cityid));

        //привязываем id записи для удаления
        $stmt->bindParam(':id', $this->cityid);

        //выполняем запрос
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}