
<h2>Mina kurser</h2>
<table>
{foreach from=$kurser item="k"}
<tr><td>{$kurs.id}</td><td>{$k.namn}</td><td>{$k.skapad_datum}</td><td>Redigera</td><td><a href="courses_teacher.php?action=delete&amp;id={$k.id}">Ta bort</a></td></tr>
{/foreach}
</table>

<h2>Skapa en ny kurs.</h2>
<p>Här skapar du en ny kurs i systemet, välj ett kursnamn.</p>
<form method='post' action='courses_teacher.php'>
	<label for='courseName'>Kursnamn: </label><input type='text' id='courseName' name='courseName' />
	<br />
	<input type='submit' name='submitCourseCreate' value='Skapa kursen' />
</form>