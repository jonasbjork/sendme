<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	
	$fid = explode("-", $_GET['file']);
	$time = db_clean($fid[0]);
	$name = db_clean($fid[1]);
	$safe_name = $time."-".$name;	
	
	// om vi postar en kommentar/betyg

	if(isset($_POST['submitGrade'])) {
		$comments = db_clean($_POST['comments']);
		$grade = db_clean($_POST['grade']);
		if($grade == 0) {
			$message = "Du måste ange ett omdöme/betyg för uppgiften.";
		} else {
			$sql = "SELECT id FROM uppgifter WHERE name_orig='$name' AND inlamnad='$time' LIMIT 1";
			$r = mysql_fetch_array(mysql_query($sql));
			$uid = $r['id'];
			
			// lagra
			$update_sql = "UPDATE uppgifter SET rattad='1', rattad_av='".$_SESSION['sendMe']['id']."', betyg='".$grade."' WHERE id='$uid'";
			$update_query = mysql_query($update_sql);
			
			$insert_sql = sprintf("INSERT INTO kommentar(uppgift_id, kommentar, tid, kommentar_av) VALUES('%s','%s','%s','%s')", $uid, $comments, time(), $_SESSION['sendMe']['id']);
			
			$insert_query = mysql_query($insert_sql);
			$message = "Din kommentar och ditt omdöme registerades.";
			unset($_POST);
		}
		
	}
	
	require('top.php');
	
	
	$sql = "SELECT id, user_id, name_orig, inlamnad, rattad, rattad_av, kurs_id FROM uppgifter WHERE name_orig='$name' AND inlamnad='$time' LIMIT 1";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) == 1) {
		$r = mysql_fetch_array($q);
		$kurs = db_get_course_name(stripslashes($r['kurs_id']));
		$user = db_get_user_name(stripslashes($r['user_id']));
		$filnamn = stripslashes($r['name_orig']);
		$inlamnad = show_date(stripslashes($r['inlamnad']));
		$rattad = stripslashes($r['rattad']);
		$rattad_av = stripslashes($r['rattad_av']);
?>
<table>
	<tr><td>Kurs:</td><td><?php echo $kurs; ?></td><td>Användare:</td><td><?php echo $user; ?></td></tr>
	<tr><td>Filnamn:</td><td><?php echo $filnamn; ?><a href='getfile.php?file=<?php echo $safe_name; ?>'><img src='icons/download.gif' title='Hämta' alt='Hämta' style='border: 0; width: 20px' /></a></td><td>Inlämnad:</td><td><?php echo $inlamnad; ?></td></tr>
	
</table>
<br />
<form method='post' action='showfile.php?file=<?php echo $safe_name; ?>'>
<table border=1>
	<tr><td colspan='2'>Kommentarer:</td></tr>
	<?php
	
	?>
	<tr><td colspan='2'><textarea name='comments' cols='80' rows='10'><?php echo $_POST['comments']; ?></textarea></td></tr>
	<?php
	
	?>
	<tr><td colspan='2'>Omdöme/betyg:</td></tr>
	<tr><td><select name='grade'>
		<option value='0'>-</option>
		<option value='1'>IG</option>
		<option value='2'>G</option>
		<option value='3'>VG</option>
		<option value='4'>MVG</option>
	</select></td><td align='right'><input type='submit' value='Rätta' name='submitGrade' /></td></tr>
	
</table>		
</form>
<?php	
	} else {
		echo "<p>Det finns ingen sådan fil.</p>";
	}
?>



