<? session_start(); 
$params_1 = array(
	'client_id'     => 'ede5e27338c845e3bc120d785a00f511',
	'redirect_uri'  => 'https://websitedevel.ru/login_ya.php',
	'response_type' => 'code',
  'state'         => '12',
  'scope'         => "login:default_phone login:info login:email login:avatar",
);
$params_2 = array(
	'client_id'     => 'ede5e27338c845e3bc120d785a00f511',
	'redirect_uri'  => 'https://websitedevel.ru/login_ya.php',
	'response_type' => 'code',
  'state'         => '123',
  'scope'         => "login:default_phone login:info login:email login:avatar",
);
$url_oauth_1 = 'https://oauth.yandex.ru/authorize?' . http_build_query( $params_1 );
$url_oauth_2 = 'https://oauth.yandex.ru/authorize?' . http_build_query( $params_2 );
?>
<a class="navbar-brand" href="#"><img class="logo" src="../images/logo.png"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0" >
        <li class="nav-item">
          <a class="nav-link active border border-dark bg-info text-dark rounded-3 me-1" aria-current="page" href="https://websitedevel.ru">Главная</a>
        </li>
        <li class="nav-item">
        <? if(!empty($_SESSION["user"]) && $_SESSION['user']->role == 12){ ?>
          <a class="nav-link border border-dark bg-info text-dark rounded-3 me-1" href="index.php?page=4">Добавить новый автомобиль</a>
        <? } ?>
        </li>
        <li class="nav-item">
        <? if(!empty($_SESSION['admin'])) {?>
          <a class="nav-link border border-dark bg-info text-dark rounded-3 me-1" href="index.php?page=2">Панель администратора</a>
        <? } ?>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0 text-right">
        <li class="nav-item dropdown">
        <a class="nav-link fw-bold text-dark dropdown-toggle" href="#" id="navbarRegistry" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="dark" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
          </svg>
        </a>
          <ul class="dropdown-menu p-3 mb-2 bg-light text-dark">
        <?
        if(empty($_SESSION["user"]) && empty($_SESSION["admin"])){ ?>
            <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3" href="https://passport.yandex.ru/auth/reg/portal?mode=register" target="_blank">Регистрация аккаунта Yandex</a></li>
            <label class="form-label fw-bold">Яндекс авторизация:</label>
            <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3 my-1" href="<?= $url_oauth_1 ?>">Для владельцев автомобилей</a></li>
            <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3 my-1" href="<?= $url_oauth_2 ?>">Для клиентов</a></li>
            <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3 my-1" href="index.php?state=1&page=3">Администратор</a></li>
            <? } 
            if($_SESSION['user']->role == 12){
              ?>
               <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3" href="index.php?page=9">Личный кабинет владельца</a></li>
              <?
            }
             if($_SESSION['user']->role == 123){
              ?>
               <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3" href="index.php?page=10">Личный кабинет клиента</a></li>
              <?
            }
          if(!empty($_SESSION["user"]) || $_SESSION["admin"] == true) {
            ?>
            <li><a class="dropdown-item border border-dark bg-info text-dark rounded-3" href="client/pages/logout.php">Выход</a></li>
            <? } ?> 
          </ul>
        </li>
      </ul>
      <form class="d-flex" action="index.php" method="GET">
        <input type="hidden" name="page" value="11">
        <input class="form-control me-2" type="search" placeholder="Search" required pattern="^[a-zA-Zа-яА-Я0-9]+$" name="car_number" aria-label="Search">
        <button class="btn btn-outline-dark bg-info" type="submit">Search</button>
      </form>
    </div>
    