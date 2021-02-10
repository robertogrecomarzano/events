<form method="post">
	{$formToken}
	<table
		class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">
		<thead>
			<tr>
				<th>Risorsa</th>
				<th>Gruppo</th>
				<th>Read</th>
				<th>Update</th>
				<th>Delete</th>
				<th>Add</th>
				<th />
			</tr>
		
		
		<tbody>
			{foreach from=$righe key=myId item=i} {if $i.$pk == $pkValue &&
			$action == 'mod'} {include "./edit.tpl"} {else}
			<tr id='{$i.id}'>
				<td>{$i.risorsa}</td>
				<td>{$i.gruppo}</td>
				<td style="text-align: center; font-weight: bolder;">{$i.read}</td>
				<td style="text-align: center; font-weight: bolder;">{$i.update}</td>
				<td style="text-align: center; font-weight: bolder;">{$i.delete}</td>
				<td style="text-align: center; font-weight: bolder;">{$i.add}</td>
				<td>{form_edit id=$i.$pk}{form_delete id=$i.$pk}</td>
			</tr>
			{/if} {/foreach} {if $pkValue == 0 || $action != 'mod'} {include
			"./edit.tpl"} {/if}
		</tbody>
	</table>
	{form_hidden iname='form_action'} {form_hidden iname='form_id'}
</form>