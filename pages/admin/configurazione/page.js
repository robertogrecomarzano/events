function setConfig(obj,id) {
	var txt = messages[lang]["confirm_msg"];
	var yes = messages[lang]["yes"];
	var cancel = messages[lang]["cancel"];

	bootbox.confirm({
		title : messages[lang]["warning"],
		message : txt,
		buttons : {
			confirm : {
				label : '<i class="fa fa-check"></i> '.yes,
				className : 'btn-success'
			},
			cancel : {
				label : '<i class="fa fa-times"></i> '.cancel,
				className : 'btn-danger'
			}
		},
		callback : function(result) {
			if (result)
				form_do(obj, id, "mod2");
		}
	});
}
