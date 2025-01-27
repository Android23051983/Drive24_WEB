async function showCities(countryid) {
    if (countryid == 0) {
        document.querySelector("#cityid").innerHTML = "";
    }
    var response = await fetch("pages/cities.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `countryid=${countryid}`,
    });
    if (response.ok) {
        document.querySelector("#cityid").innerHTML = await response.text();
    }
}


async function showCars(cityid) {
    if (cityid == 0) {
        document.querySelector("#cars").innerHTML = "";
    }
    var response = await fetch("pages/car/car_query.php", {
         method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `cityid=${cityid}`,
    });
    if (response.ok) {
        document.querySelector("#cars").innerHTML = await response.text();
    }
}
