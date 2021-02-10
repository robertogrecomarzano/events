<tr class='inline_edit'>
	<td>{form_tbox name='gruppo' size=40}</td>
	<td>{form_tbox name='descrizione' size=40}</td>
	<td>{if $pkValue != 0 && $action == 'mod'}{form_edit id=$pkValue
		inline=true}{else}{form_add}{/if}</td>
</tr>
