<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	
	// Byta l�senord
	if(isset($_POST['oldPass'])) {
		$mailaddr = db_get_mailaddr($_SESSION['sendMe']['id']);
		$old_pass = sha1($mailaddr.$_POST['oldPass']);
		$sql = "SELECT id FROM users WHERE id='".$_SESSION['sendMe']['id']."' AND password='".$old_pass."' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) == 1) {
			if($_POST['newPass1'] == $_POST['newPass2']) {
				$np = sha1($mailaddr.$_POST['newPass1']);
				$sql = "UPDATE users SET password='$np' WHERE id='".$_SESSION['sendMe']['id']."' LIMIT 1";
				mysql_query($sql);
				$message = "Ditt l�senord �ndrades.";
			} else { 
				$message = "Det nya l�senordet st�mde inte.";
			}	
		} else {
			$message = "Du angav ett felaktigt l�senord, f�rs�k igen.";
		}
		
		
		
	}
	

	require('top.php');
?>
<h1>SendMe :: Mina inst�llningar</h1>

<h2>Byta l�senord</h2>
<form method='post' action='settings.php'>
	<label for='oldPass'>Nuvarande l�senord: </label><input type='password' name='oldPass' id='oldPass' />
	<br />
	<label for='newPass1'>Nytt l�senord: </label><input type='password' name='newPass1' id='newPass1' />
	<br />
	<label for='newPass2'>Nytt l�senord (igen): </label><input type='password' name='newPass2' id='newPass2' />
	<input type='submit' name='submitPassword' value='Byt l�senord' />
</form>