<?php
	session_start();

	//EFFETTUA IL LOGOUT DELL'USER ELIMINANDO LA VARIABILE DI SESSIONE 'token_access'
	unset($_SESSION['token_access']);

	header("location: index.php");
	exit(0);
?>