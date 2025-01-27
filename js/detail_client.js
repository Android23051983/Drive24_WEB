document.addEventListener('DOMContentLoaded', async () => {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get('car_id');
        const userId = urlParams.get('user_id');
        const _data = { carId, userId };
        console.log(carId, userId);

        const response = await fetch("/user/read_client_one.php", {
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
        const title_client = document.getElementById('title_client');
        title_client.innerHTML = `Данные аренды автомобиля клиентом ${data.first_name} ${data.last_name}`;
        let status = data.status;

        switch (status) {
            case 'exception':
                status = 'На проверке';
                break;
            case 'active':
                status = 'Активная аренда';
                break;
            case 'inactive':
                status = 'Аренда окончена';
                break;
        }

        let cardHtml = `
        <div class="card mb-3">
          <div class="row g-0 p-2">
            <div class="col-md-4">
              <img src="${data.photo_passport}" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-4">
              <img src="${data.photo_driver_license}" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-4">
              <div class="card-body">
                <h5 class="card-title">Клиент</h5>
                <p class="card-text">
                  <strong>ФИО:</strong> ${data.first_name} ${data.last_name}<br>
                  <strong>Телефон:</strong> ${data.phone}<br>
                  <strong>Email:</strong> ${data.email}<br>
                  <strong>Дата начала аренды:</strong> ${data.date_start}<br>
                  <strong>Дата окончания аренды:</strong> ${data.date_end}<br>
                </p>
                <h5 class="card-title">Арендуемый автомобиль</h5>
                <p class="card-text">
                  <strong>Модель:</strong> ${data.car_model}<br>
                  <strong>Номер:</strong> ${data.car_number}<br>
                  <strong>Город аренды авто:</strong> ${data.city_city} (${data.country_country})
                </p>
                <h5 class="card-title">Статус аренды: ${status}</h5>
              </div>
              <div class="container">
        `;

        // Добавляем кнопку подтверждения аренды только для статуса 'exception'
        if (data.status === 'exception') {
            cardHtml += `
              <button class="rounded bg-info" onclick="verifyRental(${data.id}, ${data.car_id})">Подтвердить аренду</button>
            `;
        }

        cardHtml += `
              </div>
            </div>
          </div>
        </div>
        `;

        detailCard.innerHTML = cardHtml;

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
});

async function verifyRental(user_id, car_id) {
  data = {user_id, car_id};
try {
  const response = await fetch("/rent/rent_verify.php", {
    method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
  });
  if(response.ok){
    window.location.href = `index.php?page=2`;
  }
} catch(error){
  console.log("Error rent: ", error);
}

} 