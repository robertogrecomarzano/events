function recovery(obj)
{
	var email = $("#email").val();
	var captcha = $("#captcha_value").val();

	if (email == "" || email == undefined) {
		bootbox.alert(messages[lang]["email_required"]);
		$("#email").focus();
		return false;
	}
	
	if (captcha == "" || captcha == undefined) {
		bootbox.alert(messages[lang]["captcha_required"]);
		$("#captcha_value").focus();
		return false;
	}

	form_do(obj, null, 'recovery');
}