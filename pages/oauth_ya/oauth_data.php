<?php
$accessToken  = $_SESSION['yaToken']['access_token'];
// Получаем информацию о пользователе
if ( ! $content = @file_get_contents( 'https://login.yandex.ru/info?format=json&with_openid_identity=1&oauth_token=' . $accessToken ) ) {
	$error = error_get_last();
	throw new Exception( 'HTTP request failed. Error: ' . $error['message'] );
}
 
$response = json_decode( $content );
 
// Если возникла ошибка
if ( isset( $response->error ) ) {
	throw new Exception( 'При отправке запроса к API возникла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description );
}
 
$userLogin = $response->login; // Логин пользователя
$first_name = $response->first_name;
$last_name = $response->last_name;
$phone = $response->default_phone->number;
?>