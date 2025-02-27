document.addEventListener('DOMContentLoaded', async () => {
    passportSeries = document.getElementById('passportSeries');
    passportIssued = document.getElementById('passportIssued');
    passportAddress = document.getElementById('passportAddress');

try{
  const response = await fetch('/server/passport/read.php',{
    method: 'POST'
  });

    const data = await response.json();
    console.log(data);
    passportSeries.value = data.series;
    passportIssued.value = data.issued;
    passportAddress.value = data.address;

} catch (error) {
    console.error('Ошибка при получении данных:', error);
    // throw error; // Пропускаем ошибку дальше, если нужно выводим
}
});

document.getElementById('passportFormUpdate').addEventListener('submit', async function(event){
    event.preventDefault();
    const passportSeries = document.getElementById('passportSeries');
    const passportIssued = document.getElementById('passportIssued');
    const passportAddress = document.getElementById('passportAddress');
    const series = passportSeries.value;
    const issued = passportIssued.value;
    const address = passportAddress.value;

    const _data = {series, issued, address};
    try{
    const response = await fetch("/server/passport/update.php",{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(_data)
    });

    if (!response.ok) {
            throw new Error(`Сервер ответил с кодом: ${response.status}`);
    }else if(response.ok) {
       history.back();
    }
    const data = await response.json();
    console.log(data);
    } catch(error) {
        console.error('Ошибка при обновлении данных:', error);
    }
});