<?php
	session_start();
	include ("include/connection_database.php");

	if (isset($_POST['send']))
	{
		$sql = "SELECT username FROM oauth_users WHERE username = :username";
		$user = $connessione -> prepare($sql);
		$user -> bindParam(':username', $_POST['username']);
		$user -> execute();
		$user = $user -> fetch(PDO::FETCH_ASSOC);

		if (isset($user['username']))
		{
			$_SESSION['error_authentication'] = 'Utente già presente';
			header("location: user_form.php");
			exit(0);
		}

		$sql = "INSERT INTO oauth_users (username, password, first_name, last_name, email) VALUES (:username, :password, :first_name
			, :last_name, :email)";
		$pass = sha1($_POST['password']);
		$add_user = $connessione -> prepare($sql);
		$add_user -> bindParam(':username', $_POST['username']);
		$add_user -> bindParam(':password', $pass);
		$add_user -> bindParam(':first_name', $_POST['firstname']);
		$add_user -> bindParam(':last_name', $_POST['lastname']);
		$add_user -> bindParam(':email', $_POST['email']);
		$add_user -> execute();

		$sql = "INSERT INTO oauth_users_data (user_id, friend1, friend2) VALUES (:user_id, :friend1, :friend2)";
		$add_user_data = $connessione -> prepare($sql);
		$add_user_data -> bindParam(':user_id', $_POST['username']);
		$add_user_data -> bindParam(':friend1', $_POST['friend1']);
		$add_user_data -> bindParam(':friend2', $_POST['friend2']);
		$add_user_data -> execute();

		header("location: index.php");
		exit(0);
	}
?>