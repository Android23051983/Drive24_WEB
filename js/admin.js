//Функции для последующего выполнения во время запуска web страницы
async function getCountrySelect() {
    //Вывод списка стран для добавления города.
    await fetch("/country_city/read_country.php")
        .then(response => response.json())
        .then(data => {
            const countryname = document.getElementById('countryname');
            //очистка списка при добавлении новых значений
            countryname.innerHTML='';
            // Добавляем первую опцию "Выберите страну..."
            const firstOption = document.createElement('option');
            firstOption.textContent = 'Выберите страну...';
            firstOption.setAttribute('selected', '');
            firstOption.setAttribute('disabled', '');
            countryname.appendChild(firstOption);
            // прохождение по каждому элементу данных и создание option
            data.forEach(item =>{
                const option = document.createElement('option');
                option.value = item.countryid;
                option.textContent = item.country;
                countryname.appendChild(option);
            });
        })
        .catch(error => console.error('Ошибка при получении данных:', error));
}

async function getTable_Country() {
    try{
    await fetch("/country_city/read_country.php")
        .then(response => response.json())
        .then(data => {
             const table_country = document.getElementById('table_country');
            table_country.innerHTML = '';
            
            //добавоение табличной части с данными
            data.forEach(country => {
            const newRow = document.createElement('tr');
            //создаем ячейки
            const cells = [country.countryid, country.country];
            cells.forEach(cellData =>{
                const newCell = document.createElement('td');
                newCell.textContent= cellData;
                newRow.appendChild(newCell);
            });
            // Добавляем последнюю колонку с кнопкой 
            const deleteBtnCell = document.createElement('td');
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Удалить';
            deleteBtn.classList.add('btn', 'border', 'border-dark', 'bg-info', 'text-dark', 'rounded-3'); // Можно добавить класс для стилизации
            deleteBtn.setAttribute('data-id', country.countryid);
            deleteBtn.onclick = () => countryDelete(country.countryid); // Привязываем функцию удаления города
            deleteBtnCell.appendChild(deleteBtn);
            newRow.appendChild(deleteBtnCell);
            // Добавим новую строку в <tbody>
            table_country.appendChild(newRow);
    });
        })
        .catch(error => console.error('Ошибка при получении данных:', error));
    }catch(error){
        console.log("В данный момент стран в Базе Данных нет");
    }
}

