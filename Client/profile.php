<?php
	session_start();
	include 'include/settings.php';
	//header("location: logout.php");
	if (isset($_SESSION['token_access']))
	{
		$personal_information = '<form method="post" action="profile.php">
			<div class= "form-group"><button class = "btn btn-primary" type="submit" name = "resource"/>Richiedi risorsa</button></div>
		</form>';

		//VERIFICA CHE IL TOKEN ABBIA IL FORMATO CORRETTO
		if (2 !== substr_count(json_decode($_SESSION['token_access'])->access_token, '.')) {
		    throw new Exception("Incorrect access token format");
		}

		//ESTRAE LE INFORMAZIONI DAL TOKEN
		list($header, $payload, $signature) = explode('.', json_decode($_SESSION['token_access'])->access_token);

		$decoded_signature = base64_decode(str_replace(array('-', '_'), array('+', '/'), $signature));

		$payload_to_verify = utf8_decode($header . '.' . $payload);

		$public_key = file_get_contents($path_public_key);

		//VERIFICA LA FIRMA PUBBLICA DELL'AUTHORIZATION SERVER
		$verified = openssl_verify($payload_to_verify, $decoded_signature, $public_key, OPENSSL_ALGO_SHA256);

		if ($verified !== 1) {
		    throw new Exception("Token non verificato con la chiave pubblica dell'Authorization Server");
		}

		$verified_token = "<p style = 'text-align:center;'><strong>Token verificato con la chiave pubblica di My OAuth Demo</strong></p>";

		if (isset($_POST['resource'])){
			if (isset($_SESSION['token_access']))
			{
            
            	//CHIEDE AL SERVER LA RISORSA INVIANDO IL TOKEN DI ACCESSO
				$url = $url_request_resource;
			    $ch = curl_init();
				$header = array ();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			                                            'Content-Type: application/x-www-form-urlencoded',
			                                            'Connection: Keep-Alive'
			                                            ));
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS,"access_token=".json_decode($_SESSION['token_access'])->access_token);
				$response = curl_exec( $ch );
				$personal_information = '';
				if (isset(json_decode($response)->error))
					$personal_information = '<strong>'.json_decode($response)->error_description.'!</strong>';
				else
				{
					$array_response = json_decode($response);
					curl_close($ch);
					$personal_information = '
					<strong>Tuoi dati estratti dal database di My OAuth Demo:</strong>
					<br><br>
					<div class = "container-fluid">
						<div class = "row">
							<div class = "col-md-3 col-xs-3">

							</div>
							<div class = "col-md-6 col-xs-6">
								<table class ="table">
									<tr>
										<td>Nome : </td><td>'.$array_response->firstname.'</td>
									</tr>
									<tr>
										<td>Cognome : </td><td>'.$array_response->lastname.'</td>
									</tr>
									<tr>
										<td>Username : </td><td>'.$array_response->user_id.'</td>
									</tr>
									<tr>
										<td>Email : </td><td>'.$array_response->email.'</td>
									</tr>
									<tr>
										<td>Amico 1 : </td><td>'.$array_response->friend1.'</td>
									</tr>
									<tr>
										<td>Amico 2 : </td><td>'.$array_response->friend2.'</td>
									</tr>
								</table>
							</div>
						</div>
					</div>';
				}
				
			}else
			{
				header("location: index.php");
				exit(0);
			}
		}
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
		<title>Profilo dell'utente</title>
		<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

	    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
	    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
	    <script src = "js/jquery.js"></script>  
	    <script src = "js/bootstrap.js"></script>
	</head>
	<body style = "background-color:lightgray; ">
		<h1 style = "text-align:center;">My Application Demo</h1>
		<hr>
		<h3 style = "text-align:center;">Dati dell'utente</strong></h3>
		<?= $verified_token; ?>
		
		<p style = "text-align:center;"><strong>JWT Token </strong>(format: HEADER.PAYLOAD.SIGNATURE):</p>
		<p><strong>Token: </strong><?= json_decode($_SESSION['token_access'])->access_token; ?></p>
		<br><p><strong>Header:</strong></p>
		<?= base64_decode(explode('.',json_decode($_SESSION['token_access'])->access_token)[0]);?>
		<br><br><p><strong>Payload:</strong></p>
		<?= base64_decode(explode('.',json_decode($_SESSION['token_access'])->access_token)[1]);?>
		<br><br><p><strong>Signature:</strong></p>
		<?= explode('.',json_decode($_SESSION['token_access'])->access_token)[2];?>
		<br><br><br>
		<div style = "text-align:center;">
			<?= $personal_information;?>
            <br>
			<button class="btn btn-warning" onClick="window.location.href='logout.php'">Logout</button>
		</div>
		
	</body>
</html>