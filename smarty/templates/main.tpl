{include file="header.tpl"}

<div id='top'>{$userName}</div>
{if $message ne ""}
<div id='message'>{$message}</div>
{/if}
<div id='content'>
<h1>{$title|default:"SendMe"}</h1>
{$siteMenu}
<div id='site'>
	{include file="$page.tpl"}
</div>

{include file="footer.tpl"}

