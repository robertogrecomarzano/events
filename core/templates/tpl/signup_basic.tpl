<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Surname</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=30 max=45 tabindex='1' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=30 max=45 tabindex='2' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Email address</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='3' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Which stakeholder group do you represent?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_group' first=true tabindex='4' src=["international and intergovernmental organizations"=>"International and Intergovernmental Organizations","governments"=>"Governments", "academic and research institutions"=>"Academic and Research Institutions","private"=>"Private Sector","civil society"=>"Civil Society","other"=>"Other"] required=""}</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Specify</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_group_other' size=30 max=45 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Organization</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization' size=30 max=45 tabindex='6' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Position</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_position' size=30 max=45 tabindex='6' required=""}</div>
</div>