async function getLendlordData() {
    const response = await fetch('/server/user/read_lendlord.php');
    const data = await response.json();
    return data;
}

async function initializeCalendar() {
    const data = await getLendlordData();
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.calendar(calendarEl, {

    });
}