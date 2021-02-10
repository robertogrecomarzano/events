function Check(obj) {

	if ($("#password").val() != "" || $("#password2").val() != "")
		if ($("#password").val() != $("#password2").val()) {
			bootbox.alert(messages[lang]["password_different"]);
			return false;
		}

	if (checkRequired({
		cognome : messages[lang]["surname"],
		nome : messages[lang]["name"],
		email : messages[lang]["email"]
		
	})) {
		form_do(obj, null, "confirm");
		return true;
	}
}
