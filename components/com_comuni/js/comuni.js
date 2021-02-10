function getProvinceList(obj) {
	var cmbProvince = $("#" + obj + "_prov");
	cmbProvince.find('option').remove().end().append("<option />");

	var cmbComuni = $("#" + obj);
	cmbComuni.find('option').remove().end().append("<option />");

	$.getJSON(codebase + "/core/ajax.php?plugin=Comuni&action=listaProvince&p="
			+ $("#" + obj + "_nazione").val(),

	function(data) {
		
		if (data.length > 0) {
			cmbProvince.prop("disabled",false);
			cmbComuni.prop("disabled",false);
			for ( var x in data)
				for ( var n in data[x])
					cmbProvince.append("<option value='" + n + "'>"
							+ data[x][n] + "</option>");
		} else {
			cmbProvince.prop("disabled",true);
			cmbComuni.prop("disabled",true);
		}
	});
}

function getComuniList(obj) {
	var cmbComuni = $("#" + obj);
	$.getJSON(codebase + "/core/ajax.php?plugin=Comuni&action=listaComuni&p="
			+ $("#" + obj + "_prov").val(),

	function(data) {
		cmbComuni.find('option').remove().end().append("<option />");
		for ( var i in data)
			cmbComuni.append("<option value='" + i + "'>" + data[i]
					+ "</option>");
	});
}

function getCodCatasto(obj) {
	var catasto = $("#" + obj + "_cod");
	$.getJSON(codebase + "/core/ajax.php?plugin=Comuni&action=catasto&p="
			+ $("#" + obj).val(), function(data) {
		$(catasto).val(data);
	});
}