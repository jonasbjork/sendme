<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');

	if(isset($_POST['submitAddCourse'])) {
		$kurs_id = db_clean($_POST['kurs_id']);
		//$message = $kurs_id;
		$sql = "SELECT id FROM kurs_user WHERE user_id='".$_SESSION['sendMe']['id']."' AND kurs_id='$kurs_id' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) == 1) {
			$message = "Du är redan medlem i den kursen.";
		} else {
			$sql = "INSERT INTO kurs_user(user_id, kurs_id) VALUES('".$_SESSION['sendMe']['id']."','".$kurs_id."')";
			mysql_query($sql);
			$message = "Du lades till i kursen ".db_get_course_name($kurs_id)." .";
		}
	}

	require('top.php');
?>
<h1>SendMe :: Mina kurser</h1>
<p>Här kan du se vilka kurser du är medlem i och lägga till nya.</p>
<h2>Mina kurser</h2>
<?php
	$sql = "SELECT kurs_id FROM kurs_user WHERE user_id='".$_SESSION['sendMe']['id']."' AND active='1'";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		print("<table>");
		while($r = mysql_fetch_array($q)) {
			$id = $r['kurs_id'];
			$kursnamn = db_get_course_name($id);
			$larare = "";
			printf("<tr><td><a href='upload.php?course=%s'>%s</a></td><td>( %s )</td></tr>\n", $id, $kursnamn, $larare);
		}
		print("</table>");
	} else {
		print("<p>Du är inte med i någon kurs än.</p>");
	}

?>
<h2>Gå med i en ny kurs</h2>
<!-- TODO: skall inte visa kurser man redan är med i -->
<?php
	$sql = "SELECT id, namn, skapad_av FROM kurs ORDER BY namn";
	$q = mysql_query($sql);

	if(mysql_num_rows($q) > 0) {
		printf("<form method='post' action='courses_student.php'>\n");
		printf("<select name='kurs_id'>\n");
		while($r = mysql_fetch_array($q)) {
			printf("<option value='%s'>%s</option>", $r['id'], $r['namn']);
		}
		printf("</select>");
		printf("<input type='submit' name='submitAddCourse' value='Gå med' />\n");
		printf("</form>\n");
	} else {
		printf("<p>Det finns inga kurser.</p>");
	}
?>


