<?php
// Формирование параметров (тела) POST-запроса с указанием кода подтверждения
	$query = array(
		'grant_type'    => 'authorization_code',
		'code'          => $_GET['code'],
		'client_id'     => 'ede5e27338c845e3bc120d785a00f511',
		'client_secret' => 'd347b378d5f44a59b58e4c4f0620b7d7'
	);
	$query = http_build_query( $query );
 
	// Формирование заголовков POST-запроса
	$header = "Content-type: application/x-www-form-urlencoded";
 
	// Выполнение POST-запроса
	$opts    = array(
		'http' =>
			array(
				'method'  => 'POST',
				'header'  => $header,
				'content' => $query
			)
	);
	$context = stream_context_create( $opts );
 
	if ( ! $content = @file_get_contents( 'https://oauth.yandex.ru/token', false, $context ) ) {
		$error = error_get_last();
		throw new Exception( 'HTTP request failed. Error: ' . $error['message'] );
	}
 
	$response = json_decode( $content );
 
	// Если при получении токена произошла ошибка
	if ( isset( $response->error ) ) {
		throw new Exception( 'При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description );
	}
 
	$accessToken = $response->access_token; // OAuth-токен с запрошенными правами или с правами, указанными при регистрации приложения.
	$expiresIn   = $response->expires_in; // Время жизни токена в секундах.
 
	// Токен, который можно использовать для продления срока жизни соответствующего OAuth-токена.
	// https://tech.yandex.ru/oauth/doc/dg/reference/refresh-client-docpage/#refresh-client
	$refreshToken = $response->refresh_token;
 
	// Сохраняем токен в сессии
	$_SESSION['yaToken'] = array( 'access_token' => $accessToken, 'refresh_token' => $refreshToken );
    ?>