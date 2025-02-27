<?php
session_start();
class Passport
{
    // подключение к базе данных и таблице "products"
    private $conn;
    private $table_name = "passports";

    public $id;
    public $series;
    public $issued;
    public $address;
    public $users_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read() {
    try{
        $first_name = $_SESSION['user']->first_name;
        $last_name = $_SESSION['user']->last_name;
        $email = $_SESSION['user']->default_email;
        $role = $_SESSION['user']->role;
        $query_user = "SELECT id as user_id FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email AND role = :role";
        $stmt = $this->conn->prepare($query_user);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $UserId = $row['user_id'];
        
        $query = "SELECT * FROM passports WHERE users_id = :users_id";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":users_id", $UserId);
        // выполняем запрос
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->series = $row['series'];
        $this->issued = $row['issued'];
        $this->address = $row['address'];
            return true;
        } catch (PDOException $e){
            return false;
        }
    }

    function create() {
    try{
        $first_name = $_SESSION['user']->first_name;
        $last_name = $_SESSION['user']->last_name;
        $email = $_SESSION['user']->default_email;
        $role = $_SESSION['user']->role;
        $query_user = "SELECT id as user_id FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email AND role = :role";
        $stmt = $this->conn->prepare($query_user);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $UserId = $row['user_id'];
        $query_insert = "INSERT INTO passports (series, issued, address, users_id) VALUES (:series, :issued, :address, :users_id)";
        //подготовка запроса
        $stmt = $this->conn->prepare($query_insert);    
        //привязка значений
        $stmt->bindParam(":series", $this->series);
        $stmt->bindParam(":issued", $this->issued);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":users_id", $UserId);

        //выполняем запрос
        $stmt->execute();
        return true;
    
    } catch (PDOException $e){
            return false;
    }
    }

    function update() {
        try {
            $first_name = $_SESSION['user']->first_name;
            $last_name = $_SESSION['user']->last_name;
            $email = $_SESSION['user']->default_email;
            $role = $_SESSION['user']->role;
            $query_user = "SELECT id as user_id FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email AND role = :role";
            $stmt = $this->conn->prepare($query_user);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":role", $role);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $UserId = $row['user_id'];
            $query_user = "UPDATE passports SET series = :series, issued = :issued, address = :address WHERE users_id = :users_id";
            $stmt = $this->conn->prepare($query_user);

            //присоединение очищенных значений к запросу
            $stmt->bindParam(":series", $this->series);
            $stmt->bindParam(":issued", $this->issued);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":users_id", $UserId);
            //выполняем запрос
            $stmt->execute();
            return true;
            
        } catch (PDOException $e) {
            
            return false;
        }
    }
}