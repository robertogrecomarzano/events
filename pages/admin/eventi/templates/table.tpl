<!-- Questo file è da usare solo se si vuole attivare la modalita custom-template -->
<table
	class="table table-hover dataTable no-footer dtr-inline">
	<thead>
		<th></th>
		<th>Evento</th>
		<th>Attivo</th>
		<th>Modello</th>
		<th>Data e ora</th>
		<th>Dati di accesso Zoom</th>
		<th>Logo</th>
		<th>Privacy</th>
	</thead>
	{foreach from=$src.rows key=myId item=row}
	<tr>
		<td>{form_edit id=$row.$pk}{form_delete id=$row.$pk}</td>
		<td>
			<label>{$row.titolo} <img src="{$siteUrl}/core/templates/img/{$row.lingua}.png" height="20px"/></label><br /><small><a class="text-primary" href="{$siteUrl}/p/event/{$row.nome}" target="_blank">{$siteUrl}/p/event/{$row.nome}</a></small>
			
		</td>
		<td>{if !$row.is_offline}<i class="fa fa-check text-success"></i>{/if}</td>
		<td><a rel='popover' class='pop' href='#' data-title='{$row.template|upper}' data-img='{$siteUrl}/public/{$row.template}.png'><img class='#imageresource' src="{$siteUrl}/public/{$row.template}.png" width="100px"/></a></td>
		<td><label class="block">{$row.data}</label>{$row.ora_inizio} - {$row.ora_fine}</td>
		<td>
			{if $row.modalita=="singola"}
			<label class="block"><a class="text-primary" href="{$row.zoom_link}" target="_blank">{$row.zoom_link}</a></label><label class="block">ID: {$row.zoom_id}</label><label class="block">PWD: {$row.zoom_pwd}</label>
			{/if}
		</td>
		<td>{if !empty($row.logo)}<img src="{$siteUrl}/public/{$row.$pk}/{$row.logo}" width="40px"/>{/if}</td>
		<td>{if !empty($row.pdf)}{form_link href="{$siteUrl}/public/{$row.$pk}/{$row.pdf}" value="Informativa sulla privacy" target='_blanck' img='file-pdf-o' class="btn btn-danger btn-xs"}{/if}</td>
	</tr>
	{/foreach}
</table>