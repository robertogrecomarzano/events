function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "First name",
		user_name : "Family name",
		//'*$("input[type=\'radio\'][name^=user_gender]").filter(\':checked\').length' : "Gender",
		user_email : "Email",
		user_job_position : "Jon position",
		user_institution : "Institution",
		'*$("select[name=\'user_country\'] option:selected").length' : "Country",
		'*$("input[name=\'user_attachment\']").val()' : "Attachment: CV (English)",
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