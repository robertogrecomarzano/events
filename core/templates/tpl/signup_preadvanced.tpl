<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Last name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Country</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_country' required="" src=$nazioni first=true class="selectpicker" data-live-search="true" tabindex='3'}</div>
</div>
<div class="form-group">
	<label
		class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='4' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Organization</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization' size=30 max=45 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Age<span class="help-block">Indicate a range</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname="user_age" first=true src=["0-18"=>"0-18","19-30"=>"19-30","31-50"=>"31-50","51-65"=>"51-65","66-80"=>"66-80","80+"=>"80+"] tabindex='6'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_gender' first=true src=['m'=>"Male",'f'=>"Female",'n'=>"Prefer not to say"] inline=true tabindex='7'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Sector</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_sector' first=true tabindex='8' src=$sectors}</div>
</div>
<div class="form-group"  hidden id="div_user_sector_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_sector_other' size=30 max=45 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Stakeholder group</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_group' first=true tabindex='9' src=$groups}</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_group_other' size=30 max=45 tabindex='5'}</div>
</div>