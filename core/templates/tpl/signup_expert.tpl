<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Title</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_title' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Surname</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='3'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='user_gender' src=['m'=>"Male",'f'=>"Female"] inline=true tabindex='4'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Country</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_country' required="" src=$nazioni first=true class="selectpicker" data-live-search="true" tabindex='5'}</div>
</div>
<div class="form-group">
	<label
		class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='6' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Phone</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_phone' size=30 max=45 tabindex='7'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Organisation</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization' size=30 max=45 tabindex='8' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Acronym</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization_acronym' size=20 max=20 tabindex='9' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Institute / Department / etc.</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_institution' size=30 max=45 tabindex='10' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Position in the institution</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_position' size=30 max=45 tabindex='11' required=""}</div>
</div>