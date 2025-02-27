document.getElementById('passportForm').addEventListener('submit', async function(event){
    event.preventDefault();
    const passportSeries = document.getElementById('passportSeries');
    const passportIssued = document.getElementById('passportIssued');
    const passportAddress = document.getElementById('passportAddress');
    const series = passportSeries.value;
    const issued = passportIssued.value;
    const address = passportAddress.value;

    const _data = {series, issued, address};
    try{
    const response = await fetch("/server/passport/create.php",{
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
        console.error('Ошибка при добавлении данных:', error);
    }
});

