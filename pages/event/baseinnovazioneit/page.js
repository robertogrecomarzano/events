$(document).ready(function() {
	init();
	checkOtherTipologia();
});

function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "Cognome",
		user_name: "Nome",
		user_email : "Email",
		captcha_value : "Codice captcha"
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
			bootbox.alert("Specificare il settore");
			return false;
		}

		if (privacy_not_check > 0) {
			bootbox.alert("Accettare le condizioni sulla privacy");
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