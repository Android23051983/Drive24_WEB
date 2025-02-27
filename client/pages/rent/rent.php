<div class="container text-center my-2">
    <h2>Заказ автомобиля для ареды</h2>
</div>
    <div class="container bg-secondary p-2 rounded-3">
    <form id="carRentForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="carModel" class="form-label">Модель автомобиля</label>
                <input type="text" class="form-control" id="car_model" name="model" readonly
            </div>
            <div class="mb-3">
                <label for="carNumber" class="form-label">Номер автомобиля</label>
                <input type="text" class="form-control" id="car_number" name="number" readonly>
            </div>
            <div class="mb-3">
                <label for="cityCity" class="form-label">Город</label>
                <input type="text" class="form-control" id="country_city" name="city_id" readonly>
            </div>
            <div class="mb-3">
                <label for="carCost" class="form-label">Стоимость аренды автомобиля руб./сутки</label>
                <input type="text" class="form-control" id="car_cost" name="cost" readonly>
            </div>
             <div class="mb-3">
                <label for="carDateStart" class="form-label">Дата начала аренды</label>
                <input type="date" class="form-control" id="carDateStart" name="date_start" required>
            </div>
             <div class="mb-3">
                <label for="carDateEnd" class="form-label">Дата окончания аренды</label>
                <input type="date" class="form-control" id="carDateEnd" name="date_end" required>
            </div>
            <div class="mb-3">
                <label for="passport_file" class="form-label">Фото паспорта клиента</label>
                <input type="file" class="form-control" id="passport_file" name="passport_file"
                accept="image/*">
            </div>
            <div class="mb-3">
                <label for="driving_license_file" class="form-label">Фото водительских прав клиента</label>
                <input type="file" class="form-control" id="driving_license_file" name="driving_license_file"
                accept="image/*">
            </div>
            <button type="submit" class="btn btn-info">Арендовать</button>
        </form>
    </div>

    <script src="js/rent.js"></script>