<?php
	session_start();
	include "include/settings.php";
	
	//VERIFICA  SE CI SONO STATI ERRORE NELL'INVIO DELL'AUTHORIZATION CODE
	if (!(isset($_GET['error']))){
		$params = array();
		$params['grant_type'] = 'authorization_code';
		$params['code'] = $_GET['code'];
		$params['redirect_uri'] = $url_callback;
		$params['client_secret'] = $client_secret;
		$params['client_id'] = $client_id;
		
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
		echo $_GET['error']. ' : '. $_GET['error_description'];
	}
	
?>