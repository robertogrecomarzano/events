<!-- Questo file è da usare solo se si vuole attivare la modalita custom-template -->
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Gruppo<span class="help-block">Indicare uno o più gruppi per l'utente</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_checks iname='gruppo' src=$gruppi cols=1}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Cognome</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='cognome' size=25 max=45 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Nome</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='nome' size=25 max=45 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Servizi<span class="help-block">Indicare i servizi a cui è abilitato l'utente</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_checks iname='servizio' src=$servizi cols=1 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Username</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='username' size=20 max=45 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Password</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='password' size=20 max=45 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Consultazione<span class="help-block">Spuntare se si vuole dare accesso in sola lettura</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='sola_lettura'}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Residenza<span class="help-block">Comune e provincia di residenza</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_pr_comuni iname='comune' }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Indirizzo<span class="help-block">Indirizzo di residenza</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='indirizzo' cols=30 rows=2 max=250}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Email<span class="help-block">Indirizzo email</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='email' size=40 max=45 }</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Telefono</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='telefono' size=20 max=30}</div>
	</div>
<div class='btn-group'>{form_add_edit type="button" onclick="return form_insert(this);"}</div>