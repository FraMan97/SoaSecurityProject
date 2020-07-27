<?php
	session_start();
	require_once 'server.php';
	require_once 'include/connection_database.php';

		// Handle a request to a resource and authenticate the access token
		if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
			$server->getResponse()->send();
		     exit(0);
		}

		//OTTIENE IL TOKEN DI ACCESSO
		$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

		//ESTRAE I DATI DELL'USER DOPO CHE IL CLIENT HA FORNITO IL TOKEN
		$sql = "SELECT * FROM oauth_users_data INNER JOIN oauth_users on username = user_id WHERE user_id = :username";
		$user = $connessione -> prepare($sql);
		$user -> bindParam(':username', $token['user_id']);
		$user -> execute();
		$user = $user -> fetch(PDO::FETCH_ASSOC);
		
		//RESTITUISCE IN FORMATO JSON I DATI DELL'USER
		if (isset($user['user_id']))
			echo json_encode(array('firstname' => $user['first_name'], 'lastname' => $user['last_name'], 'email' => $user['email'] , 'user_id' => $user['user_id'], 'friend1' => $user['friend1'], 'friend2' => $user['friend2']));
		else
			echo "You don't have friends";
		exit(0);
?>