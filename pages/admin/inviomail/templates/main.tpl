{if !empty($return)}
<pre>
{$return}
</pre>
{/if}
{if !empty($debug_message)}
<pre>
{$debug_message}
</pre>
{/if}
{form_opening class="form form-horizontal"}
	
	<table
	class="table table-striped able-hover no-footer dtr-inline">
	<thead>
		<tr>
			<th>Titolo / Oggetto della mail</th>
			<th>Inviare reminder o link</th>
		</tr>
		</thead>
	{foreach from=$eventi item=event}
		<tr>	
			<td><b>{$event.titolo}</b></td>
			<th>{form_radios iname="event[{$event.id_evento}]" src=$emails inline=true}</th>
		</tr>
	{/foreach}
	</table>
	
{form_check iname="reset" text=true label="Reinviare la mail a tutti"}
	
	<div class="btn-group">
		
		{form_confirm img="save" value="Salva" text=true read-allowed=true}
		{form_button img="undo" value="Annulla" text=true class="btn btn-danger" onclick="formAnnulla(this);" read-allowed=true}
		
		{form_button class="btn btn-warning" img="envelope" value="Invio mail di prova" onclick="formProva(this);" text=true read-allowed=true}
	</div>
	
{form_closing}


