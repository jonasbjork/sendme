<h2>Visa fil</h2>
<table>
        <tr><td>Kurs:</td><td>{$kurs}</td><td>Användare:</td><td>{$user}</td></tr>
        <tr><td>Filnamn:</td><td>{$filnamn} <a href='getfile.php?file={$safe_name}'><img src='icons/download.gif' title='Hämta' alt='Hämta' style='border: 0; width: 20px' /></a></td><td>Inlämnad:</td><td>{$inlamnad}</td></tr>
</table>

<br />
{if $kommentarAntal > 0}
	{foreach from=$kommentarer item="k"}
		<table style="border: 1px solid #ccc; background-color: #eee; width: 100%" cellpadding="0" cellspacing="0">
		<tr style="background-color: #ccc"><td>{$k.namn}</td><td align="right">{$k.tid}</td></tr>
		<tr><td colspan="2" style="padding: 1em;">{$k.kommentar}</td></tr>
		</table>
	{/foreach}
{/if}
<form method='post' action='showfile.php?file={$safe_name}'>
<table border=0>
        <tr><td colspan='2'>Kommentarer:</td></tr>
        <tr><td colspan='2'><textarea name='comments' cols='80' rows='10'>{$comments}</textarea></td></tr>
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

