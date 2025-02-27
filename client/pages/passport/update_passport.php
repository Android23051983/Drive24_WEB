<div class="container text-center my-2">
 <h2>Обновление паспортных данных</h2>
 </div>
    <div class="container bg-secondary p-2 rounded-3">
    <form id="passportFormUpdate" >
            <div class="mb-3">
                <label for="passportSeries" class="form-label">Серия</label>
                <input type="text" class="form-control" id="passportSeries" name="series" required>
            </div>
            <div class="mb-3">
                <label for="passportIssued" class="form-label">Выдан</label>
                <input type="text" class="form-control" id="passportIssued" name="issued" required>
            </div>
            <div class="mb-3">
                <label for="passportAddress" class="form-label">Адрес проживания</label>
                <input type="text" class="form-control" id="passportAddress" name="address" required>
            </div>
            <button type="submit" class="btn btn-info border border-dark">Обновить</button>
        </form>
    </div>

    <script src="js/update_passport.js"></script>