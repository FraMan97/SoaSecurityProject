<?php
	try
	{
		$connessione = new PDO("mysql:host=localhost;dbname=my_myoauthdemo; port=3306", 'root', '');
		$connessione -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		header("Location: index.php");
		exit();	
	}

?>