$(document).ready(function() {
	init();
	checkOtherTipologia();
});

function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "Surname",
		user_name: "Name",
		user_email : "Email",
		user_group : "Stakeholder group",
		user_organization : "Organization",
		captcha_value : "Captcha code"
	})) {

		var privacy_not_check = 0;

		$('input:checkbox[required=required]').each(function(item) {
			if (!$(this).prop("checked")) {
				privacy_not_check++;

			}
		});

		if ($("#user_group").val() == "other"
				&& ($("#user_group_other").val() == undefined || $(
						"#user_group_other").val() == "")) {
			bootbox.alert("Please, specify group");
			return false;
		}

		if (privacy_not_check > 0) {
			bootbox.alert("Accept all privacy conditions");
			return false;
		}

		form_do(obj, null, "confirm");
		return true;
	}

	return false;
}

function init() {

	$("#user_group").change(function() {
		checkOtherTipologia();
	});
}

function checkOtherTipologia() {
	var ch = $("#user_group").val() == "other";

	if (ch)
		$("#div_user_group_other").show(300);
	else
		$("#div_user_group_other").hide(300);

}