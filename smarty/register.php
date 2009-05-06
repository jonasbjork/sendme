<?php
	session_start();
	require('config.php');
	require('functions.php');
	
	if(isset($_POST['Namn'])) {
		$namn = db_clean($_POST['Namn']);
		$epost = db_clean($_POST['ePost']);
		
		$n = explode(' ', $namn);
		$fNamn = ucfirst($n[0]);
		$eNamn = ucfirst($n[1]);
		
		//echo "F: $fNamn E: $eNamn";
		
		if(db_check_mailaddr($epost)) {
			$m = "E-postadressen finns redan, har du glömt ditt lösenord?";
		} else {
			$one_time = sha1($epost.time());
			$ip = $_SERVER['REMOTE_ADDR'];
			$pass = rand(1000,9999);
			// lägg till användaren
			$sql = "INSERT INTO users(fNamn, eNamn, password, epost, skapad, ip_addr, one_time_pass) VALUES(".
				"'".$fNamn."','".$eNamn."','".sha1($epost.$pass)."','".$epost."','".time()."','".$ip."','".$one_time."')";
			//echo $sql;
			mysql_query($sql);
			
			// skapa ett mail
			$message = "Ditt lösenord är: $pass\n\nFör att aktivera ditt konto går du till: ".$app_url."confirm.php och anger din aktiveringskod som är $one_time . \n\nDu kan också klicka direkt på denna länk för att aktivera ditt konto:\n".$app_url."confirm.php?ticket=$one_time";
			$message = wordwrap($message, 70);
			$headers = 'From: no-reply@sendme.skolstaden.se' . "\r\n"; 
			//echo "<pre>".$message."</pre>";
			mail($epost, 'Aktiveringskod SendMe', $message, $headers);
			$m = "Ett epostmeddelande har skickats till dig med aktiveringskod.";
		}
		
		
	}

?>
<h1>SendMe</h1>
<?php
	if(isset($m)) {
?>
<div style="width: 100%; border: 1px solid #88ff88; background-color: #ccffcc; padding: 10px">
	<?php echo $m; ?>
</div>
<?php
	}
?>
<h2>Registera konto</h2>
<p>Börja med att fylla i dina uppgifter nedan. Ett e-postmeddelande kommer skickas till dig med en registeringslänk som du måste använda för att aktivera ditt användarkonto. I samband med att du aktiverar kontot får du också välja ett lösenord.</p>

<form method='post' action='register.php'>
	<label for='Namn'>Ditt namn:</label> <input type='Namn' id='Namn' name='Namn' /><br />
	<label for='ePost'>E-postadress:</label> <input type='ePost' id='ePost' name='ePost' /><br />
	<input type='submit' name='registerSubmit' value='Registera konto' />
	
</form>

