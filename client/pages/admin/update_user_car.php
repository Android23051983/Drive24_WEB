 <div class="container text-center my-2">
 <h2 class='text-center'>Данные для редактирования</h2>
 </div>
    <div class="container bg-secondary p-2 rounded-3">
    <form id="updateAdminForm">
            <input type="hidden" id="userId" name="id">
            <div class="mb-3">
                <label for="userFirstName" class="form-label">Имя</label>
                <input type="text" class="form-control" id="userFirstName" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="userLastName" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="userLastName" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="userEmailr" class="form-label">Email</label>
                <input type="text" class="form-control" id="userEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="userPhone" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="userPhone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="userDateStart" id="formDateStart" class="form-label">Дата начала аренды</label>
                <input type="text" class="form-control" id="userDateStart" name="date_start">
            </div>
            <div class="mb-3">
                <label for="userDateEnd" id="formDateEnd" class="form-label">Дата окончания аренды</label>
                <input type="text" class="form-control" id="userDateEnd" name="date_end" >
            </div>
            <input type="hidden" id="car_id" name="car_id">
            <div class="mb-3">
                <label for="carModel" class="form-label">Автобиль</label>
                <input type="text" class="form-control" id="carModel" name="car_model" required>
            </div>
            <div class="mb-3">
                <label for="carNumber" class="form-label">Номер автомобиля</label>
                <input type="text" class="form-control" id="carNumber" name="car_number" required>
            </div>
            <div class="mb-3">
                <label for="carCost" class="form-label">Стоимость аренды в руб./сутки</label>
                <input type="text" class="form-control" id="carCost" name="car_cost" required>
            </div>
            <div class="mb-3">
                <label for="countryCountry" id="countryname_label" class="form-label">Страна</label>
                <select name="country_id" id="countryname" onchange="getCitySelect()" class="form-select">
                </select>
            </div>
            <div class="mb-3">
                <label for="cityCity" id="cityname_label" class="form-label">Город</label>
                <select name="city_id" id="cityname" class="form-select">
                </select>
            </div>
            <button type="submit" class="btn btn-info">Изменить</button>
        </form>
    </div>
    <script src="js/admin_update.js"></script>

