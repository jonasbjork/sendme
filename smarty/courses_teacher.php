<?php
	session_start();
	require_once('config.php');
	require_once('functions.php');
	
	if(!db_check_larare($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	
	// Skapa en kurs
	if(isset($_POST['courseName'])) {
		$kursNamn = db_clean($_POST['courseName']);
		if(db_check_course_name($kursNamn)) {
			$message = "Kursnamnet finns redan!";
		} else {
			// Skapa kursen
			$sql = "INSERT INTO kurs(namn, skapad_av, skapad_datum) VALUES('".
				$kursNamn."','".$_SESSION['sendMe']['id']."','".time()."')";
			mysql_query($sql);
			$message = "Kursen skapades";
		}
		
	}

	require('top.php');
?>
<h1>SendMe :: Hantera dina kurser</h1>

<h2>Mina kurser</h2>
<?php
	$sql = "SELECT * FROM kurs WHERE skapad_av='".$_SESSION['sendMe']['id']."' ORDER BY namn";
	$q = mysql_query($sql);
	print("<table>\n");
	while($r = mysql_fetch_array($q)) {
		printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>Redigera</td><td>Ta bort</td></tr>", 
			$r['id'], $r['namn'], $r['skapad_datum']);
	}
	print("</table>\n");
?>

<h2>Skapa en ny kurs.</h2>
<p>Här skapar du en ny kurs i systemet, välj ett kursnamn.</p>
<form method='post' action='courses_teacher.php'>
	<label for='courseName'>Kursnamn: </label><input type='text' id='courseName' name='courseName' />
	<br />
	<input type='submit' name='submitCourseCreate' value='Skapa kursen' />
</form>