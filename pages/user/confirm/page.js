function Check(obj) {
	if (checkRequired({
		reg_cognome : "Cognome",
		reg_nome : "Nome",
		reg_cf : "Codice Fiscale",
		comune_residenza : "Comune di residenza",
		indirizzo : "Indirizzo di residenza",
		cap : "CAP del comune di residenza",
		email : "Indirizzo email (non PEC)",
		telefono : "Indirizzo il numero di telefono",
		username : "Username",
		password : "Password",
		password2 : "Password di conferma",
		"*$('input[name=reg_sesso]:checked').length>0" : "Indicare il sesso",
		"*jsutil_len('reg_cf') == 16" : "Codice Fiscale non corretto",
		captcha_value : "Inserire il codice di sicurezza",
	})) {
		if ($("#password").val() != $("#password2").val()) {
			bootbox.alert("Le password non coincidono");
			return false;
		}
		form_do(obj, null, "confirm");
		return true;
	}
}
