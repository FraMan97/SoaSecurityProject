<?php
	session_start();
	include ("include/connection_database.php");

	echo "  <h1 style ='text-align:center'>My OAuth Demo</h1>
      		<hr><h3 style ='text-align:center'> Dati client</h3>";
	if (isset($_POST['send']))
	{
		//QUI VIENE GENERATO UN CLIENT_ID E CLIENT_SECRET CASUALMENTE
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    do{
		    $random_client_id = '';
		    $random_client_secret = '';
		    for ($i = 0; $i < 10; $i++) {
		        $random_client_id .= $characters[rand(0, $charactersLength - 1)];
	    		$random_client_secret .= $characters[rand(0, $charactersLength - 1)];
	    	}
	    	 
	    	//VERIFICA CHE IL CLIENT CREATO SIA UNICO
	    	$sql = "SELECT client_id FROM oauth_clients WHERE client_id = :client_id or client_secret =:client_secret";
			$client = $connessione -> prepare($sql);
			$client -> bindParam(':client_id', $random_client_id);
			$client -> bindParam(':client_secret', $random_client_secret);
			$client -> execute();
			$client = $client -> fetch(PDO::FETCH_ASSOC);
	    }while(isset($client['client_id']));

    	$client_id = $random_client_id;
    	$client_secret = $random_client_secret;

    	//VIENE INSERITO NEL DATABASE UN NUOVO CLIENT
		$sql = "INSERT INTO oauth_clients  (client_id, client_secret, redirect_uri) VALUES (:client_id, :client_secret, :redirect_uri)";
		$add_client = $connessione -> prepare($sql);
		$add_client -> bindParam(':client_id', $client_id);
		$add_client -> bindParam(':client_secret', $client_secret);
		$add_client -> bindParam(':redirect_uri', $_POST['redirect_uri']);
		$add_client -> execute();

		//VENGONO FORNITI TUTTI I DATI CHE IL CLIENT DOVRA' UTILIZZARE PER INTERAGIRE CON L'AUTHORIZATION SERVER
		echo '<div class = "container-fluid">
      			<div class = "row">
        			<div class = "col-md-3 col-xs-3">
        
        			</div>
        		<div class = "col-md-6 col-xs-6" style = "text-align:center;">';
		echo "<p>Segnati questi dati! Non potrai più rivederli!</p>";
		echo "<p>Client ID:<strong> ". $client_id. "</strong></p>";
		echo "<p>Client Secret: <strong>". $client_secret.'</strong></p>';
		echo "<p>Link da utilizzare per richiedere il token di accesso al server: "."<strong>https://myoauthdemo.altervista/token.php</strong></p>";
		echo "<p>Link da utilizzare per richiedere la risorsa dell'utente al server: "."<strong>https://myoauthdemo.altervista/resource.php</strong></p>";
		echo "<p>Link da utilizzare per richiedere l'autorizzazione dell'utente: "."<strong>https://myoauthdemo.altervista/authorization_code_form.php</strong></p>";
		echo "<br><button type = 'button' class='btn btn-primary' onClick = 'window.open(\"include/keys/id_rsa.pub\")'>Scarica la chiave pubblica dell'Authorization Server per verificare i JWT Token che riceverai</button>";
		echo "<br><br><button type = 'button' class='btn btn-success' onclick='window.location.href=\"index.php\"'>Torna homepage</button>";
		echo '</div><div class = "col-md-3 col-xs-3"></div></div></div>';
	}
	else
	{
		header("location: index.php");
		exit(0);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
    <script src = "js/jquery.js"></script>  
    <script src = "js/bootstrap.js"></script>
   
	<title>Dati del Client</title>
</head>
<body style = "background-color:lightgray;">

</body>
</html>

