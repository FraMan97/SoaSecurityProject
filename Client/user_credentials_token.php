<?php
	session_start();

	include "include/settings.php";

	//RICHIEDE IL TOKEN ATTRAVERSO L'INVIO DELLE CREDENZIALI DELL'USER ALL'AUTHORIZATION SERVER
	if (isset($_POST['send'])){
		$params = array();
		$params['grant_type'] = 'password';
		$params['client_id'] = $client_id;
		$params['client_secret'] = $client_secret;
		$params['username'] = $_POST['username'];
		$params['password'] = $_POST['password'];

		$url = $url_authorization_server;
		
        //INVIA LA RICHIESTA AL SERVER PER OTTENERE IL TOKEN
		$ch = curl_init();
		$header = array ();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS,$params);
		$response = curl_exec( $ch );
		if ((isset(json_decode($response)->error)) or (curl_error($ch)))
		{
			$_SESSION['error_authentication'] = json_decode($response)->error_description;
			header("location: index.php");
			exit(0);
		}
		else
		{
			$_SESSION['token_access'] = $response;
			header("location: ".$url_profile_user);
			exit(0);
		}
	}
	else
	{
		header("location: index.php");
		exit(0);
	}
?>