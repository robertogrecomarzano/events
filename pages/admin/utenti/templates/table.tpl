	<table
		class="table table-hover dataTable no-footer dtr-inline"
		id="dataTables">
		<thead>
			<th></th>
			<th>Cognome e Nome<br />Codice fiscale</th>
			<th>Gruppi</th>
			<th>Username</th>
			<th>Comune</th>
			<th>Telefono</th>
			<th>Email</th>
		</thead>
		<tbody>
			{foreach from=$righe item=r}
			<tr>
				<td>{form_edit id=$r.$pk writable=$src.writable}{form_delete id=$r.$pk writable=$src.writable}</td>
				<td>{$r.cognome} {$r.nome}</td>
				<td>{$r.profili}</td>
				<td>{$r.username}</td>
				<td>{$r.data->nationality} {$r.citta|comune}</td>
				<td>{if empty($r.telefono)}{$r.data->phone}{else}{$r.telefono}{/if}</td>
				<td>{$r.email}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
