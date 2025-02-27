<?php
  session_start(); // Включение сессии

  if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
  }
?>

 <div class="container text-center my-2">
 <h2>Данные для добавления автомобиля</h2>
 </div>
    <div class="container bg-secondary p-2 rounded-3">
    <form id="carForm" >
            <div class="mb-3">
                <label for="carModel" class="form-label">Модель автомобиля</label>
                <input type="text" class="form-control" id="carModel" name="model" required>
            </div>
            <div class="mb-3">
                <label for="carNumber" class="form-label">Номер автомобиля</label>
                <input type="text" class="form-control" id="carNumber" name="number" required>
            </div>
            <div class="mb-3">
                <label for="countryCountry" class="form-label">Страна</label>
                <select name="countryid" id="countryname" onchange="getCitySelect()" class="form-select">
                </select>
            </div>
            <div class="mb-3">
                <label for="cityCity" class="form-label">Город</label>
                <select name="cityid" id="cityname" class="form-select" >
                </select>
            </div>
            <div class="mb-3">
                <label for="carCost" class="form-label">Стоимость аренды автомобиля руб./сутки</label>
                <input type="text" class="form-control" id="carCost" name="cost" required>
            </div>
            <div class="mb-3">
                <label for="file_attach" class="form-label">Фото автомобиля</label>
                <input type="file" class="form-control" id="file_attach" name="file_attach"
                accept="image/*">
            </div>
            <button type="submit" class="btn btn-info">Добавить</button>
        </form>
    </div>
    
    <script src="js/car.js"></script>

