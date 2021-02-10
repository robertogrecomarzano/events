$(document)
		.ready(
				function() {

					$(document).on("click", "#logout", function(e) {
						
						e.preventDefault(); 
						var logoutLink = this.href;
						
						bootbox.confirm({
							title : "Logout",
							message : messages[lang]["logout_msg"],
							buttons : {
								confirm : {
									label : '<i class="fa fa-check"></i> Yes',
									className : 'btn-success'
								},
								cancel : {
									label : '<i class="fa fa-times"></i> No',
									className : 'btn-danger'
								}
							},
							callback : function(result) {
								if (result)
									window.location.replace(logoutLink);
							}
						});
					});

					$(document).on("focus", ":input", function(e) {
						$(this).addClass("inputhighlight");
					}).on("blur", ":input", function(e) {
						$(this).removeClass("inputhighlight");
					});

					$("a").bind('contextmenu', function(e) {
						bootbox.alert("Use of the right button not allowed.");
						return false;
					});

					$('#dataTables')
							.DataTable(
									{
										dom : "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>><'row't><'row'<'col-md-12'ip>>",
										buttons : [ {
											extend : 'copy',
											text : 'Copia'
										}, {
											extend : 'csv',
											text : 'Csv'
										}, {
											extend : 'excel',
											text : 'Excel'
										}, {
											extend : 'pdfHtml5',
											orientation : 'landscape',
											pageSize : 'LEGAL',
											text : 'Pdf'
										}, {
											extend : 'print',
											text : 'Stampa'
										} ],
										"lengthMenu" : [
												[ 10, 25, 50, 100, 500, 1000,
														-1 ],
												[ 10, 25, 50, 100, 500, 1000,
														"All" ] ],
										"paging" : true,
										"ordering" : true,
										"info" : true,
										"responsive" : true,
										"language" : {
											"sEmptyTable" : messages[lang]["datatable"]["sEmptyTable"],
											"sInfo" : messages[lang]["datatable"]["sInfo"],
											"sInfoEmpty" : messages[lang]["datatable"]["sInfoEmpty"],
											"sInfoFiltered" : messages[lang]["datatable"]["sInfoFiltered"],
											"sInfoPostFix" : messages[lang]["datatable"]["sInfoPostFix"],
											"sInfoThousands" : messages[lang]["datatable"]["sInfoThousands"],
											"sLengthMenu" : messages[lang]["datatable"]["sLengthMenu"],
											"sLoadingRecords" : messages[lang]["datatable"]["sLoadingRecords"],
											"sProcessing" : messages[lang]["datatable"]["sProcessing"],
											"sSearch" : messages[lang]["datatable"]["sSearch"],
											"sZeroRecords" : messages[lang]["datatable"]["sZeroRecords"],
											"oPaginate" : {
												"sFirst" : messages[lang]["datatable"]["oPaginate"]["sFirst"],
												"sPrevious" : messages[lang]["datatable"]["oPaginate"]["sPrevious"],
												"sNext" : messages[lang]["datatable"]["oPaginate"]["sNext"],
												"sLast" : messages[lang]["datatable"]["oPaginate"]["sLast"]
											},
											"oAria" : {
												"sSortAscending" : messages[lang]["datatable"]["sSortAscending"],
												"sSortDescending" : messages[lang]["datatable"]["sSortDescending"]
											}

										}
									});

					$('#myModal').modal({
						show : true
					});
					$('.modal-backdrop').removeClass("modal-backdrop");

				});

jQuery.fn.fadeInOrOut = function(status) {
	return status ? this.fadeIn() : this.fadeOut();
};

function checkRequired(fields) {
	var out = "";
	var v, pre;
	for ( var i in fields) {
		if (i.substr(0, 1) == "*") {
			v = eval(i.substr(1));
		} else {
			v = $("#" + i).val();
		}

		pre = "<span class='text-warning'>" + messages[lang]["required"]
				+ ":</span> ";

		if (!v || v == "")
			out += pre + fields[i] + "<br />";
	}
	if (out != "") {
		bootbox.alert("<h3>" + messages[lang]["warning"] + "</h3>" + out);
		return false;
	} else
		return true;
}

function jsutil_len(id) {
	return $("#" + id).val().length;
}

function changeuser(obj, idUtente) {
	var form = $(obj).parents("form");
	form.find("#form_changeuser").val(idUtente);
	$("#loading").show();
	form.submit();
}

function keyCheck(eventObj, obj, filter) {
	var keyCode;
	if (!eventObj)
		eventObj = window.event;
	if (document.all)
		keyCode = eventObj.keyCode;
	else
		keyCode = eventObj.which;
	// var str = obj.value;
	var bNumericKey = keyCode > 47 && keyCode < 58;
	var bNumericPad = keyCode > 95 && keyCode < 106;
	var bNum = bNumericKey || bNumericPad;
	var bBackSpace = keyCode == 8;
	var bTab = keyCode == 9;
	var bEnter = keyCode == 13;
	var bAllowed = bBackSpace || bTab || bEnter;
	switch (filter) {
	case "num":
		return bAllowed || bNum;
		break;
	case "data":
		obj.onkeyup = function() {
			dataFormat(this);
		};
		obj.onblur = function() {
			dataCheck(this);
		};
		return bAllowed || bNum;
		break;
	default:
		return false;
	}
}

function dataCheck(obj) {
	var good = true;
	var valore = $(obj).val();

	if (valore == "" || valore == undefined)
		return good;

	var s = extractNums(valore);
	var d = s.substring(0, 2);
	var m = s.substring(2, 4);
	var y = s.substring(4);
	var s2 = d + "/" + m + "/" + y;
	if (s2 != valore || s.length != 8) {
		bootbox.alert(messages[lang]["date_not_valid"] + " " + valore);
		good = false;
	} else if (d < 1 || d > 31 || m < 1 || m > 12 || y < 1900 || y > 2100) {
		bootbox.alert(messages[lang]["date_not_valid"] + " " + valore);
		good = false;
	}
	var color = good ? "green" : "red";
	$(obj).attr("style", "color:" + color);
	/*
	 * if (!good) $(obj).val("");
	 */
	return good;
}

function dataFormat(obj) {
	var v = obj.value;
	if (v.length > 2 && v.length <= 5) {
		if (v.length == 3 && v.charAt(2) == '/')
			obj.value = v.substring(0, 2);
		else {
			var s = extractNums(obj.value);
			var s2 = s.substring(0, 2) + "/" + s.substring(2);
			obj.value = s2;
		}
	}
	if (v.length > 5) {
		if (v.length == 6 && v.charAt(5) == '/')
			obj.value = v.substring(0, 5);
		else {
			var s = extractNums(v);
			var s2 = s.substring(0, 2) + "/" + s.substring(2, 4) + "/"
					+ s.substring(4, 8);
			obj.value = s2;
		}
	}
}

function extractNums(str) {
	var o = "";
	for (var i = 0; i < str.length; i++)
		if ("0123456789".indexOf(str.charAt(i)) > -1)
			o += str.charAt(i);
	return o;
}

function solonumeri(campo) {

	var testonum = $(":input[id='" + campo + "']").val();
	if (isNaN(testonum)) {
		bootbox.alert(messages[lang]["only_number"]);
		$(":input[id='" + campo + "']").val("");
		$(":input[id='" + campo + "']").focus();
	}
}