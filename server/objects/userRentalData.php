<?php

class UserRentalData
{
    // подключение к базе данных и таблице "products"
    private $conn;
    private $table_name = "users";

    // свойства объекта
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $role;
    public $car_id;
    public $car_model;
    public $car_number;
    public $car_city_id;
    public $car_photo;
    public $car_cost;
    public $city_id;
    public $city_city;
    public $city_countryid;
    public $country_id;
    public $country_country;
    public $users_cars_date_start;
    public $users_cars_date_end;
    public $users_cars_photo_passport;
    public $users_cars_photo_driving_license;
    public $users_cars_status;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create() {

    }

    function read()
    {
        // выбираем все записи
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, u_c.date_start, u_c.date_end, c.model as car_model FROM cars as c, users as u, users_cars as u_c WHERE c.id = u_c.cars_id AND u.id = u_c.users_id ";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }
    function read_one() {
        $query = "SELECT u.first_name, u.last_name FROM users as u WHERE u.id = :id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);
        //выполнение запроса
        $stmt->execute();
        //заполнение полученным результатом переменных класса
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name                        = $row['first_name'];
        $this->last_name                         = $row['last_name'];
    }

function read_client()
    {
        // выбираем все записи
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, u_c.status, ci.city, co.country FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '123' AND c.city_id = ci.id AND ci.countryid = co.id ORDER BY FIELD(u_c.status, 'exception', 'active', 'inactive')";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    function read_lendlord()
    {
        // выбираем все записи
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, ci.city, co.country
        FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co
        WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '12' AND c.city_id = ci.id AND ci.countryid = co.id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    function read_client_one()
    {
        // выбираем все записи
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.city_id as car_city_id, c.cost as car_cost, ci.id as city_id, ci.city as city_city, ci.countryid as city_countryid, co.id as country_id, co.country as country_country, u_c.status, u_c.photo_passport, u_c.photo_driver_license
        FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co
        WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '123' AND c.city_id = ci.id AND ci.countryid = co.id AND u_c.users_id = :users_id AND u_c.cars_id = :cars_id";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        //привязка данных
        $stmt->bindParam(':users_id', $this->id);
        $stmt->bindParam(':cars_id', $this->car_id);
        // выполняем запрос
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name                        = $row['first_name'];
        $this->last_name                         = $row['last_name'];
        $this->email                             = $row['email'];
        $this->phone                             = $row['phone'];
        $this->role                              = $row['role'];
        $this->users_cars_date_start             = $row['date_start'];
        $this->users_cars_date_end               = $row['date_end'];
        $this->car_model                         = $row['car_model'];
        $this->car_number                        = $row['car_number'];
        $this->car_city_id                       = $row['car_city_id'];
        $this->car_cost                          = $row['car_cost'];
        $this->city_id                           = $row['city_id'];
        $this->city_city                         = $row['city_city'];
        $this->city_countryid                    = $row['city_countryid'];
        $this->country_id                        = $row['country_id'];
        $this->country_country                   = $row['country_country'];
        $this->users_cars_photo_passport         = $row['photo_passport'];
        $this->users_cars_photo_driving_license  = $row['photo_driver_license'];
        $this->users_cars_status                 = $row['status'];
    }

    function read_client_data()
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, u_c.status, ci.city, co.country FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '123' AND c.city_id = ci.id AND ci.countryid = co.id AND u.first_name = :first_name AND u.last_name = :last_name AND u.email = :email ORDER BY FIELD(u_c.status, 'exception', 'active', 'inactive')";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    function read_landlord_data()
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, u_c.status, ci.city, co.country FROM users_cars as u_c, cars as c, users as u, cities as ci, countries as co WHERE u_c.users_id = u.id AND u_c.cars_id = c.id AND ci.id = c.city_id AND ci.countryid = co.id AND u.role = 123 AND u_c.cars_id IN (SELECT cars_id FROM users_cars as u_c WHERE u_c.users_id IN (SELECT id FROM users WHERE role = '12' AND first_name = :first_name AND last_name = :last_name AND email = :email))";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    function read_landlord_car()
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, u_c.status, ci.city, co.country FROM users_cars as u_c, cars as c, users as u, cities as ci, countries as co WHERE u_c.users_id = u.id AND u_c.cars_id = c.id AND ci.id = c.city_id AND ci.countryid = co.id AND u.role = 12 AND u.first_name = :first_name AND u.last_name = :last_name AND u.email = :email";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        //выполнение запроса
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    function read_landlord_all_rent_car()
    {
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u_c.date_start, u_c.date_end, c.model as car_model, c.number as car_number, c.id as car_id, c.city_id as car_city_id, c.cost as car_cost, u_c.status, ci.city, co.country FROM users_cars as u_c, cars as c, users as u, cities as ci, countries as co WHERE u_c.users_id = u.id AND u_c.cars_id = c.id AND ci.id = c.city_id AND ci.countryid = co.id AND u.role = 12 AND c.id IN (SELECT c.id FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '123' AND c.city_id = ci.id AND ci.countryid = co.id AND u.first_name = :first_name AND u.last_name = :last_name AND u.email = :email)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        //выполнение запроса
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    function read_lendlord_one()
    {
        // выбираем все записи
        $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, c.model as car_model, c.number as car_number, c.city_id as car_city_id, c.cost as car_cost, c.photo as car_photo, ci.id as city_id, ci.city as city_city, ci.countryid as city_countryid, co.id as country_id, co.country as country_country
        FROM cars as c, users as u, users_cars as u_c, cities as ci, countries as co
        WHERE c.id = u_c.cars_id AND u.id = u_c.users_id AND u.role = '12' AND c.city_id = ci.id AND ci.countryid = co.id AND u_c.users_id = :users_id AND u_c.cars_id = :cars_id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        //привязка данных
        $stmt->bindParam(':users_id', $this->id);
        $stmt->bindParam(':cars_id', $this->car_id);
        // выполняем запрос
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name               = $row['first_name'];
        $this->last_name                = $row['last_name'];
        $this->email                    = $row['email'];
        $this->phone                    = $row['phone'];
        $this->role                     = $row['role'];
        $this->users_cars_date_start    = $row['date_start'];
        $this->users_cars_date_end      = $row['date_end'];
        $this->car_model                = $row['car_model'];
        $this->car_number               = $row['car_number'];
        $this->car_photo                = $row['car_photo'];
        $this->car_city_id              = $row['car_city_id'];
        $this->car_cost                 = $row['car_cost'];
        $this->city_id                  = $row['city_id'];
        $this->city_city                = $row['city_city'];
        $this->city_countryid           = $row['city_countryid'];
        $this->country_id               = $row['country_id'];
        $this->country_country          = $row['country_country'];
    }


    function delete()
    {
        try {
            $this->conn->beginTransaction();
            //запрос для удаления записи из связанной таблицы
            $query_children = "DELETE FROM users_cars WHERE users_id = :id";
            //подготовка запроса №1
            $stmt = $this->conn->prepare($query_children);
            //очистка №1
            $this->id = htmlspecialchars(strip_tags($this->id));
            //привязываем id записи для удаления №1
            $stmt->bindParam(':id', $this->id);
            //выполняем запрос №1
            $stmt->execute();
            //запрос для удаления записи из основной таблицы
            $query = "DELETE FROM users WHERE id = :id";
            //подготовка запроса №2
            $stmt = $this->conn->prepare($query);

            // очистка №2
            $this->id = htmlspecialchars(strip_tags($this->id));

            //привязываем id записи для удаления №2
            $stmt->bindParam(':id', $this->id);

            //выполняем запрос №2
            $stmt->execute();
            if ($this->conn->commit()) {
                return true;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function delete_client()
    {
        //запрос для удаления записи
        $query = "DELETE FROM users WHERE id = :id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);

        //очистка
        $this->id = htmlspecialchars(strip_tags($this->id));

        //привязываем id записи для удаления
        $stmt->bindParam(':id', $this->id);

        //выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete_rent()
    {
        //запрос для удаления записи
        $query = "DELETE FROM users_cars WHERE users_id = :users_id AND cars_id =:cars_id";
        //подготовка запроса
        $stmt = $this->conn->prepare($query);
        //очистка
        $this->id       = htmlspecialchars(strip_tags($this->id));
        $this->car_id   = htmlspecialchars(strip_tags($this->car_id));

        //привязка записей к запросу
        $stmt->bindParam(":users_id", $this->id);
        $stmt->bindParam(":cars_id", $this->car_id);
        //выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function update_client()
    {
        try {
            $this->conn->beginTransaction();
            $query_user = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone WHERE id = :id";
            $stmt = $this->conn->prepare($query_user);

            //присоединение очищенных значений к запросу
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":id", $this->id);
            //выполняем запрос
            $resultUser = $stmt->execute();
            if (!$resultUser) {
                throw new Exception("Ошибка при обновлении пользователя");
            }
            $query_users_cars = "UPDATE users_cars SET date_start = :date_start, date_end = :date_end WHERE cars_id = :cars_id";
            $stmt_uc = $this->conn->prepare($query_users_cars);

            //присоединение очищеных значений к запросу
            $stmt_uc->bindParam(":date_start", $this->users_cars_date_start);
            $stmt_uc->bindParam(":date_end", $this->users_cars_date_end);
            $stmt_uc->bindParam(":cars_id", $this->car_id);
            //выполнение запроса
            $resultUC = $stmt_uc->execute();
            if ($resultUC && $this->conn->commit()) {
                return true;
            } else {
                throw new Exception("Ошибка при обновлении информации об привязке автомобиля");
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function update_landlord()
    {
        try {
            $this->conn->beginTransaction();
            $query_user = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone WHERE id = :id";
            $stmt = $this->conn->prepare($query_user);

            //присоединение очищенных значений к запросу
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":id", $this->id);
            //выполняем запрос
            $resultUser = $stmt->execute();
            if (!$resultUser) {
                throw new Exception("Ошибка при обновлении пользователя");
            }

            $query_car = "UPDATE cars SET model = :model, number = :number, city_id = :city_id WHERE id = :id";
            $stmt = $this->conn->prepare($query_car);
            //очистка данных
            //присоединение очищенных значений к запросу
            $stmt->bindParam(':model', $this->car_model);
            $stmt->bindParam(':number', $this->car_number);
            $stmt->bindParam(':city_id', $this->city_id);
            $stmt->bindParam(":id", $this->car_id);
            //выполнение запроса
            $resultC = $stmt->execute();
            if ($resultC && $this->conn->commit()) {
                return true;
            } else {
                throw new Exception("Ошибка при обновлении информации об автомобиле");
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function login_admin()
    {
        $query = "SELECT * FROM users WHERE first_name = :first_name AND email = :email";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function update(){}
}
