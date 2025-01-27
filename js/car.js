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
    const _data = {countryid};
    citySelect.innerHTML="";

    if(!countryid){
        citySelect.disabled = true;
        return;
    }
    fetch("/country_city/read_city.php",{
        method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(_data)
    })
        .then(response => response.json())
        .then(data => {
            const cityname = document.getElementById('cityname');
            //очистка списка при добавлении новых значений
            cityname.innerHTML='';
            // Добавляем первую опцию "Выберите страну..."
            const firstOption = document.createElement('option');
            firstOption.textContent = 'Выберите город...';
            firstOption.setAttribute('selected', '');
            firstOption.setAttribute('disabled', '');
            cityname.appendChild(firstOption);
            // прохождение по каждому элементу данных и создание option
            data.forEach(item =>{
                const option = document.createElement('option');
                option.value = item.cityid;
                option.textContent = item.city;
                cityname.appendChild(option);
            });
        })
        .catch(error => console.error('Ошибка при получении данных:', error));
}


document.addEventListener('DOMContentLoaded', async () => {
    getCountrySelect();
    await getTableCar();

});

document.getElementById('carForm').addEventListener('submit', function(event){
    event.preventDefault();
    // Получаем элементы формы
    const form = document.getElementById('carForm');
    const modelInput = document.getElementById('carModel');
    const numberInput = document.getElementById('carNumber');
    const countryName = document.getElementById('countryname');
    const cityName = document.getElementById('cityname');
    const costInput = document.getElementById('carCost');
    const photoInput = document.getElementById('file_attach');
    // Получаем данные из формы
    const model = modelInput.value;
    const number = numberInput.value;
    const countryId = countryName.value;
    const cityId = cityName.value;
    const cost = costInput.value;
    const photo = photoInput.files[0];
    console.log(photo);
    const formData = new FormData();
    formData.append('model', model);
    formData.append('number', number);
    formData.append('countryId', countryId);
    formData.append('cityId', cityId);
    formData.append('cost', cost);
    formData.append('file', photoInput.files[0]);

    fetch('/car/create.php', {
        method: "POST",
        body: formData
    })
    .then(response => {
        if(response.ok) {
            return response.json();
        } else {
            throw new Error('Что-то пошло не так.');
        }
    })
    .then(data => {console.log(`${data.message}`);
          window.location.href = "index.php?page=9"; // Перезагрузка страницы
    })
    .catch(error => {console.error('Ошибка:', error);
    });
});





