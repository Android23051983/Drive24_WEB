function getCountrySelect() {
    //Вывод списка стран для добавления города.
    fetch("/country_city/read_country.php")
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


function getCitySelect() {
    //Вывод списка стран для добавления города.
    const citySelect = document.getElementById('cityname');
    const countryid = document.getElementById('countryname').value;
    const data = {countryid};
    citySelect.innerHTML="";

    // if(!countryid){
    //     citySelect.disabled = true;
    //     return;
    // }
    fetch("/country_city/read_city.php",{
        method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            // const cityname = document.getElementById('cityname');
            //очистка списка при добавлении новых значений
            // cityname.innerHTML='';
            // Добавляем первую опцию "Выберите страну..."
            const firstOption = document.createElement('option');
            firstOption.textContent = 'Выберите город...';
            firstOption.setAttribute('selected', '');
            firstOption.setAttribute('disabled', '');
            citySelect.appendChild(firstOption);
            // прохождение по каждому элементу данных и создание option
            data.forEach(item =>{
                const option = document.createElement('option');
                option.value = item.cityid;
                option.textContent = item.city;
                citySelect.appendChild(option);
            });
            citySelect.disable = false;
        })
        .catch(error => console.error('Ошибка при получении данных:', error));
}

async function setSelectedValue(country_id, city_id){
    const citySelect    = document.getElementById('cityname');
    const countrySelect = document.getElementById('countryname');

    Array.from(countrySelect.options).forEach(option =>{
        if(option.value == country_id){
            option.selected = true;
        }
    });

    Array.from(citySelect.options).forEach(option =>{
        if(option.value == city_id){
            option.selected = true;
        }
    });
}

async function load_data(userId, carId, role) {
    const payload = { userId, carId, role };
    if(role == 12){
    try {
        const response = await fetch("/user/read_landlord_one.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        if (!response.ok) {
            throw new Error(`Сервер вернул ошибку: ${response.status}`);
        }
        
        const data = await response.json();
        const userId            = document.getElementById('userId');
        const userFirstName     = document.getElementById('userFirstName');
        const userLastName      = document.getElementById('userLastName');
        const userEmail         = document.getElementById('userEmail');
        const userPhone         = document.getElementById('userPhone');
        const car_id            = document.getElementById('car_id');
        const carModel          = document.getElementById('carModel');
        const carNumber         = document.getElementById('carNumber');
        const carCost           = document.getElementById('carCost');

        const userDateStart     = document.getElementById('userDateStart');
        const userDateEnd       = document.getElementById('userDateEnd');

        const formDateStart     = document.getElementById('formDateStart');
        const formDateEnd       = document.getElementById('formDateEnd'); 
        
        // Предполагаем, что данные приходят в формате объекта, а не массива
        userId.value            = data.id;
        userFirstName.value     = data.first_name;
        userLastName.value      = data.last_name;
        userEmail.value         = data.email;
        userPhone.value         = data.phone;
        car_id.value            = data.car_id;
        carModel.value          = data.car_model;
        carNumber.value         = data.car_number;
        carCost.value           = data.car_cost;

        userDateStart.disable = true;
        userDateStart.style.display = 'none';
        userDateEnd.disable = true;
        userDateEnd.style.display = 'none';

        formDateStart.style.display = 'none';
        formDateEnd.style.display = 'none';
       

        
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
    }
    if(role == 123){
        try {
        const response = await fetch("/user/read_client_one.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        if (!response.ok) {
            throw new Error(`Сервер вернул ошибку: ${response.status}`);
        }
        
        const data = await response.json();
        const userId            = document.getElementById('userId');
        const userFirstName     = document.getElementById('userFirstName');
        const userLastName      = document.getElementById('userLastName');
        const userEmail         = document.getElementById('userEmail');
        const userPhone         = document.getElementById('userPhone');
        const carModel          = document.getElementById('carModel');
        const carNumber         = document.getElementById('carNumber');
        const carCost           = document.getElementById('carCost');

        const userDateStart     = document.getElementById('userDateStart');
        const userDateEnd       = document.getElementById('userDateEnd');
        const country           = document.getElementById('countryname');
        const city              = document.getElementById('cityname');
        const country_label     = document.getElementById('countryname_label');
        const city_label        = document.getElementById('cityname_label')

        
        // Предполагаем, что данные приходят в формате объекта, а не массива
        userId.value            = data.id;
        userFirstName.value     = data.first_name;
        userLastName.value      = data.last_name;
        userEmail.value         = data.email;
        userPhone.value         = data.phone;
        carModel.value          = data.car_model;
        carNumber.value         = data.car_number;
        carCost.value           = data.car_cost;
        
        userDateStart.value     = data.date_start;
        userDateEnd.value       = data.date_end;

        carModel.readOnly   = true;
        carNumber.readOnly  = true;
        carCost.readOnly    = true;
        country.disable     = true;
        country.style.display = 'none';
        city.disable        = true;
        city.style.display = 'none';
        country_label.style.display = 'none';
        city_label.style.display    = 'none';

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
    }
}

document.addEventListener('DOMContentLoaded', async () => { 
    const urlParams = new URLSearchParams(window.location.search);
    const userid = urlParams.get('userid');
    const carid  = urlParams.get('carid');
    const role = urlParams.get('role');
    if (userid && carid) {
        console.log(`Полученный USER ID: ${userid}, Полученный CAR ID: ${carid}, Полученный USER ROLE: ${role}`);
        getCountrySelect();
        await load_data(userid, carid, role);      
    }
    
});

async function sendJsonToServer(formId, url){
    const form = document.getElementById(formId);
    const data = {};

    Array.from(new FormData(form)). forEach(([key, value]) =>{
        data[key] = value;
    });
    console.log(data);

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
        alert(`${result.message}`);
    }catch(error){
        console.error(`${formId}: There has been a problem with your fetch operation:`, error);
    }
}

document.getElementById('updateAdminForm').addEventListener('submit', async function(event){
    event.preventDefault();
    const urlParams = new URLSearchParams(window.location.search);
    const _role = urlParams.get('role');
    if(_role == 123){
    	await sendJsonToServer('updateAdminForm', '/user/update_client.php');
    } else if(_role == 12){
    	await sendJsonToServer('updateAdminForm', '/user/update_landlord.php')
    }
    // location.reload();
    
});



