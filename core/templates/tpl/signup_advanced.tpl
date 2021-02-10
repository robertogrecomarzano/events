<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_surname' size=25 max=45 tabindex='1'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Family name</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_name' size=25 max=45 tabindex='2'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='user_gender' src=['m'=>"Male",'f'=>"Female"] inline=true tabindex='3'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Nationality</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_nationality' required="" src=$nazioni first=true class="selectpicker" data-live-search="true" tabindex='4'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Age<span class="help-block">Indicate a range</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname="user_age" src=["18-24"=>"18-24","25-34"=>"25-34","35-44"=>"35-44","45-54"=>"45-54","55-64"=>"55-64","65+"=>"65+"] first=true tabindex='5'}</div>
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
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Which group do you represent?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
			{form_check iname='user_group[]' value="Researcher (Scientific Community)" label="Researcher (Scientific Community)"}
			{form_check iname='user_group[]' value="Industry" label="Industry"}
			{form_check iname='user_group[]' value="Funder and Investor" label="Funder and Investor"}
			{form_check iname='user_group[]' value="Policy maker" label="Policy maker (e.g. Ministry & Agency; Decision Maker)" onclick="showHidePolicy(this);"}
			<div id="user_group_policy_details"  hidden style="margin-left:50px; padding-top:10px;">
				<label>Please Specify your Institution/Organisation</label> {form_tbox iname='user_policy_maker_institution'}
				<label>Department of Institution/Organisation</label> {form_tbox iname='user_policy_maker_department'}
				<label>Position in the Institution/Organisation</label> {form_tbox iname='user_policy_maker_position'}
			</div>
			{form_check iname='user_group[]' value="Entrepreneur" label="Entrepreneur"}
			{form_check iname='user_group[]' value="Innovator" label="Innovator"}
			{form_check iname='user_group[]' value="International Organization" label="International Organisation" onclick="showHideOrganization(this);"}
			<div id="user_group_organization_details" hidden style="margin-left:50px; padding-top:10px;">
				<label>Please Specify your Institution/Organisation</label> {form_tbox iname='user_international_organisation_institution'}
				<label>Department of Institution/Organisation</label> {form_tbox iname='user_international_organisation_department'}
				<label>Position in the Institution/Organisation</label> {form_tbox iname='user_international_organisation_position'}
			</div>
			{form_check iname='user_group[]' value="Civil society organizations" label="Civil society organizations: (e.g. NGOs, non-profit associations)"}
			{form_check iname='user_group[]' value="Media" label="Media"}
			{form_check iname='user_group[]' value="Farmer association" label="Farmer association"}
			{form_check iname='user_group[]' value="Agribusiness Private Company" label="Agribusiness Private Company"}
			{form_check iname='user_group[]' value="General public" label="General public"}
			{form_check	iname='user_group[]' value="Other" label="Other" onclick="showHideOtherGroup(this);"}
			<div id="user_group_other_details" hidden>
				<label>Please specify</label> {form_tbox iname='user_group_other'}
			</div>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Topic of Interest?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_topic[]' value="Innovation and Digitalization in Agriculture" label="Innovation and Digitalization in Agriculture"}
		{form_check iname='user_topic[]' value="Short Value Chain" label="Short Value Chain"}
		{form_check iname='user_topic[]' value="Agroecological Transitions of Food Systems" label="Agroecological Transitions of Food Systems"}
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">How did you hear about this event?</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		{form_check iname='user_hear[]' value="Website" label="Website"}
		{form_check iname='user_hear[]' value="Different website" label="Different website"}
		{form_check iname='user_hear[]' value="Social media (e.g. Twitter; Fb)" label="Social media (e.g. Twitter; Fb)"}
		{form_check iname='user_hear[]' value="Word of mouth" label="Word of mouth"}
		{form_check	iname='user_hear[]' value="Other" label="Other" onclick="showHideOtherHear(this);"}
		<div id="user_hear_details" hidden>
			<label>Please specify</label>
			{form_tbox iname='user_hear_other'}
		</div>
	</div>
</div>