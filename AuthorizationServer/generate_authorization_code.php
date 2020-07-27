<?php
	session_start();
	include 'server.php';
	include 'include/connection_database.php';

	//VERIFICA CHE TUTTI I PARAMETRI NEL GET SIANO CORRETTI
	if ($_GET['response_type'] = "code" and isset($_GET['client_id']) and isset($_GET['redirect_uri'])) {
		$response_type = $_GET['response_type'];
		$client_id = $_GET['client_id'];
		$redirect_uri = $_GET['redirect_uri'];

		//RICHIEDE L'AUTHORIZATION CODE E LO INVIA AL CLIENT
		$request = OAuth2\Request::createFromGlobals();
		$response = new OAuth2\Response();
		$server->handleAuthorizeRequest($request, $response, true, $_SESSION['user']);
		$response->send();
		
	}
	else
	{
		header("location: index.php");
		exit(0);
	}
?>