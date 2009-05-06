<?php
	session_start();
	require('config.php');
	require('functions.php');
	
include_once 'includes/securimage/securimage.php';
$securimage = new Securimage();

	if(isset($_POST['Namn'])) {
		$namn = db_clean($_POST['Namn']);
		$epost = db_clean(strtolower($_POST['ePost']));
		
		$n = explode(' ', $namn);
		$fNamn = @ucfirst($n[0]);
		$eNamn = @ucfirst($n[1]);
		
		//echo "F: $fNamn E: $eNamn";
		
		if(db_check_mailaddr($epost)) {
			$m = "<strong>E-postadressen finns redan, har du <a href='forgotpass.php'>glömt ditt lösenord</a>?</strong>";
		} else if ($securimage->check($_POST['ccode']) == false) {
			$m = "<strong>Du angav en felaktig säkerhetskod.</strong>";
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
			$message = "\nDitt lösenord är: $pass\n\nFör att aktivera ditt konto går du till: ".$app_url."confirm.php och anger din aktiveringskod som är $one_time . \n\nDu kan också klicka direkt på denna länk för att aktivera ditt konto:\n".$app_url."confirm.php?ticket=$one_time";
			$message = wordwrap($message, 70);
			$headers = 'From: no-reply@sendme.skolstaden.se' . "\r\n"; 
			//echo "<pre>".$message."</pre>";
			mail($epost, 'Aktiveringskod SendMe', $message, $headers);
			$m = "Ett epostmeddelande har skickats till dig med aktiveringskod.";
		}
		
		
	}
	if(isset($m)) {
		$smarty->assign('m', $m);
	}
	$smarty->display('register.tpl');

?>
