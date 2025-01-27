document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const car_number = urlParams.get('car_number');
    const _data = { car_number };
    console.log(_data);
    const response = await fetch("/car/read_one_number.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(_data)
    });

    if (!response.ok) {
            if(response.status == 404)
            window.alert('Автомобиль с указанным номером не найден');
            window.location.assign('index.php')
    } else {
    const data = await response.json();
    const search_card = document.getElementById('search_card');
    const title_search = document.getElementById('title_search');
    title_search.innerHTML = `Данные на автомобиль модель ${data.model} номер ${data.number}`;
    let cardHtml = `
        <div class="card mb-3">
          <div class="row g-0 p-2">
            <div class="col-md-7">
              <img src="${data.photo}" class="img-fluid " alt="...">
            </div>
            <div class="col-md-5">
              <div class="card-body">
                <h5 class="card-title">Автомобиль</h5>
                <p class="card-text">
                  <strong>Модель:</strong> ${data.model}<br>
                  <strong>Номер:</strong> ${data.number}<br>
                  <strong>Город аренды авто:</strong> ${data.city_city} (${data.country_country})<br>
                  <strong>Стоимость аренды:</strong> ${data.cost} рублей/сутки
                </p>
              </div>
              <div class="container">
               </div>
            </div>
          </div>
        </div>
        `;

        search_card.innerHTML = cardHtml;
    }
});