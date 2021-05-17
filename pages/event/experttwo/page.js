function form_signup_check(obj) {

	if (checkRequired({
		user_title : "Title",
		user_name : "Name",
		user_surname : "Surname/Family name",
		'*$("input[type=\'radio\'][name^=user_gender]").filter(\':checked\').length' : "Gender",
		'*$("select[name=\'user_country\'] option:selected").length' : "Country",
		user_email : "Email",
		'*$("input[type=\'checkbox\'][name^=user_group]").filter(\':checked\').length' : "Category",
		captcha_value : "Captcha code"
	})) {

		if ($("input[type='checkbox'][name^=sessions]").length > 0)
			if ($("input[type='checkbox'][name^=sessions]").filter(':checked').length == 0) {
				bootbox.alert("Please, select at least one session");
				return false;
			}
		
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

function showHideOtherGroup(obj) {

	if ($(obj).prop("checked"))
		$("#user_group_other_details").show(500);
	else
		$("#user_group_other_details").hide(200);
}