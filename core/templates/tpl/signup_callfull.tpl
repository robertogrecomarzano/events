<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Surname</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='user_gender' src=['Man'=>"Man",'Woman'=>"Woman","Nonbinary"=>"Nonbinary","I prefer not to say"=>"I prefer not to say"] inline=false tabindex='3'}</div>
</div>
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
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Submission title</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_title' size=25 max=100 tabindex='10'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">List of authors</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_authors' size=25 max=100 tabindex='11'}</div>
</div>
<!--div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Session</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_session[]' value="Environment, ecology and ecosystem services" label="Environment, ecology and ecosystem services" tabindex='12'}
		{form_check iname='user_session[]' value="Society and culture" label="Society and culture"}
		{form_check iname='user_session[]' value="Economy and finance" label="Economy and finance"}
		{form_check iname='user_session[]' value="Policy, institutions and governance" label="Policy, institutions and governance"}
	</div>
</div-->
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Session</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname="user_session" src=["Environment, ecology and ecosystem services"=>"Environment, ecology and ecosystem services","Society and culture"=>"Society and culture","Economy and finance"=>"Economy and finance","Policy, institutions and governanc"=>"Policy, institutions and governanc"] first=true tabindex='12'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Type of presentation</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname="user_presentation" src=["Oral"=>"Oral","Poster"=>"Poster"] first=true tabindex='13'}</div>
</div>

<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Attachment: Abstract (Word)</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{$file}</div>
</div>