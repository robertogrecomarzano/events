<tr class='inline_edit'>
	<td>{if $pkValue != 0 && $action == 'mod'}{form_edit id=$pkValue
		inline=true}{else}{form_add2}{/if}</td>
	<td><label>Domanda</label>{form_area iname='question' rows=2 cols=50}</td>
	<td><label>Risposta</label>{form_area iname='answer' rows=2 cols=50}</td>
</tr>
