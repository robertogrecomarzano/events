function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "First name",
		user_name : "Family name",
		'*$("input[type=\'radio\'][name^=user_gender]").filter(\':checked\').length' : "Gender",
		user_email : "Email",
		user_job_position : "Jon position",
		user_institution : "Institution",
		'*$("select[name=\'user_country\'] option:selected").length' : "Country",
		user_title : "Submission title",
		user_authors : "List of authors",
		user_session : "Session",
		user_presentation: "Type of presentation",
		'*$("input[name=\'user_attachment\']").val()' : "Attachment: Abstract (Word)",
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