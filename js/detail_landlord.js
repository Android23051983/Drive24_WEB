document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const carId = urlParams.get('car_id');
    const userId = urlParams.get('user_id');
    const _data = { carId, userId };

    const response = await fetch("/user/read_landlord_one.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(_data)
    });

    if (!response.ok) {
            throw new Error(`Сервер вернул ошибку: ${response.status}`);
    }

    const data = await response.json();
    const detailCard = document.getElementById('detail_card');
    const title_landlord = document.getElementById('title_landlord');
    title_landlord.innerHTML = `Данные на авто владельца ${data.first_name} ${data.last_name}`;
    let cardHtml = `
        <div class="card mb-3">
          <div class="row g-0 p-2">
            <div class="col-md-7">
              <img src="${data.car_photo}" class="img-fluid " alt="...">
            </div>
            <div class="col-md-5">
              <div class="card-body">
                <h5 class="card-title">Автомобиль</h5>
                <p class="card-text">
                  <strong>Модель:</strong> ${data.car_model}<br>
                  <strong>Номер:</strong> ${data.car_number}<br>
                  <strong>Город аренды авто:</strong> ${data.city_city} (${data.country_country})<br>
                  <strong>Стоимость аренды:</strong> ${data.car_cost} рублей/сутки
                </p>
                
                
              </div>
              <div class="container">
               </div>
            </div>
          </div>
        </div>
        `;

        detailCard.innerHTML = cardHtml;
});