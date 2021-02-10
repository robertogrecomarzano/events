function form_signup_check(obj) {

	if (checkRequired({
		user_title : "Title",
		user_name : "First name",
		user_surname : "Surname",
		'*$("input[type=\'radio\'][name^=user_gender]").filter(\':checked\').length' : "Gender",
		'*$("select[name=\'user_country\'] option:selected").length' : "Country",
		user_email : "Email",
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