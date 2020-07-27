<?php
	
	// error reporting (this is a demo, after all!)
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	// Autoloading (composer is preferred, but for this example let's just do this)
	require_once('oauth2-server-php/src/OAuth2/Autoloader.php');
	require_once('include/settings.php');
	OAuth2\Autoloader::register();


	//CREA LA VARIABILE STORAGE CON I DATI DEL DATABASE
	$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));


	//CREA UN OGGETTO SERVER ABILITANDO I JWT TOKEN
	$server = new OAuth2\Server($storage, array('use_jwt_access_tokens' => true,));


	//AGGIUNGE L'AUTENTICAZIONE 'User Credentials' Grant Type
	$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

	//AGGIUNGE L'AUTENTICAZIONE 'Authorization Code' Grant Type
	$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
?>