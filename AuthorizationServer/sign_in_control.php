<?php
	session_start();
	include "include/connection_database.php";

	//SE L'UTENTE HA RICHIESTO DI AUTENTICARSI, VIENE VERIFICATO SE L'UTENTE ESISTE NEL DATABASE
	if (isset($_POST['send'])) 
	{
		$sql = "SELECT username FROM oauth_users WHERE username = :username and password =:password";
		$user = $connessione -> prepare($sql);
		$user -> bindParam(':username', $_POST['username']);
		$user -> bindParam(':password', sha1($_POST['password']));
		$user -> execute();
		$user = $user -> fetch(PDO::FETCH_ASSOC);

		//VERIFICA SE L'UTENTE ESISTE NEL DATABASE
		if (isset($user['username']))
			$_SESSION['user'] = $user['username'];
		else
		{
			$_SESSION['error_authentication'] = 'Utente non presente nel database!';
			header("location: sign_in_form.php");
			exit(0);
		}
	}
	header("location: index.php");
	exit(0);
?>