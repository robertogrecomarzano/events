<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Title</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_title' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Surname/Family name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='3'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='user_gender' src=['Male'=>"Male",'Female'=>"Female","Nonbinary"=>"Nonbinary","I prefer not to say"=>"I prefer not to say"] inline=false tabindex='4'}</div>
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
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Organisation</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization' size=30 max=45 tabindex='8' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Position in the institution</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_position' size=30 max=45 tabindex='11' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Category</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_group[]' value="Scientific community" label="Scientific community"}
		{form_check iname='user_group[]' value="Industry" label="Industry"}
		{form_check iname='user_group[]' value="Civil society" label="Civil society"}
		{form_check iname='user_group[]' value="General public" label="General public"}
		{form_check iname='user_group[]' value="Policy maker" label="Policy maker"}
		{form_check iname='user_group[]' value="Media" label="Media"}
		{form_check iname='user_group[]' value="Investor" label="Investor"}
		{form_check iname='user_group[]' value="Customer" label="Customer"}
		{form_check iname='user_group[]' value="Other – specify" label="Other – specify"  onclick="showHideOtherGroup(this);"}
		<div id="user_group_other_details" hidden><label>Please specify</label> {form_tbox iname='user_group_other'}</div>
	</div>
</div>