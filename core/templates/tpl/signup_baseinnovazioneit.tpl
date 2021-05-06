<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Cognome</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=30 max=45 tabindex='1' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Nome</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=30 max=45 tabindex='2' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='3' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Settore</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_group' first=true tabindex='4' src=["creativo"=>"Creativo","agrifood"=>"AgriFood", "other"=>"Altro"]}</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Specificare</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_group_other' size=30 max=45 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Ente di appartenenza</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_business_name' size=30 max=45 tabindex='6' required=""}</div>
</div>