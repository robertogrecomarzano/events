<form action="https://ticket.nusys.it/open.php">
	{form_hidden iname="nu_key" value={$api_key}} {form_hidden
	iname="nu_server" value={$api_server}}
	<blockquote>
		<h4>Benvenuto nella sezione del portale di assistenza</h4>
		<small>Se non hai trovato la soluzione al tuo problema nella sezione
			FAQ, inviaci una richiesta di assistenza attraverso l'apertura di un
			ticket.</small>
		<p>Apri un nuovo ticket o verifica lo stato di avanzamento di uno già
			aperto.</p>

		<div class='btn-group'>{form_confirm iname="btnTicketNew" value="Apri
			un ticket" text=true img="edit" } {form_link target='_blank'
			iname="btnTicketView" value="Verifica stato ticket" text=true
			img="check" href='https://ticket.nusys.it/view.php'}</div>
	</blockquote>
</form>