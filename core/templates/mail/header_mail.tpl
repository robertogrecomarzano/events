<link
	href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Eczar|Gentium+Basic|Libre+Baskerville|Libre+Franklin|Proza+Libre|Rubik|Taviraj|Trirong|Work+Sans"
	rel="stylesheet" type="text/css">
<style>
body, p {
	color: #555555;
}

p.title {
	font-family: 'Cormorant Garamond', serif;
	font-size: 2em;
	color: #9b2018;
	font-weight: bolder;
}
</style>
<div style='clear: both;'>
	<div style='float: left; vertical-align: middle;'>
		{if $params.event.show_logo_mail}
			<img src="{$params.event.logo}" height="80px" />
		{/if}
		{if $params.event.show_logo_ciheam_mail}
			<img src="{$siteUrl}/core/templates/img/{$logo}.png" height="80px" />
		{/if}
	</div>
</div>
<br />
<div style='clear: both;'>
	<!-- Questo tag verrà chiudo da footer_mail.tpl -->