async function getTable_City() {
    const countryid = document.getElementById('countryname').value;
    const data = {countryid};
    
    try{
    await fetch("/country_city/read_city.php",{
       method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data =>{
            const table_city = document.getElementById('table_city');
            table_city.innerHTML = '';
            
            //добавоение табличной части с данными
            data.forEach(city => {
            const newRow = document.createElement('tr');
            //создаем ячейки
            const cells = [city.cityid, city.country, city.city];
            cells.forEach(cellData =>{
                const newCell = document.createElement('td');
                newCell.textContent= cellData;
                newRow.appendChild(newCell);
            });
            // Добавляем последнюю колонку с кнопкой 
            const deleteBtnCell = document.createElement('td');
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Удалить';
            deleteBtn.classList.add('btn', 'border', 'border-dark', 'bg-info', 'text-dark', 'rounded-3'); // Можно добавить класс для стилизации
            deleteBtn.setAttribute('data-id', city.cityid);
            deleteBtn.onclick = () => cityDelete(city.cityid); // Привязываем функцию удаления города
            deleteBtnCell.appendChild(deleteBtn);
            newRow.appendChild(deleteBtnCell);
            // Добавим новую строку в <tbody>
            table_city.appendChild(newRow);
    });
            
        })
        .catch(error => console.error('Ошибка при получении данных:', error));
    }catch(error) {
        console.log("В данный момент городов в Базе Данных нет");
    }
}

async function getTableUser_Clien() {
    try {
        const response = await fetch('/user/read_client.php');

        if (!response.ok) {
            throw new Error(`Сервер ответил с кодом: ${response.status}`);
        }

        const data = await response.json();

        if (!data || !Array.isArray(data) || !data.length) {
            throw new Error('Данные отсутствуют или имеют неверный формат');
        }

        const client = document.getElementById('client');
        client.innerHTML = ''; // Очищаем содержимое элемента

        let output = `<table class="table table-bordered">
            <thead class="table-warning sticky-top text-center">
                <tr>
                    <th scope="col">Имя</th> 
                    <th scope="col">Фамилия</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">email</th> 
                    <th scope="col">Телефон</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">Дата начала аренды</th>
                    <th scope="col">Автомобиль</th>
                    <th scope="col">Номер автомобиля</th>
                    <th scope="col">Город</th>
                    <th scope="col">Статус</th> 
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <tr>`;

        data.forEach(function(item) {
            let statusText;
            switch (item.status) {
                case 'exception':
                    statusText = 'На проверке';
                    break;
                case 'active':
                    statusText = 'Активная аренда';
                    break;
                case 'inactive':
                    statusText = 'Аренда окончена';
                    break;
            }
            output += `
                 <tr>
                     <td>${item.first_name}</td>
                     <td>${item.last_name}</td>
                     <td class="hide-on-mobile show-on-desktop">${item.email}</td>
                     <td>${item.phone}</td>
                     <td class="hide-on-mobile show-on-desktop">${item.date_start}</td>
                     <td>${item.car_model}</td>
                     <td>${item.car_number}</td>
                     <td>${item.city} (${item.country})</td>
                     <td>${statusText}</td>
                     <td>
                         <div class="container d-flex justify-content-center">
                             <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="(()=> { update(${item.id}, ${item.car_id}, ${item.role});})()">Изменить</button>
                             <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="(()=> { rentDelete(${item.id}, ${item.car_id});})()">Отмена аренды</button>
                            <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="(()=> { detail(${item.id}, ${item.car_id}); })()">Подробно - Аренда</button>
                         </div>
                     </td>
                 </tr>`;
        });

        output += `
             </tr>
           </tbody>
         </table>`
        client.innerHTML += output; // Добавляем данные в элемент
    } catch (error) {
        const client = document.getElementById('client');
        console.error('Произошла ошибка:', error.message);
        client.innerHTML = `<table class="table table-bordered">
            <thead class="table-warning sticky-top text-center">
                <tr>
                    <th scope="col">Имя</th> 
                    <th scope="col">Фамилия</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">email</th> 
                    <th scope="col">Телефон</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">Дата начала аренды</th>
                    <th scope="col">Автомобиль</th>
                    <th scope="col">Номер автомобиля</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <tr>
            </tr>
           </tbody>
         </table>`;
    }
}

async function getTableUser_Lendlord() {

    try {
        const response = await fetch('/user/read_lendlord.php');

        if (!response.ok) {
            throw new Error(`Сервер ответил с кодом: ${response.status}`);
        }

        const data = await response.json();

        if (!data || !Array.isArray(data) || !data.length) {
            throw new Error('Данные отсутствуют или имеют неверный формат');
        }

        const app = document.getElementById('lendlord');
        app.innerHTML = ''; // Очищаем содержимое элемента

        let output = `<table class="table table-bordered">
            <thead class="table-warning sticky-top text-center">
                <tr>
                    <th scope="col">Имя</th> 
                    <th scope="col">Фамилия</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">email</th> 
                    <th scope="col">Телефон</th> 
                    <th scope="col">Автомобиль</th>
                    <th scope="col">Номер автомобиля</th>
                    <th scope="col">Город</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <tr>`;

        data.forEach(function(item) {
            output += `
                 <tr>
                     <td>${item.first_name}</td>
                     <td>${item.last_name}</td>
                     <td class="hide-on-mobile show-on-desktop">${item.email}</td>
                     <td>${item.phone}</td>
                     <td>${item.car_model}</td>
                     <td>${item.car_number}</td>
                     <td>${item.city} (${item.country})</td>
                     <td>
                         <div class="container d-flex justify-content-center">
                             <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="(()=> { update(${item.id}, ${item.car_id}, ${item.role});})()">Изменить</button>
                             <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="carDelete(${item.car_id})">Удаление авто</button>
                            <button class="btn border border-dark bg-info text-dark rounded-3 me-1" onclick="(()=> { detail_landlord(${item.id}, ${item.car_id}); })()">Подробно</button>
                         </div>
                     </td>
                 </tr>`;
        });

        output += `
             </tr>
           </tbody>
         </table>`
        app.innerHTML += output; // Добавляем данные в элемент
    } catch (error) {
        const app = document.getElementById('lendlord');
        console.error('Произошла ошибка:', error.message);
        app.innerHTML = `<table class="table table-bordered">
            <thead class="table-warning sticky-top text-center">
                <tr>
                    <th scope="col">Имя</th> 
                    <th scope="col">Фамилия</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">email</th> 
                    <th scope="col">Телефон</th> 
                    <th scope="col" class="hide-on-mobile show-on-desktop">Дата начала аренды</th>
                    <th scope="col">Автомобиль</th>
                    <th scope="col">Номер автомобиля</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <tr>
            </tr>
           </tbody>
         </table>`;
    }

}

//Выполнение вышеописанных функций в момент загрузки web страницы
document.addEventListener('DOMContentLoaded', async () => {
        await getCountrySelect(); //Вывод списка стран для добавления города
        await getTable_Country();//запрос и формирование табличных данных для таблицы страны
        // await getTable_City();//запрос и формирование табличных данных для таблицы городов
        await getTableUser_Clien();//формирование таблицы клиентов с привязанными авто
        await getTableUser_Lendlord();//формирование таблици арендодателей с авто
});


// Вспомогательные функции для button не требующие выполнения при загрузки web страницы.
// Удаление страны
async function countryDelete(countryid) {
    const data = {countryid};

    try{
        const response = await fetch('/country_city/delete_country.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log(response.json());
        location.reload(); //перезагрузка странички на которой выполяется данный код
    } catch(error) {
        throw new Error('Не удалось отправить запрос на сервер. ', error);
    }
}
// Удаление города
async function cityDelete(cityid) {
     const data = {cityid};

    try{
        const response = await fetch('/country_city/delete_city.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log(response.json());
        location.reload(); //перезагрузка странички на которой выполяется данный код
    } catch(error) {
        throw new Error('Не удалось отправить запрос на сервер. ', error);
    }
}
// Удаление клиента
async function rentDelete(user_id, car_id) {
    const data = {user_id, car_id};

    try{
        const response = await fetch('/user/delete_rent.php', {
             method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log(response.json());
        location.reload();//перезагрузка странички на которой выполяется данный код
    }catch(error){
        throw new Error('Не удалось отправить запрос на сервер.', error);
    }
}
// Удаление арендодателя
async function carDelete(id) {
    const data = {id};

    try{
        const response = await fetch('/car/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log(response.json());
        location.reload();//перезагрузка странички на которой выполяется данный код
    }catch(error){
        throw new Error('Не удалось отправить запрос на сервер.');
    }
}

// Общая функция отпарвки данных на сервер для всех форм добавления на странице
async function sendJsonToServer(formId, url){
    const form = document.getElementById(formId);
    const data = {};

    Array.from(new FormData(form)). forEach(([key, value]) =>{
        data[key] = value;
    });

    try{
        const response = await fetch(url, {
            method:'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if(!response) {
            throw new Error(`Network response was not ok ${response.status}`);
        }
        const result = await response.json();
        console.log(`${formId}:`,result);
    }catch(error){
        console.error(`${formId}: There has been a problem with your fetch operation:`, error);
    }
}

// Обработчики событий форм на странице с использованием вышеописанной функции
// Обработка создания страны
document.getElementById('jsonCountryForm').addEventListener('submit', async function(event){
    event.preventDefault();
    await sendJsonToServer('jsonCountryForm', '/country_city/create_country.php');
    location.reload();
});
// Обработка создания города
document.getElementById('jsonCityForm').addEventListener('submit', async function(event){
    event.preventDefault();
    
    await sendJsonToServer('jsonCityForm', '/country_city/create_city.php');
    location.reload();
});

function update(user_id, car_id, role) {
    const data = {user_id, car_id, role}; 
    window.location.href = `index.php?page=5&userid=${data.user_id}&carid=${data.car_id}&role=${data.role}`;
}

function detail(user_id, car_id) {
    const data = {user_id, car_id};
    window.location.href = `index.php?page=6&user_id=${data.user_id}&car_id=${data.car_id}`;
}

function detail_landlord(user_id, car_id) {
    const data = {user_id, car_id};
    window.location.href = `index.php?page=7&user_id=${data.user_id}&car_id=${data.car_id}`;
}

