<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Family name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_email' size=30 max=45 tabindex='3' type='email' required="email"}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 text-right required">Country</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_country' required="" src=$nazioni first=true class="selectpicker" data-live-search="true" tabindex='4'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Organization</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_organization' size=30 max=45 tabindex='5' required=""}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">What stakeholder group do you represent?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_group[]' value="Researcher (Scientific Community)" label="Researcher (Scientific Community)"}
		{form_check iname='user_group[]' value="Food industry" label="Food industry"}
		{form_check iname='user_group[]' value="Packaging industry" label="Packaging industry"}
		{form_check iname='user_group[]' value="Policy maker" label="Policy maker (e.g. Ministry & Agency; Decision Maker) " onclick="showHidePolicy(this);"}
		<div id="user_group_policy_details"  hidden style="margin-left:50px; padding-top:10px;">
			<label>Please Specify your Institution/Organisation</label> {form_tbox iname='user_policy_maker_institution'}
			<label>Department of Institution/Organisation</label> {form_tbox iname='user_policy_maker_department'}
			<label>Position in the Institution/Organisation</label> {form_tbox iname='user_policy_maker_organization'}
		</div>
		{form_check iname='user_group[]' value="Civil society organizations" label="Civil society organizations: (e.g. NGOs, non-profit associations)"}
		{form_check iname='user_group[]' value="Retail" label="Retail"}
		{form_check iname='user_group[]' value="Media" label="Media"}
		{form_check iname='user_group[]' value="Other" label="Other"  onclick="showHideOtherGroup(this);"}
		<div id="user_group_other_details" hidden><label>Please specify</label> {form_tbox iname='user_group_other'}</div>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">How did you hear about this event?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_hear[]' value="Website" label="Website"}
		{form_check iname='user_hear[]' value="Different website" label="Different website"}
		{form_check iname='user_hear[]' value="Social media (e.g. Twitter; Fb)" label="Social media (e.g. Twitter; Fb)"}
		{form_check iname='user_hear[]' value="Word of mouth" label="Word of mouth"}
		{form_check iname='user_hear[]' value="Other" label="Other"  onclick="showHideOtherHear(this);"}
		<div id="user_hear_details" hidden><label>Please specify</label> {form_tbox iname='user_hear_other'}</div>
	</div>
</div>					