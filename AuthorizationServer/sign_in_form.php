<?php
	session_start();

  //PAGINA CON FORM PER PERMETTERE ALL'USER DI AUTENTICARSI


  $authentication_state = "";

  //VERIFICA SE C'E' STATO UN ERRORE NELL'AUTENTICAZIONE
  if (isset($_SESSION['error_authentication']))
      $authentication_state = "<div class='alert alert-danger alert-dismissible' role='alert'>   
        <strong>". $_SESSION['error_authentication']."</strong></div>";
  unset($_SESSION['error_authentication']);
?>

<html>
  <header>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
    <script src = "js/jquery.js"></script>  
    <script src = "js/bootstrap.js"></script>

  	<title>Accedi</title>
  	<div style = "text-align:center;">
  		<h1>My OAuth Server</h1>
      <hr>
  		<h3>Accedi</h3>
  	</div>
  </header>
  <body style ="background-color:lightgray;">
   <div class = "container-fluid">
      <div class = "row" style = "text-align:center;">
        <div class = "col-md-4 col-xs-4">
        </div>
        <div class = "col-md-4 col-xs-4">
          <?= $authentication_state;?>
          <form method = "post" action = "sign_in_control.php">
            <div class="form-group">
                <label for = "username">Username</label>
                  <input required id = "username" type="text" class="form-control" placeholder="Username" name = "username">
            </div>
             <div class="form-group">
                <label for = "password">Password</label>
                  <input required id = "password" type="password" class="form-control" name = "password">
            </div>
            <div class = "form-group">
                <button type="submit" class="btn btn-primary" name = "send"><strong>Accedi</strong></button>
                <button  class="btn btn-success" onClick = "window.location.href='index.php'"><strong>Homepage</strong></button>
            </div>
          </form>
        </div>
        <div class = "col-md-4 col-xs-4">
        
        </div>
      </div>
    </div>

  </body>
</html>