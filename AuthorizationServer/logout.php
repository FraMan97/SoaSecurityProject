<?php
	session_start();
	//EFFETTUA IL LOGOUT DELL'USER ELIMINANDO TUTTE LE VARIABILI DI SESSIONE
    unset($_SESSION['user']);
    unset($_SESSION['not_logged']);
    unset($_SESSION['error_authentication']);
	header("location: index.php");
	exit(0);
?>