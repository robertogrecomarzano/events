<form method="post">
	<table
		class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">
		<thead>
			<tr>
				<th />
				<th>Domanda</th>
				<th>Risposta</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$righe item=r} {if $r.$pk == $pkValue && $action ==
			'mod'} {include "./edit.tpl"} {else}
			<tr>
				<td>{form_edit id=$r.$pk}{form_delete id=$r.$pk}</td>
				<td>{$r.question}</td>
				<td>{$r.answer}</td>
			</tr>
			{/if} {/foreach} {if $pkValue == 0 || $action != 'mod'} {include
			"./edit.tpl"} {/if}
		</tbody>
	</table>
	{form_hidden iname='form_action'} {form_hidden iname='form_id'}
</form>