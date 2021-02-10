{if $welcome != ""} 
<a href='{$logout}' onclick="deleteCookie();"><i class="fas fa-sign-out-alt"></i> Esci</a>
{/if}
<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span
	class="text text-xs block"><i class='fa fa-info-circle'></i> Info e contatti <b class="caret"></b>
</span> </span> </a>
<a class='block' href='{$siteUrl}/p/public/aiuto/ticket'
	title='Apri un ticket per maggiore assistenza'><i
	class="fas fa-ticket-alt"></i> Assistenza</a>
<ul class="dropdown-menu animated fadeInRight m-t-xs">
	<li><span class='text text-muted'>Contatti</span> <a
		href="mailto:{Config::$config["
		email"]}" title='Invia una mail per informazioni'><span
			class="text-muted"><i class='fa fa-envelope'></i> </span>{Config::$config["email"]}</a>
		<a href='#' title='Chiama per informazioni'><span class="text-muted"><i
				class='fa fa-phone'></i> </span>{Config::$config["telefono"]}</a></li>
	<li><span class='text text-muted'>Support tecnico</span> <a
		href="mailto:{Config::$config["
		email_support"]}" title='Invia una mail per avere supporto tecnico'><span
			class="text-muted"><i class='fa fa-envelope'></i> </span>{Config::$config["email_support"]}</a>
		<a href='#' title='Chiama per supporto'><span class="text-muted"><i
				class='fa fa-phone'></i> </span>{Config::$config["telefono2"]}</a></li>
	<li class='divider'></li>
	<li><a href='{$siteUrl}/p/public/aiuto/ticket'
		title='Apri un ticket per maggiore assistenza'><span
			class="text-muted"><i class='fas fa-ticket-alt'> </i> Apri un ticket per
				maggiore assistenza </span></a></li>
</ul>

