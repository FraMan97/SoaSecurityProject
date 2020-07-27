<?php
  require_once('oauth2-server-php/src/OAuth2/Autoloader.php');
  session_start();
  OAuth2\Autoloader::register();
  $profile = "";
  $authentication_state = "";
  $not_logged = "";

  if (isset($_SESSION['not_logged'])){
    $not_logged = " 
      <div class='alert alert-warning alert-dismissible' role='alert'>   
        <strong>". $_SESSION['not_logged']."</strong></div>";
       unset($_SESSION['not_logged']);
  }



  //VERIFICA SE L'UTENTE E' GIA LOGGATO OPPURE DEVE ANCORA FARLO
  if (isset($_SESSION['user']))
 	  $profile = " 
      <div class='alert alert-success alert-dismissible' role='alert'>   
        <strong>Ciao  ". $_SESSION['user']."</strong></div><button type ='submit' class = 'btn btn-warning' onClick=\"window.location.href='logout.php'\"><strong>Logout</strong></button>";
  else
 	  $profile =  "<button type ='submit' class = 'btn btn-primary' onClick=\"window.location.href='sign_in_form.php'\"><strong>Accedi </strong></button>";
?>



<html>
  <header>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" >
    <script src = "js/jquery.js"></script>  
    <script src = "js/bootstrap.js"></script>
    
  	<title>Homepage</title>
  	<div style = "text-align:center;">
  		<h1>My OAuth Server</h1>
      <hr>
  		<h3>Homepage</h3>
  	</div>
  </header>
  <body style="background-color:lightgray;">
    <div class = "container-fluid">
      <div class = "row">
        <div class = "col-md-3 col-xs-3">
        
        </div>
        <div class = "col-md-6 col-xs-6" style = "text-align:center;">
          <br>
          <div class = "form-group">
            <?= $not_logged; ?>
            <?= $profile; ?>
          </div>
          <div class = "form-group" style = "text-align:center;">
            <button type="submit" class="btn btn-success" onClick="window.location.href='user_form.php'"><strong>Registrati</strong></button>
          </div>
          <div class = "form-group" style = "text-align:center;">
            <button type="submit" class="btn btn-info" onClick="window.location.href='developer_form.php'"><strong>Iscrizione sviluppatore</strong></button>
          </div>
        </div>
        <div class = "col-md-3 col-xs-3">
        
        </div>
      </div>
    </div>
   </body>
</html>