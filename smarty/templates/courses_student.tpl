
<h2>Mina kurser</h2>
<p>Här kan du se vilka kurser du är medlem i och lägga till nya.</p>
{if $minaKurserAntal > 0}
	<table>
	{foreach from=$minaKurser item="entry"}
	<tr><td><a href='upload.php?course={$entry.id}'>{$entry.namn}</a></td><td>( {$entry.larare} )</td></tr>
	{/foreach}
	</table>
{else}
	<p><strong>Du är inte registerad i någon kurs än.</strong></p>
{/if}
<h2>Gå med i en ny kurs</h2>

<form method='post' action='courses_student.php'>
<select name='kurs_id'>
{foreach from=$kurser item="entry"}
	<option value='{$entry.id}'>{$entry.namn}</option>
{foreachelse}
	<option value='0'>Det finns inga kurser</option>
{/foreach}
</select>
<input type='submit' name='submitAddCourse' value='Gå med' />
</form>
