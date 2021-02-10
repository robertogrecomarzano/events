<tr class='inline_edit'>
	<td>{form_select first=true name='risorsa' src=$risorse
		key='id_risorsa' label='name'}</td>
	<td>{form_select first=true name='gruppo' src=$gruppo key='id_gruppo'
		label='gruppo'}</td>
	<td style="text-align: center">{form_check iname="read"}</td>
	<td style="text-align: center">{form_check iname="update"}</td>
	<td style="text-align: center">{form_check iname="delete"}</td>
	<td style="text-align: center">{form_check iname="add"}</td>
	<td>{if $pkValue != 0 && $action == 'mod'}{form_edit id=$pkValue
		inline=true}{else}{form_add}{/if}</td>
</tr>