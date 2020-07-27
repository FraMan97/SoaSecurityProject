<?php
	session_start();

	//VERIFICA SE L'UTENTE E' LOGGATO
	if (isset($_SESSION['user'])){
		//VERIFICA CHE TUTTI I PARAMETRI SIANO STATI SETTATI NEL GET
		if ($_GET['response_type'] = "code" and isset($_GET['client_id']) and isset($_GET['redirect_uri'])) {
			$response_type = $_GET['response_type'];
			$client_id = $_GET['client_id'];
			$redirect_uri = $_GET['redirect_uri'];
		}
		else
		{
			header("location: index.php");
			exit(0);
		}
	}
	else
	{
		$_SESSION['not_logged'] = 'Devi prima effettuare l\'accesso!';
		header("location: index.php");
		exit(0);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Autorizza via Authorization code</title>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
    <script src = "js/jquery.js"></script>  
    <script src = "js/bootstrap.js"></script>
    
</head>
<body style = "background-color:lightgray;">
	<h1 style = "text-align:center;">My OAuth Server</h1>
	<hr>
	<h3 style = "text-align:center;">Autorizzazione tramite Authorization Code</h3>
	<div class = "container-fluid">
	      <div class = "row">
	        <div class = "col-md-3 col-xs-3">
	        
	        </div>
	        <div class = "col-md-6 col-xs-6" style = "text-align:center;">
	        	<label><h4>Vuoi autorizzare questa richiesta?</h4></label><br>
	        	<label>Se accetti permetterai all'applicazione di accedere ai tuoi dati solo in lettura</label><br>
		        <button class="btn btn-success" onclick="window.location.href='generate_authorization_code.php?client_id=<?=$client_id;?>&redirect_uri=<?=$redirect_uri;?>&response_type=<?=$response_type;?>&state=xyz'">Si, voglio autorizzare</button>
				<br><br><button class="btn btn-danger" onclick="window.close();">Non autorizza</button>
			</div>
		</div>
	</div>
</body>
</html>