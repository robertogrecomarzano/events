<table
	class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id='dataTables'>
	<thead>
		<tr>
			<th>Utente</th>
			<th>Gruppo</th>
			<th>Pagina</th>
			<th>Ip</th>
			<th>Update</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$righe key=myId item=i}
		<tr>
			<td>{$i.utente}</td>
			<td>{$i.gruppo}</td>
			<td><a target='_blank' href="{$i.url}">{$i.page}</a></td>
			<td>{$i.ip}</td>
			<td>{$i.orario}</td>
		</tr>
		{/foreach}
	</tbody>
</table>