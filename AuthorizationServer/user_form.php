<?php
	session_start();

	$error_authentication = "";
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
		<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

	    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
	    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
	    <script src = "js/jquery.js"></script>  
	    <script src = "js/bootstrap.js"></script>
    
		<title>Registrazione utente</title>
	</head>
	
	<body style = "background-color:lightgray;">
		<h1 style = "text-align:center;">My OAuth Server</h1>
      	<hr>
  		<h3 style = "text-align:center;">Registrazione utente</h3>
  		<div class = "container-fluid">
	    <div class = "row" style = "text-align:center;">
	        <div class = "col-md-4 col-xs-4">
	        
	        </div>
	        <div class = "col-md-4 col-xs-4">
	        	<?= $error_authentication;?>
	          <form method = "post" action = "register_user.php">
	            <div class="form-group">
	              <div class="form-group">
	                <label for = "username">Username</label>
	                  <input required id = "username" type="text" class="form-control" placeholder="Username" name = "username">
	              </div>
	              <div class="form-group">
	                <label for = "password">Password</label>
	                  <input required id = "password" type="password" class="form-control" name = "password">
	              </div>
	              <div class="form-group">
	                <label for = "nome">Nome</label>
	                  <input required id = "nome" type="text" class="form-control" placeholder="Nome" name = "firstname">
	              </div>
	              <div class="form-group">
	                <label for = "cognome">Cognome</label>
	                  <input required id = "cognome" type="text" class="form-control" placeholder="Cognome" name = "lastname">
	              </div>
	              <div class="form-group">
	                <label for = "email">Email</label>
	                  <input required id = "email" type="text" class="form-control" placeholder="Email" name = "email">
	              </div>
	              <div class="form-group">
	                <label for = "friend1">Amico 1</label>
	                  <input required id = "friend1" type="text" class="form-control" placeholder="Amico 1" name = "friend1">
	              </div>
	              <div class="form-group">
	                <label for = "friend2">Amico 2</label>
	                  <input required id = "friend2" type="text" class="form-control" placeholder="Amico 2" name = "friend2">
	              </div>
	               <div class = "form-group">
	                <button type="submit" class="btn btn-primary" name = "send"><strong>Registrati</strong></button>
	                <button  class="btn btn-success" onClick = "window.location.href='index.php'"><strong>Homepage</strong></button>
	              </div>  
	            </div>
	          </form>
	        </div>
	        <div class = "col-md-4 col-xs-4">
	        
	        </div>
	      </div>
    	</div>
	</body>
</html>