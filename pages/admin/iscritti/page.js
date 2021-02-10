function form_insert(obj) {

	if (checkRequired({
		"*$('input[name^=gruppo]:checked').length > 0" : "Indicare almeno un gruppo",
		"*$('input[name^=servizio]:checked').length > 0" : "Indicare almeno un servizio",
		cognome : "Cognome",
		nome : "Nome",
		email : "Indirizzo email",
		username : "Username"
	}))
		bootbox
				.confirm({
					title : "Registrazione nuovo utente",
					message : "Registrazione di un nuovo utente del sistema. Vuoi procedere?",
					buttons : {
						confirm : {
							label : '<i class="fa fa-check"></i> Si',
							className : 'btn-success'
						},
						cancel : {
							label : '<i class="fa fa-times"></i> Annulla',
							className : 'btn-danger'
						}
					},
					callback : function(result) {
						if (result) {
							var action = $("#form_action").val();
							var action_id = $("#form_id").val();

							switch (action) {
							case "add":
								return form_add2(obj);
								break;
							case "mod":
								return form_mod2(obj, action_id);
								break;
							}
						}
					}
				});

}

function form_esporta(obj) {

	var evento = $("#evento").val();
	if (evento == "") {
		bootbox.alert("Selezionare l'evento");

		return false;
	}
	var txt = "Sei sicuro di voler esportare l'elenco in formato Excel?";

	bootbox.confirm({
		title : "Esportazione in excel",
		message : txt,
		buttons : {
			confirm : {
				label : '<i class="fa fa-check"></i> Si',
				className : 'btn-success'
			},
			cancel : {
				label : '<i class="fa fa-times"></i> Annulla',
				className : 'btn-danger'
			}
		},
		callback : function(result) {
			if (result)
				form_do(obj, null, "export");

		}
	});
	return true;

}

function form_delete(obj) {

	var evento = $("#evento").val();
	if (evento == "") {
		bootbox.alert("Selezionare l'evento");

		return false;
	}

	var txt = "Sei sicuro di voler eliminare l'intero elenco di iscritti per l'evento?";

	bootbox.confirm({
		title : "Cancellazione iscritti",
		message : txt,
		buttons : {
			confirm : {
				label : '<i class="fa fa-check"></i> Si',
				className : 'btn-success'
			},
			cancel : {
				label : '<i class="fa fa-times"></i> Annulla',
				className : 'btn-danger'
			}
		},
		callback : function(result) {
			if (result)
				form_do(obj, null, "cancella");

		}
	});
	return true;

}