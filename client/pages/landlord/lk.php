<?php
  session_start(); // Включение сессии

  if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Календарь арендованных автомобилей</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js'></script>
</head>
<body>
<div class="left-col">
  <div class="container">
  <div class="text-center">
    <h2>Данные владельца<br/></h2>
    <h3>Паспорт<br/></h3>
  </div>
  <div class="bg-secondary p-2">
  <div>
  <label style="color: #DCDCDC;">Серия<br></label>
  <p class="bg-white border p-1 h-100" id="passport_series"> </p>
  </div>
  <div>
  <label style="color: #DCDCDC;"">Выдан<br></label>
  <p class="bg-white border p-1 h-100" id="passport_issued"></p>
  </div>
  <div>
  <label style="color: #DCDCDC;"">Адрес проживания<br></label>  
  <p class="bg-white border p-1 h-100" id="passport_address"></p>
  </div>
  </div>
  <div class="text-center">
    <a id="passport_add" class="nav-link border border-dark bg-info text-dark rounded-3 me-1" href="index.php?page=12">Добавить данные паспорта</a>
  </div>
  <div class="text-center">
    <a id="passport_add" class="nav-link border border-dark bg-info text-dark rounded-3 me-1" href="index.php?page=14">Обновление данные паспорта</a>
  </div>
  </div>
</div>
<div class="right-col">
  <div class="container">
  <div class="text-center">
    <h2>Календарь арендованных автомобилей </h1>
    </div>
    <div id="calendar" class="m-1"></div>
    <h2>Автомобили взятые в аренду</h2>
    <div id="datatbl" class="m-1"></div>
    <h2>Автомобили сданные в аренду</h2>
    <div id="renttbl" class="m-1"></div>
  </div>
  </div>
  <script>

const userData = <?php echo json_encode([
'first_name' => $_SESSION['user']->first_name,
'last_name' => $_SESSION['user']->last_name,
'email' => $_SESSION['user']->default_email
]); ?>;

async function getLandlordData() {
    const url = '/server/user/read_landlord_data.php';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
    };

    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching landlord data:', error);
        throw error;
    }
}

async function getPassport() {
  try{
  const response = await fetch('/server/passport/read.php',{
    method: 'GET'
  });

   // Проверяем успешность ответа
    if (!response.ok) {
      throw new Error(`Network response was not ok: ${response.status}`);
    }

    const data = await response.json();

    if(typeof data !== 'object' || Array.isArray(data)){
        throw new Error('Invalid response format from server.');
    }
    let passportDataAvailable = false;
    console.log(`${data.series}, ${data.issued}, ${data.address}`)
    if( 
      data.series !== null &&
      data.issued !== null &&
      data.address !== null) {
      //заполняем HTML документы
      document.getElementById('passport_series').textContent = data.series;
      document.getElementById('passport_issued').textContent = data.issued;
      document.getElementById('passport_address'). textContent = data.address;

      passportDataAvailable = true;
    }
    function handlePreventClick(event){
      event.preventDefault();
    }
    if(passportDataAvailable) {
       //Отключаем возможность взаимодействовать с кнопкой passport_add
    const passport_add = document.getElementById('passport_add');
    passport_add.addEventListener('click', handlePreventClick);
    passport_add.style.pointerEvents = 'none'; // Делаем ссылку неактивной для событий мыши
    passport_add.style.color = 'gray'; // Меняем цвет текста на серый
    } else {
      // Получаем элемент
      const passport_add = document.getElementById('passport_add');

      // Удаляем обработчик события click
      passport_add.removeEventListener('click', handlePreventClick);

      // Сбрасываем CSS-свойства
      passport_add.style.pointerEvents = ''; // Возвращаем обычное поведение событий мыши
      passport_add.style.color = ''; // Сбрасываем цвет текста (он вернется к значению по умолчанию)
    }
  
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
    // throw error; // Пропускаем ошибку дальше, если нужно
  }
}

async function getLandlordCar() {
    const url = '/server/user/read_landlord_car.php';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
    };

    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching landlord car data:', error);
        throw error;
    }
}


async function initializeCalendar() {
    try {
    const data = await getLandlordData();
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
         locale: 'ru',
         initialView: 'dayGridMonth',
         headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          events: data.map(item => {
        // Создаём новые объекты Date для начала и конца
        const startDate = new Date(item.date_start);
        const endDate = new Date(item.date_end);

        // Добавляем время 8:00 к начальной дате
        startDate.setHours(1, 0, 0, 0);

        // Добавляем время 23:59 к конечной дате
        endDate.setHours(23, 59, 59, 999);

        return {
          title: `${item.car_model} ${item.car_number}`,
          start: startDate.toISOString(),
          end: endDate.toISOString()
        };
      })
    });
    calendar.render();
    }catch(error) {
        console.error(error);
    }
}

async function tblRentData() {
  try {
  const data = await getLandlordData();
  const datatbl = document.getElementById('datatbl');

  let tableContent = `
    <table class="table table-bordered table-striped">
  <thead class="table-warning sticky-top text-center">
    <tr>
      <th scope="col">Арендатор</th>
      <th scope="col">Телефон</th>
      <th scope="col">Email</th>
      <th scope="col">Маркаарка</th>
      <th scope="col">Номер</th>
      <th scope="col">Статус аренды</th>
    </tr>
  </thead>
  <tbody>
  `;
  for (const item of data) {
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
    tableContent += `
    <tr>
      <td>${item.first_name} ${item.last_name}</tb>
      <td>${item.phone}</tb>
      <td>${item.email}</tb>
      <td>${item.car_model}</tb>
      <td>${item.car_number}</tb>
      <td>${statusText}</td>
    </tr>
  `;
  }
  tableContent += `
  </tbody>
    </table>
  `;
  datatbl.innerHTML = tableContent;
  } catch (error) {
        console.error('Error rendering rent data table:', error);
  }
}

async function tblCarData() {
   try {
  const data = await getLandlordCar();
  const renttbl = document.getElementById('renttbl');

  let tableContent = `
    <table class="table table-bordered table-striped">
  <thead class="table-warning sticky-top text-center">
    <tr>
      <th scope="col">Арендатор</th>
      <th scope="col">Маркаарка</th>
      <th scope="col">Номер</th>
      <th scope="col">Стоимость аренды</th>
    </tr>
  </thead>
  <tbody>
  `;
  for (const item of data) {
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
    tableContent += `
    <tr>
      <td>${item.first_name} ${item.last_name}</tb>
      <td>${item.car_model}</td>
      <td>${item.car_number}</td>
      <td>${item.car_cost} руб./сутки</td>
    </tr>
  `;
  }
  tableContent += `
  </tbody>
    </table>
  `;
  renttbl.innerHTML = tableContent;
  } catch (error) {
        console.error('Error rendering car data table:', error);
    }
}

window.addEventListener('DOMContentLoaded', async () => {
  try{
    await initializeCalendar();
    await tblCarData();
    await tblRentData();
    await getPassport();
    
  } catch (error) {
    console.error('Error during initialization:', error);
  }
});
  </script>
</body>
</html>
