function formAnnulla(obj) {
	bootbox.confirm({
		title : "Annullare tutti gli invii",
		message : "Tutti gli invii predisposti saranno annullati",
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
				form_do(obj, null, "annulla");

		}
	});
}

function formProva(obj) {
	bootbox.confirm({
		title : "Invio mail di prova",
		message : "Verrà inviata una mail di prova all'indirizzo indicato nel campo Email all'interno del form di creazione dell'evento",
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
				form_do(obj, null, "prova");

		}
	});
}