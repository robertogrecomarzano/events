{if !empty($return)}
<pre>
{$return}
</pre>
{/if}
{if !empty($debug_message)}
<pre>
{$debug_message}
</pre>
{/if}
{form_opening class="form form-horizontal"}
	
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Destinatario</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname="destinatario" size="50" max="100"}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Email destinatario</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname="email_destinatario" size="50" max="100"}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Oggetto</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname="oggetto" size="50" max="100"}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Testo del messaggio</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname="messaggio" size="50" max="100"}</div>
	</div>
	<div class="btn-group">{form_confirm img="share" value="Inviare email" text=true}</div>
{form_closing}