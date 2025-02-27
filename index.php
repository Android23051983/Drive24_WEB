<? session_start(); 
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');

require_once $_SERVER['DOCUMENT_ROOT'] . '/client/pages//create_db/create_table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/configure/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Драйв24</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="d-flex flex-column vh-100">
    <header class="container">
        <div class="row">
            <h1 class="col-6 mt-auto mb-auto">Драйв24</h1>
            <div class="col-6 mt-auto mb-auto">
                <h4 class="text-end h-responsive">Администратор:</h4>
                <h4 class="text-end h-responsive"><a href="tel:+79287525605">+7 (928) 752-56-05</a></h4>
            </div>
        </div>
    </header>
    
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div class="container_nav">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border border-dark rounded-3">
                    <div class="container-fluid">
                        <?php
                        require_once("client/pages/navbar.php");
                        ?>
                    </div>
                </nav>
            </div>
        </div>
        
        <div class="row">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <div class="container_nav">
                    <?php
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                        switch ($page) {
                            case 1:
                                include_once("login_ya.php");
                                break;
                            case 2:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/admin/get_user.php";
                                break;
                            case 3:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/auth_admin/login_admin.php";
                                break;
                            case 4:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/car/add_car.php";
                                break;
                            case 5:
                                if (isset($_GET["userid"]) && isset($_GET["carid"])) {
                                $userid = $_GET["userid"];
                                $carid = $_GET["carid"];
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/admin/update_user_car.php";
                                }
                                break;
                            case 6:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/admin/detail_client.php";
                                break;
                            case 7:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/admin/detail_landlord.php";
                                break;
                            case 8:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/rent/rent.php";
                                break;
                            case 9:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/landlord/lk.php";
                                break;
                            case 10:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/client/lk.php";
                                break;
                            case 11:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/search.php";
                                break;
                            case 12:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/passport/add_passport.php";
                                break;
                            case 13:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/car/cars.php";
                                break;
                            case 14:
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/client/pages/passport/update_passport.php";
                                break;
                            case 15:
                                include_once("");
                                break;
                        }
                    } else {
                        include_once("client/pages/car/cars.php");
                    }      
                    ?>
                </div>
            </section>
        </div>
    </div>
    
    <footer class="bg-light rounded-3 px-3 py-3 d-flex align-items-center justify-content-between">
            <p class="fw-bold text-dark align-middle mt-auto mb-auto">
                2024-2025, Драйв24 Team. © All right reserved.
            </p>
            <a class="btn btn-sm btn-info border-dark align-middle rounded align-middle mr-auto" href="/documents/Инструкция.pdf" download>Инструкция в формате PDF</a>
    </div>
    </footer>
</div>
<script src="https://websitedevel.ru/js/bootstrap.bundle.min.js"></script>
<script src="https://websitedevel.ru/js/main.js"></script>
</body>
</html>