    <div class="container text-center my-2">
    <h2>Панель администратора</h2>
    </div>
    <!-- здесь будет выводиться наша информация -->
    <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
    <div class="container my-2">
    <h3 class="mb-4">Страны</h3>
    </div>
    <div class="bg-secondary p-2 rounded-3">
    <form id = "jsonCountryForm">
        <div class='form-group my-2'>
        <input type='text' class='form-control' name='country' placeholder='Введите название страны...' >
        </div>
        <button class='btn , border border-dark btn-info my-2' name='addcountry' type='submit'>Сохранить</button>
    </form>    
        <div class='form-group my-3 table-responsive overflow-auto' style='max-height: 36vh'>
        <table class='table table-striped align-middle text-center'>
            <thead class='table-warning sticky-top'>
                <tr>
                    <th scope="col" class="hiden-on-mobile show-on-desctop">ID</th>
                    <th scope="col">Страна</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody id="table_country">
            </tbody>
        </table>
        </div>
    </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
    <div class="container my-2">
    <h3 class="mb-4">Города</h3>
    </div>
    <div class="bg-secondary p-2 rounded-3">
            <div class='form-group my-2'>
            <form id = "jsonCityForm">
                <select name="countryid" id="countryname" onchange="getTable_City()" class="form-select">
                </select>
            </div>
            <div class='form-group my-2'>
                <input type='text' class='form-control' name='city' placeholder='Введите название города...'>
            </div>
            <button class='btn border border-dark btn-info my-2' name='addcity' type='submit'>Сохранить</button>
            </form>
            <div class='form-group my-3 table-responsive overflow-auto' style='max-height: 30vh'>
                <table class='table table-striped align-middle text-center'>
                    <thead class='table-warning sticky-top'>
                        <tr>
                            <th scope="col" class="hiden-on-mobile show-on-desctop">ID</th>
                            <th scope="col">Город</th>
                            <th scope="col">Страна</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="table_city">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="my-2">
    <h3>Клиенты </h3>
    </div>
    <div id="client"></div>
    <div class="my-2">
    <h3>Владельцы</h3>
    </div>
    <div id="lendlord"></div>
    <script src="js/admin.js"></script>
