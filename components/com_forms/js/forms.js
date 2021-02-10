/**
 * @param obj
 * @param id
 * @param action
 */
function form_do(obj, id, action) {
	var form = $(obj).parents("form");
	form.find("#form_action").val(action);
	form.find("#form_id").val(id);

	if (obj.type == 'button') {
		$("#loading").show();
		form.submit();
	} else {
		if (action == "mod2" || action == "add2")
			$("form").submit(function(event) {
				event.preventDefault();
			});

		if (action == "mod2" || action == "add2")
			form.unbind('submit').submit(function(event) {
				$("#loading").show();
			});
		else {
			$("#loading").show();
			form.submit();
		}
	}

}

/**
 * 
 * @param obj
 */
function form_confirm(obj) {

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
				form_do(obj, null, "confirm");
		}
	});

}

/**
 * 
 * @param obj
 */
function form_add(obj) {
	form_do(obj, null, "add");
}

/**
 * 
 * @param obj
 * @param id
 */
function form_add2(obj, id) {
	form_do(obj, null, "add2");
}

/**
 * 
 * @param obj
 * @param id
 */
function form_mod(obj, id) {
	form_do(obj, id, "mod");
}

/**
 * 
 * @param obj
 * @param id
 */
function form_mod2(obj, id) {
	form_do(obj, id, "mod2");
}

/**
 * 
 * @param obj
 * @param id
 */

function form_annulla(obj) {
	form_do(obj, null, "annulla");
}
/**
 * 
 * @param obj
 * @param id
 */
function form_del(obj, id) {

	var txt = messages[lang]["delete_msg"];
	var yes = messages[lang]["yes"];
	var cancel = messages[lang]["cancel"];

	bootbox.confirm({
		title : messages[lang]["deleting"],
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
				form_do(obj, id, "del");
		}
	});

}