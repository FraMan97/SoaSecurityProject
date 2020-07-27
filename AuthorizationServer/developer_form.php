<?php
	session_start();  

  //PAGINA CON FORM PER PERMETTERE AD UN APPLICAZIONE CLIENT DI ISCRIVERSI ALL'AUTHORIZATION SERVER
?>

<html>
  <header>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
    <script src = "js/jquery.js"></script>  
    <script src = "js/bootstrap.js"></script>
    
  	<title>Registrazione</title>
  	<div style = "text-align:center;">
  		<h1>My OAuth Server</h1>
      <hr>
  		<h3>Registrati</h3>
  	</div>
  </header>
  <body style = "background-color:lightgray;">
    <div class = "container-fluid">
      <div class = "row" style = "text-align:center;">
        <div class = "col-md-4 col-xs-4">
        
        </div>
        <div class = "col-md-4 col-xs-4">
          <form method = "post" action = "register_client.php">
            <div class="form-group">
              <div class="form-group">
                <label for = "redireturi">Redirect URI (grant type: Authorization code)*</label>
                  <input required id = "redireturi" type="text" class="form-control" placeholder="Redirect URI" name = "redirect_uri">
              </div>
               <div class = "form-group">
                <button type="submit" class="btn btn-primary" name = "send"><strong>Registrati</strong></button>
                <button  class="btn btn-success" onClick = "window.location.href='index.php'"><strong>Homepage</strong></button>
                <br><br>
                <p>*Questo sarà l'indirizzo dove verrà inviato l'authorization code (tramite GET).
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