<?php
session_start();
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . "/configure/database.php";
//получаем код авторизации из GET-запроса
$code = $_GET['code'];

//проверем передачу кода авторизации
if(!empty($code)){
	//проверяем, является ли клиент мобильным устройством
	$isMobile = preg_match('/(android|iphone|ipad)/i', $_SERVER['HTTP_USER_AGENT']);

	//формируем соответствующий URL для перенаправления
	if($isMobile) {
		//переходим к схеме интента
		header("Location: drive24scheme://com.example.drive24/callback?code=$code");
		exit();

	} else {
	require_once "client/pages/oauth_ya/oauth_token.php";
	$database = new Database();
	$db = $database->getConnection();

	$yaToken      = $_SESSION['yaToken'];
	$accessToken  = $yaToken['access_token'];
	if ( ! $content = @file_get_contents( 'https://login.yandex.ru/info?format=json&with_openid_identity=1&oauth_token=' . $accessToken ) ) {
		$error = error_get_last();
		throw new Exception( 'HTTP request failed. Error: ' . $error['message'] );
	}
	
	$response = json_decode( $content );
	
	// Если возникла ошибка
	if ( isset( $response->error ) ) {
		throw new Exception( 'При отправке запроса к API возникла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description );
	}

	$_SESSION["user"] = $response;
	// var_export($response);
	$first_name = $response->first_name;
	$last_name = $response->last_name;
	$email = $response->default_email;
	$phone = $response->default_phone->number;
	$role = $_GET['state'];
	$_SESSION['user']->{"role"} = $role;
	try{
	$sql_search = "SELECT * FROM users WHERE first_name = :first_name AND last_name = :last_name AND email = :email AND role = :role";
	$stmt = $db->prepare($sql_search);
	$stmt->bindValue(':first_name', $first_name);
	$stmt->bindValue(':last_name', $last_name);
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':role', $role);
	$stmt->execute();
	} 
	catch(PDOException $e) {
	}
	if($stmt->rowCount() > 0){
	} else {
	try {
	$sql = "INSERT INTO users (first_name, last_name, email, phone, role) VALUES ('$first_name','$last_name', '$email', '$phone', '$role');";
	$db->exec($sql);
	} catch (PDOException $e) {
	}}
	if($_GET["state"] == '12' && !empty($_SESSION['user'])){
	echo '<meta http-equiv="refresh" content="0;URL=index.php">';
	}
	if($_GET["state"] =='123' && !empty($_SESSION['user'])){
	echo '<meta http-equiv="refresh" content="0;URL=index.php">';
	}
	}
}