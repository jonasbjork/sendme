<?php
// forgotpass.php
session_start();
if(isset($_SESSION['sendMe']['id'])) {
    header("Location: index.php");
}
require('config.php');
require('functions.php');
include_once 'includes/securimage/securimage.php';
$securimage = new Securimage();

unset($error);

if(isset($_POST['submit_newpass'])) {
	$epost = db_clean($_POST['epost']);
	
	if ($securimage->check($_POST['ccode']) == false) {
		$error = "<p>Du angav fel säkerhetskod, försök igen.</p>";
	} else {
		$sql = "SELECT id FROM users WHERE epost='".$epost."' LIMIT 1";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			// hittat en adress dags att skicka...
			$r = mysql_fetch_array($q);
			$user_id = $r['id'];
			$pass = rand(1000,9999);
			
			$sql = "INSERT INTO single_pass(user_id,pass,pass_type) VALUES('".$user_id."','".sha1($user_id.$pass)."','new_pass')";
			mysql_query($sql);
			
			$message = "Din aktiveringskod är: ".$pass."\n\nAdressen där du byter ditt lösenord är ".$app_url."forgotpass.php?action=new_pass&code=$pass&user=$epost";
			$message = wordwrap($message, 70);
			$headers = 'From: no-reply@sendme.skolstaden.se' . "\r\n"; 
			//echo "<pre>".$message."</pre>";
			mail($epost, 'SendMe - Glömt mitt lösenord', $message, $headers);
			
		} else {
			$error = "<p>Det finns ingen sådan registerad adress.</p>";
		}
	}
}

if(isset($_GET['action']) && $_GET['action'] == 'new_pass') {
	$code = db_clean($_REQUEST['code']);
	$user = db_clean($_REQUEST['user']);
	$error = "";
	$message = "";
	
	$sql = "SELECT id FROM users WHERE epost='$user' LIMIT 1";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		$r = mysql_fetch_array($q);
		$user_id = $r['id'];
	} else {
		$error[] = "Du har angett felaktiga uppgifter.";
	}
	if(empty($error)) {
		$pass = sha1($user_id.$code);
		$sql = "SELECT id FROM single_pass WHERE user_id='$user_id' AND pass='$pass' AND pass_type='new_pass' LIMIT 1";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			$r = mysql_fetch_array($q);
			$single_pass_id = $r['id'];
		} else {
			$error[] = "Du har angett felaktiga uppgifter..";
		}
		
		if(isset($_POST['newPass1'])) {
			$newPass1 = db_clean($_POST['newPass1']);
			$newPass2 = db_clean($_POST['newPass2']);
			$user = db_clean($_POST['user']);
			$code = db_clean($_POST['code']);
			if ($securimage->check($_POST['ccode']) == false) {
				$error[] = "Felaktig säkerhetskod.";
			}
			if($newPass1 != $newPass2) {
				$error[] = "Du har inte angivit samma lösenord i båda fälten.";
			}
			if(strlen($newPass1) < 5) {
				$error[] = "Lösenordet måste vara minst fem (5) tecken!";
			}
			if(strlen($user) < 3) {
				$error = "Ogiltig e-postadress";
			}
			
			if(empty($error)) {
				$p = sha1($user.$newPass1);
				$sql = "UPDATE users SET epost='".strtolower($user)."', password='$p', active='1' WHERE epost='$user' LIMIT 1";
				mysql_query($sql);
				$sql = "DELETE FROM single_pass WHERE id='".$single_pass_id."' LIMIT 1";
				mysql_query($sql);
				$message = "Ditt nya lösenord aktiverades.";
				
			}
								
		}
		
	}
	
}

?>

<h1 style="font-family: verdana, arial, sans-serif">Glömt ditt lösenord?</h1>

<?php
if((!isset($_GET['step']) || ($_GET['step'] == 1)) && !isset($_GET['action']) ) {
?>
	<form method="post" action="forgotpass.php?step=2">
	<table border="0">
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange din e-postadress för att återställa ditt lösenord.</p></td></tr>
	<tr><td colspan="2"><input type="text" name="epost" style="width: 20em; border: 1px solid #ccc" /></td></tr>
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange säkerhetskoden här nedanför.</p></td></tr>
	<tr><td><input type="text" name="ccode" style="width: 10em; border: 1px solid #ccc" /></td><td style="text-align: right"><img id="captcha" src="includes/securimage/securimage_show.php" alt="CAPTCHA Image" /><br /><a href="#" onclick="document.getElementById('captcha').src = 'includes/securimage/securimage_show.php?' + Math.random(); return false" style="text-decoration: none; color: #333; font-size: 10px; font-family: verdana,arial,sans-serif">Ny bild</a></td></tr>
	<tr><td colspan="2" style="text-align: right"><input type="submit" name="submit_newpass" value="Skicka" /></td></tr>
	</table>
	</form>
<?php
}
if( @$_GET['step'] == 2 ) {
?>
<?php
	if(empty($error)) {
?>
<p>Ett e-postmeddelande skickades till din adress med aktiveringskod.</p>

<p>Kontrollera din skräpmapp i e-posten om du inte hittar meddelandet i inboxen.</p>
<?php
	} else {
?>
<p>Ett feluppstod: <?php echo $error; ?></p>

<?php 
	}
?>
<?php
}
?>
<?php
if( isset($_GET['action']) ) {
	
	if(!empty($message)) {
		echo "<p>".$message."</p>";
	} else {
	
		if(!empty($error)) {
			echo "<ul>";
			foreach($error as $err) {
				echo "<li>".$err."</li>";
			}
			echo "</ul>";
		}
?>
	<form method="post" action="forgotpass.php?action=new_pass">
	<table border="0">
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange din e-postadress för att återställa ditt lösenord.</p></td></tr>
	<tr><td colspan="2"><input type="text" name="user" style="width: 20em; border: 1px solid #ccc" value="<?php echo $_REQUEST['user']; ?>" /></td></tr>
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange din aktiveringskod (den du fick med e-posten):</p></td></tr>
	<tr><td colspan="2"><input type="text" name="code" style="width: 20em; border: 1px solid #ccc" value="<?php echo $_REQUEST['code']; ?>" /></td></tr>
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange ditt nya lösenord:</p></td></tr>
	<tr><td colspan="2"><input type="password" name="newPass1" style="width: 20em; border: 1px solid #ccc" /></td></tr>
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange ditt nya lösenord (igen):</p></td></tr>
	<tr><td colspan="2"><input type="password" name="newPass2" style="width: 20em; border: 1px solid #ccc" /></td></tr>

	
	<tr><td colspan="2"><p style="font-family: verdana, arial, sans-serif; font-size: 12px">Ange säkerhetskoden här nedanför.</p></td></tr>
	<tr><td><input type="text" name="ccode" style="width: 10em; border: 1px solid #ccc" /></td><td style="text-align: right"><img id="captcha" src="includes/securimage/securimage_show.php" alt="CAPTCHA Image" /><br /><a href="#" onclick="document.getElementById('captcha').src = 'includes/securimage/securimage_show.php?' + Math.random(); return false" style="text-decoration: none; color: #333; font-size: 10px; font-family: verdana,arial,sans-serif">Ny bild</a></td></tr>
	<tr><td colspan="2" style="text-align: right"><input type="submit" name="submit_changepass" value="Skicka" /></td></tr>
	</table>
	</form>
<?php
}
?>
<?php
}
?>