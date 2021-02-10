function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "First name",
		user_name : "Family name",
		'*$("select[name=\'user_nationality\'] option:selected").length' : "Nationality",
		user_email : "Email",
		'*$("input[type=\'checkbox\'][name^=user_group]").filter(\':checked\').length' : "Which group do you represent",
		'*$("input[type=\'checkbox\'][name^=user_topic]").filter(\':checked\').length' : "Topic of Interest",
		'*$("input[type=\'checkbox\'][name^=user_hear]").filter(\':checked\').length' : "How did you hear about this event",
		captcha_value : "Captcha code"
	})) {

		var privacy_not_check = 0;

		$('input:checkbox[required=required]').each(function(item) {
			if (!$(this).prop("checked")) {
				privacy_not_check++;

			}
		});

		if (privacy_not_check > 0) {
			bootbox.alert("Accept all conditions");
			return false;
		}

		form_do(obj, null, "confirm");
		return true;
	}

	return false;
}

function showHidePolicy(obj) {

	if ($(obj).prop("checked"))
		$("#user_group_policy_details").show(500);
	else
		$("#user_group_policy_details").hide(200);
}

function showHideOrganization(obj) {

	if ($(obj).prop("checked"))
		$("#user_group_organization_details").show(500);
	else
		$("#user_group_organization_details").hide(200);
}

function showHideOtherGroup(obj) {

	if ($(obj).prop("checked"))
		$("#user_group_other_details").show(500);
	else
		$("#user_group_other_details").hide(200);
}

function showHideOtherHear(obj) {

	if ($(obj).prop("checked"))
		$("#user_hear_details").show(500);
	else
		$("#user_hear_details").hide(200);
}