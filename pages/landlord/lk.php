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
  <script>

const userData = <?php echo json_encode([
'first_name' => $_SESSION['user']->first_name,
'last_name' => $_SESSION['user']->last_name,
'email' => $_SESSION['user']->default_email
]); ?>;

async function getLandlordData() {
    const url = '/user/read_landlord_data.php';
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



async function getLandlordCar() {
    const url = '/user/read_landlord_car.php';
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
    
  } catch (error) {
    console.error('Error during initialization:', error);
  }
});
  </script>
</body>
</html>
