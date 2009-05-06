<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	
	// Byta lösenord
	if(isset($_POST['oldPass'])) {
		$mailaddr = db_get_mailaddr($_SESSION['sendMe']['id']);
		$old_pass = sha1($mailaddr.$_POST['oldPass']);
		$sql = "SELECT id FROM users WHERE id='".$_SESSION['sendMe']['id']."' AND password='".$old_pass."' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) == 1) {
			if($_POST['newPass1'] == $_POST['newPass2']) {
				$np = sha1($mailaddr.$_POST['newPass1']);
				$sql = "UPDATE users SET password='$np' WHERE id='".$_SESSION['sendMe']['id']."' LIMIT 1";
				mysql_query($sql);
				$message = "Ditt lösenord ändrades.";
			} else { 
				$message = "Det nya lösenordet stämde inte.";
			}	
		} else {
			$message = "Du angav ett felaktigt lösenord, försök igen.";
		}
		
		
		
	}
	

	require('top.php');
?>
<h1>SendMe :: Mina inställningar</h1>

<h2>Byta lösenord</h2>
<form method='post' action='settings.php'>
	<label for='oldPass'>Nuvarande lösenord: </label><input type='password' name='oldPass' id='oldPass' />
	<br />
	<label for='newPass1'>Nytt lösenord: </label><input type='password' name='newPass1' id='newPass1' />
	<br />
	<label for='newPass2'>Nytt lösenord (igen): </label><input type='password' name='newPass2' id='newPass2' />
	<input type='submit' name='submitPassword' value='Byt lösenord' />
</form>