<!-- Questo file è da usare solo se si vuole attivare la modalita custom-template -->
<table
	class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">
	<thead>
		<th></th>
		<th>Campo 1</th>
		<th>Campo 2</th>
		<th>Campo n</th>
	</thead>
	{foreach from=$src.rows key=myId item=row}
	<tr>
		<td>{form_edit id=$row.$pk}{form_delete id=$row.$pk}</td>
		<td>{$row.campo_1}</td>
		<td>{$row.campo_2}</td>
		<td>{$row.campo_n}</td>
	</tr>
	{/foreach}
</table>