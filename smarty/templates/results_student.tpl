
<h2>Mina resultat</h2>
{if $rattadeAntal > 0}
	<table id='tblResult'>
	<tr style='background-color: #bbb'><th>Kurs</th><th>Uppgift</th><th>Omdöme</th><th>Rättad av</th></tr>
	{foreach from=$rattade item="rattad"}
	<tr style='background-color: {cycle values="#ddd,#eee" advance=true}'><td>{$rattad.kursnamn}</td><td>{$rattad.name}</td><td>
	{if $rattad.betyg == 0}<div class='ig'>--</div>{/if}
	{if $rattad.betyg == 1}<div class='ig'>IG</div>{/if}
	{if $rattad.betyg == 2}<div class='g'>G</div>{/if}
	{if $rattad.betyg == 3}<div class='g'>VG</div>{/if}
	{if $rattad.betyg == 4}<div class='g'>MVG</div>{/if}
	</td><td>{$rattad.fnamn} {$rattad.enamn}</td></tr>
	{/foreach}
	</table>
{else}
<p>Du har inga resultat än.</p>
{/if}