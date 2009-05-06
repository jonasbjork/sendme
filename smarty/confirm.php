<?php
	session_start();
	require('config.php');
	require('functions.php');
	
	// Kolla om vi har en ticket med oss in på sidan (från mailet)
	$ticket = "";
	if(isset($_GET['ticket'])) {
		$ticket = $_GET['ticket'];
	}
	
	if(isset($_POST['ticket'])) {
		$t = db_clean($_POST['ticket']);
		$sql = "SELECT id, active FROM users WHERE one_time_pass='$t' LIMIT 1";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			$r = mysql_fetch_array($q);
			$id = $r['id'];
			$active = $r['active'];
			if($active == 1) {
				echo "Ditt konto är redan aktiverat.";
			} else {
				$sql = "UPDATE users SET active='1' WHERE id='$id' LIMIT 1";
				mysql_query($sql);
				echo "Ditt konto aktiverades.";
			}
		} else {
			echo "Du har angett en ogiltig aktiveringskod.";
		}		
	} 	
	
?>

<form method='post' action='confirm.php'>
	<label for='ticket'>Aktiveringskod: </label><input type='text' name='ticket' id='ticket' value='<?php echo $ticket; ?>' size='40' /><br />
	<input type='submit' name='confirmMe' value='Aktivera konto' />
</form>
