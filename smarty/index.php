<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: login.php");
	}
	require('config.php');
	require('functions.php');
	

	require('top.php');
?>
<h1>SendMe</h1>
<ul>
	<li><a href="courses_student.php">Mina kurser</a></li>
	<li><a href="results_student.php">Mina resultat</a></li>
	<li><a href="upload.php">Ladda upp</a></li>
	<li><a href="settings.php">Mina inst�llningar</a></li>
<?php
	if(db_check_larare($_SESSION['sendMe']['id'])) {
?>
<li><a href="courses_teacher.php">Hantera kurser</a></li>
<?php
	}
?>
<li><a href="logout.php">logga ut</a></li>
</ul>

<?php
	if(db_check_larare($_SESSION['sendMe']['id'])) {
		// lärar-view
?>
<h2>Att rätta</h2>
<?php
	$sql = "SELECT id, namn FROM kurs WHERE skapad_av='".$_SESSION['sendMe']['id']."' ORDER BY namn";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		echo "<table border=1 style='width: 100%'>\n";
		while($r = mysql_fetch_array($q)) {
			echo "<tr><th colspan='6' style='width: 100%; background-color: #ccc; text-align: left'><strong>".$r['namn']."</strong></th></tr>";
			$s = "SELECT * FROM uppgifter WHERE kurs_id='".$r['id']."' AND rattad='0' ORDER BY inlamnad DESC";
			$qu = mysql_query($s);
			while($row = mysql_fetch_array($qu)) {
				$file_url = $row['inlamnad']."-".$row['name_orig'];
				printf("<tr><td><img src='icons/%s.gif' style='width: 20px'/></td><td><a href='showfile.php?file=%s'>%s</a></td><td>%s</td><td>%s</td><td>%s</td><td align='right'><a href='getfile.php?file=%s'><img src='icons/download.gif' title='H�mta' alt='H�mta' style='border: 0; width: 20px' /></a></td></tr>", file_to_icon($row['file_type']), $file_url, $row['name_orig'], db_get_user_name($row['user_id']), show_filesize($row['file_size']), show_date($row['inlamnad']), $file_url);
				
			}
		}
		echo "</table>\n";
	} else {
		echo "<p>Du har inga kurser upplagda än.</p>";
	}
?>

<?php	
	} else {
		// elev-view
?>
<h2>Dina inlämnade uppgifter</h2>

<h2>Dina rättade uppgifter</h2>	
<?php
	}
?>