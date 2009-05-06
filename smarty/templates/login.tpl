{include file="header.tpl" title="SendMe - Logga in"}
<div id='content'>
<h1>SendMe</h1>

<div align="center">

<form method='post' action='login.php' name='formLogin'>
	<table id='loginForm' style="width: 400px; background-color: #eee; border: 1px solid #ccc;" cellspacing=0>
		<tr><th colspan="2" style="padding: 5px; background-color: #0066cc; color: #fff; text-align: left; text-weight: bold; font-family: verdana, arial, sans-serif">Logga in</th></tr>

		<tr><td colspan="2"><p>För att logga in anger du din e-postadress och ditt lösenord. Har du inget
användarkonto ännu skapar du ett enkelt på <a href='register.php'>registeringssidan</a>.</p></td></tr>

		{if $error}
		
		<tr style="background-color: #ffaaaa;"><td colspan="2" style="border: 1px solid red; color: #333">{$error}</td></tr>
		
		{/if}

		<tr><td style="text-decoration: none; color: #333; font-size: 12px; font-family: verdana,arial,sans-serif">Användarnamn:</td><td><input type='text' id='userName' name='userName' style="width: 20em; border: 1px solid #ccc" /></td></tr>

		<tr><td style="text-decoration: none; color: #333; font-size: 12px; font-family: verdana,arial,sans-serif">Lösenord:</td><td><input type='password' id='userPass' name='userPass' style="width: 20em; border: 1px solid #ccc" /></td></tr>

		<tr><td colspan="2" style="height: 15px"> </td></tr>

		<tr><th colspan="2" style="padding: 5px; background-color: #0066cc; color: #fff; text-align: right; text-weight: bold; font-family: verdana, arial, sans-serif"><input type='submit' name='submitLogin' value='Logga in' /></th></tr>
    </table>
</form>

</div>
</div>
{include file="footer.tpl"}
