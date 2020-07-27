<?php
	session_start();
	include 'include/settings.php';

	if (isset($_SESSION['token_access']))
	{
		header("location: profile.php");
		exit(0);
	}

	$error_authentication = "";
    
    //SEGNALA UN ERRORE NEL CASO DI CREDENZIALI NON CORRETTE
	if (isset($_SESSION['error_authentication']))
	{
		$error_authentication = "<div class='alert alert-danger alert-dismissible' role='alert'>   
					<strong>".$_SESSION['error_authentication']."</strong>
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
				    <span aria-hidden=\"true\">&times;</span>
				  </button>
				</div>";
		unset($_SESSION['error_authentication']);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>My application demo</title>
			<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

	    	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
	    	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
	    	<script src = "js/jquery.js"></script>  
	    	<script src = "js/bootstrap.js"></script>
	    
	</head>
	<body style = "background-color:lightgray;">
		<h1 style = "text-align:center;">My Application Demo</h1>
		<hr>
		<h3 style = "text-align:center;">Accedi tramite <strong>My OAuth Demo</strong></h3>

		<div class = "container-fluid">
	      <div class = "row">
	        <div class = "col-md-3 col-xs-3">
	        
	        </div>
	        <div class = "col-md-6 col-xs-6" style = "text-align:center;">

				<div class='alert alert-success alert-dismissible' role='alert'>   
					<strong>Via User Credentials </strong>
				</div>
				<?= $error_authentication;?>
				<form method = "post" action = "user_credentials_token.php">
		            <div class="form-group">
		              <div class="form-group">
		              	<label for = "username">Username</label>
		                <input required id = "username" type="text" class="form-control" placeholder="Username" name = "username">
		              </div>
		             <div class="form-group">
		                <label for = "password">Password</label>
		                <input required id = "password" type="password" class="form-control" placeholder="Password" name = "password">
		              </div>
					 <div class="form-group">
	                	<button type="submit" class="btn btn-primary" name = "send"><strong>Accedi</strong></button>
					 </div>
					</div>
				</form>
				<hr style = "height:8px;">
				<br>	
				<div class='alert alert-warning alert-dismissible' role='alert'>   
					<strong>Via Authorization Code </strong>
				</div>
				<form method="post" target = "_blank" action = "<?=$url_authorize_server;?>?response_type=code&client_id=<?= $client_id;?>&redirect_uri=<?=$url_callback;?>">
					<div class = "form-group">
	                	<button type="submit" class="btn btn-primary" name = "authorize"><strong>Accedi</strong></button>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</body>
</html>
