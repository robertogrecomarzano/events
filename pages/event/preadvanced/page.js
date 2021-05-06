$(document).ready(function() {
	init();
	checkOtherSector();
	checkOtherGroup();
});

function form_signup_check(obj) {

	if (checkRequired({
		user_surname : "First name",
		user_name : "Last name",
		'*$("select[name=\'user_country\'] option:selected").length' : "Country",
		user_email : "Email",
		user_organization : "Organization",
		user_age : "Age range",
		user_gender : "Gender",
		user_sector : "Sector",
		user_group : "Stakeholder group",
		captcha_value : "Captcha code"
	})) {

		var privacy_not_check = 0;

		$('input:checkbox[required=required]').each(function(item) {
			if (!$(this).prop("checked")) {
				privacy_not_check++;

			}
		});

		if ($("#user_sector").val() == "other"
				&& ($("#user_sector_other").val() == undefined || $(
						"#user_sector_other").val() == "")) {
			bootbox.alert("Please, specify sector");
			return false;
		}
		

		if ($("#user_group").val() == "other"
				&& ($("#user_group_other").val() == undefined || $(
						"#user_group_other").val() == "")) {
			bootbox.alert("Please, specify group");
			return false;
		}

		if (privacy_not_check > 0) {
			bootbox.alert("Accept all conditions");
			return false;
		}

		form_do(obj, null, "confirm");
		return true;
	}

	return false;
}

function init() {
	
	$("#user_sector").change(function() {
		checkOtherSector();
	});
	$("#user_group").change(function() {
		checkOtherGroup();
	});
}

function checkOtherSector() {
	var ch = $("#user_sector").val() == "other";
	

	if (ch)
		$("#div_user_sector_other").show(300);
	else
		$("#div_user_sector_other").hide(300);

}

function checkOtherGroup() {
	var ch = $("#user_group").val() == "other";

	if (ch)
		$("#div_user_group_other").show(300);
	else
		$("#div_user_group_other").hide(300);

}