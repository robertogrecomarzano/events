{form_opening}
<div class='list-group'>
	<div class='row list-group-item'>
		<label class='control-label col-md-3 col-sm-3 col-xs-12'><strong>Gruppo</strong></label>
		<label class='control-label col-md-9 col-sm-9 col-xs-12'><strong>Servizi</strong></label>
	</div>
	{foreach from=$righe key=myId item=i name=gruppi}
	<div class='row list-group-item'>
		<label class='control-label col-md-3 col-sm-3 col-xs-12'>{$myId}</label>
		<div class='col-md-9 col-sm-9 col-xs-12'>{foreach $i.servizi key=s
			item=i2 name=servizio} {form_check iname="attivo[{$i2.id}]"
			label="{$i2.servizio} ({$i2.descrizione})"} {/foreach}</div>
	</div>
	{/foreach}
</div>
<div class='btn-group'>{form_confirm iname='conferma' label='Conferma i
	permessi' text=true}</div>
{form_closing}
