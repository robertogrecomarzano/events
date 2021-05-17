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
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_sector' first=true tabindex='8' src=[
    	"Crops" => "Crops",
    	"Fish and aquaculture" => "Fish and aquaculture",
    	"Livestock" => "Livestock",
    	"Agroforestry" => "Agroforestry",
    	"Environment and ecology e.g. water, land, soils, conservation" => "Environment and ecology e.g. water, land, soils, conservation",
    	"Trade and commerce" => "Trade and commerce",
    	"Education e.g. school, university, scientific institution" => "Education e.g. school, university, scientific institution",
    	"Communication e.g. media, culture, IT" => "Communication e.g. media, culture, IT",
    	"Food processing e.g. freezing, cooking" => "Food processing e.g. freezing, cooking",
    	"Food retail e.g. supermarkets, markets" => "Food retail e.g. supermarkets, markets",
    	"Food industry e.g. hotels, catering, transport, tourism" => "Food industry e.g. hotels, catering, transport, tourism",
    	"Financial Services e.g. banking, investment, insurance" => "Financial Services e.g. banking, investment, insurance",
    	"Health care e.g. hospitals, maternity, general practice" => "Health care e.g. hospitals, maternity, general practice",
    	"National or local government" => "National or local government",
    	"Utilities e.g. water, gas, electric" => "Utilities e.g. water, gas, electric",
    	"Industrial e.g. engineering, chemical, construction, textiles, extraction" => "Industrial e.g. engineering, chemical, construction, textiles, extraction",
    	"Other" => "Other (please state)"]}
    </div>
</div>
<div class="form-group"  hidden id="div_user_sector_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_sector_other' size=30 max=45 tabindex='5'}</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Stakeholder group</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='user_group' first=true tabindex='9' src=[
    "Small-medium enterprise-artisan" => "Small-medium enterprise-artisan",
    "Large national business" => "Large national business",
    "Multinational corporation" => "Multinational corporation",
    "Small-scale farmer" => "Small-scale farmer",
    "Medium-scale farmer" => "Medium-scale farmer",
    "Large-scale farmer" => "Large-scale farmer",
    "Local Non-Governmental Organization" => "Local Non-Governmental Organization",
    "International NGO" => "International NGO",
    "Indigenous people" => "Indigenous people",
    "Science and academia" => "Science and academia",
    "Workers and trade union" => "Workers and trade union",
    "Member of Parliament" => "Member of Parliament",
    "Local authority e.g. local and subnational government" => "Local authority e.g. local and subnational government",
    "Government and national institution" => "Government and national institution",
    "Regional economic community e.g. African Union, European Union" => "Regional economic community e.g. African Union, European Union",
    "United Nations" => "United Nations",
    "International financial institution e.g. World Bank, IMF, regional bank" => "International financial institution e.g. World Bank, IMF, regional bank",
    "Private Foundation- Partnership-Alliance" => "Private Foundation- Partnership-Alliance",
    "Consumer group" => "Consumer group",
    "Other" => "Other (please state)"
]}</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='user_group_other' size=30 max=45 tabindex='5'}</div>
</div>