async function getCar(id) {
    _data = {id};
    console.log("car_id: ", _data.id);
    try{
        const response = await fetch("/server/car/read_one.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(_data)
        });
        
        if (!response.ok) {
            throw new Error(`Сервер вернул ошибку: ${response.status}`);
        }

        const data          = await response.json();
        const model         = document.getElementById('car_model');
        const number        = document.getElementById('car_number');
        const country_city  = document.getElementById('country_city');
        const cost          = document.getElementById('car_cost');

        const country_city_text = `${data.city_city} (${data.country_country})`;
        console.log(data);
        model.value         = data.model;
        number.value        = data.number;
        country_city.value  = country_city_text; 
        cost.value          = data.cost; 
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}


document.addEventListener('DOMContentLoaded', (event)=>{
    const urlParams = new URLSearchParams(window.location.search);
    const car_id    = urlParams.get('id');
    const date_start    = document.getElementById('carDateStart');
    const date_end      = document.getElementById('carDateEnd');

    date_start.addEventListener('change', (event)=>{
        const selectedDate = event.target.value;
        if(selectedDate) {
            date_end.setAttribute('min', selectedDate);
        } else {
            date_end.removeAttribute('min');
        }
    });

    getCar(car_id);

});

document.getElementById('carRentForm').addEventListener('submit', function(event){
    event.preventDefault();
    const urlParams     = new URLSearchParams(window.location.search);
    const car_id        = urlParams.get('id');
    const user_id       = urlParams.get('user_id');
    const form          = document.getElementById('carRentForm');
    
    const formData = new FormData(form);
    formData.append('car_id', car_id);
    formData.append('user_id', user_id);

     fetch('/server/rent/rent.php', {
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
          window.location.href = "index.php?page=10" // Перезагрузка страницы
    })
    .catch(error => {console.error('Ошибка:', error);
    });
});



