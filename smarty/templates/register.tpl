{include file="header.tpl" title="SendMe - Logga in"}
<div id='content'>
<h1>SendMe</h1>
<br />
<div align="center">

<form method='post' action='register.php'>
	<table id="formRegister" style="width: 200px; background-color: #eee; border: 1px solid #ccc;" cellspacing=0>
		<tr><th colspan="2" style="padding: 5px; background-color: #0066cc; color: #fff; text-align: left; text-weight: bold; font-family: verdana, arial, sans-serif">Registera konto</th></tr>
		<tr><td colspan="2"><p>Börja med att fylla i dina uppgifter nedan. Ett e-postmeddelande kommer skickas till dig med en registeringslänk som du måste använda för att aktivera ditt användarkonto. I samma e-postmeddelande kommer du få ett lösenord till ditt konto, när du aktiverat ditt användarkonto kan du själv byta lösenord under <em>Mina inställningar</em> som du kommer åt efter att du loggat in.</p></td></tr>
		
		{if $m}
		<tr style="width: 100%; background-color: #ccffcc;"><td colspan="2" style="border: 1px solid #88ff88; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: verdana, arial, sans-serif; font-weight: bold">{$m}</td></tr>
		<tr><td colspan="2" style="height: 10px"> </td></tr>
		{/if} 
		
		<tr><td style="text-decoration: none; color: #333; font-size: 12px; font-family: verdana,arial,sans-serif">Ditt namn:</td><td><input type='Namn' id='Namn' name='Namn' style="width: 20em; border: 1px solid #ccc" /></td></tr>
		
		<tr><td style="text-decoration: none; color: #333; font-size: 12px; font-family: verdana,arial,sans-serif">E-postadress:</td><td><input type='ePost' id='ePost' name='ePost' style="width: 20em; border: 1px solid #ccc" /></td></tr>
		
		<tr><td style="text-align: right"><img id="captcha" src="includes/securimage/securimage_show.php" alt="CAPTCHA Image" /><br /><a href="#" onclick="document.getElementById('captcha').src = 'includes/securimage/securimage_show.php?' + Math.random(); return false" style="text-decoration: none; color: #333; font-size: 10px; font-family: verdana,arial,sans-serif">Ny bild</a></td><td valign="top"><span style="color: #333; font-size: 10px; font-family: verdana,arial,sans-serif">Mata in säkerhetskoden till vänster.</span><br /><input type="text" name="ccode" style="width: 10em; border: 1px solid #ccc" /></td></tr>
		<tr><th colspan="2" style="padding: 5px; background-color: #0066cc; color: #fff; text-align: right; text-weight: bold; font-family: verdana, arial, sans-serif"><input type='submit' name='registerSubmit' value='Registera konto' /></td></tr>
	</table>
</form>
</div>
{include file="footer.tpl"}