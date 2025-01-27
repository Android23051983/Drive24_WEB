async function loginAdmin() {
    const login = document.getElementById('inputLogin').value; 
    const email = document.getElementById('inputEmail').value;
    const _data = {login, email};
    const response = await fetch('/user/login_admin.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(_data)
    });

    if (!response.ok) {
            throw new Error(`Сервер ответил с кодом: ${response.status}`);
    }else if(response.ok) {
        window.location.href = `index.php?page=2`;
    }
}

document.getElementById('login_admin').addEventListener('submit', async function(event){
    event.preventDefault();
    await loginAdmin();
});