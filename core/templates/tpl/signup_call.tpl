<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Surname</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='2'}</div>
</div>
<!-- >div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='user_gender' src=['m'=>"Male",'f'=>"Female"] inline=true tabindex='3'}</div>
</div-->
<div class="form-group">
	<label
		class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='4' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Job position</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_job_position' size=25 max=100 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Institution</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_institution' size=25 max=100 tabindex='6'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Country</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_country' required="" src=$nazioni first=true class="selectpicker" data-live-search="true" tabindex='7'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Address</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_address' size=25 max=45 tabindex='8'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Phone number</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_phone' size=30 max=45 tabindex='9'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Reasons for attending the course (max 400 words)</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='user_note' rows=6 cols=40 tabindex='10'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Attachment: CV (English pdf)</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{$file}</div>
</div>