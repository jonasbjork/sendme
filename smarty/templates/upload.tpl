<h2>Ladda upp en fil</h2>
<p>Här laddar du upp dina uppgifter till SendMe.</p>
<form method='post' action='upload.php' enctype='multipart/form-data'>
<table id='uploadForm'>
	<tr><td>Kurs:</td><td><select name='course' id='uploadCourse'>
	<option value='0'>Välj kurs..</option>
	{foreach from=$kurser item=kurs}
		<option value='{$kurs.id}' {if $kurs.id == $selected} selected='selected'{/if}>{$kurs.namn}</option>
	{/foreach}
</select></td></tr>
	<tr><td>Fil att ladda upp:</td><td><input type='file' name='uploadFile' /></td></tr>
	<tr><td>Kommentar:</td><td><textarea cols='40' rows='10' name='fileComment'>{$fc}</textarea></td></tr>
	<tr><td>&nbsp;</td><td align='right'><input type='submit' name='submitFile' value='Ladda upp' class='submitButton' /></td></tr>
</table>
</form>
