$(document).ready(function() {
	$(".helpdiv .head").hover(function() {
		$(this).css({
			backgroundColor : "#ffa",
			cursor : "pointer"
		});
	}, function() {
		$(this).css("backgroundColor", "#fff");
	}).click(function() {
		$(this).parent().toggleClass("expanded");
	});

	if ($("#aliasHelp").val() != undefined && $("#aliasHelp").val() != "")
		showAlert($("#aliasHelp").val(),"Hai bisogno di aiuto?", "Clicca qui per consultare la guida.");

});

function showHelp(alias) {
	var helpdiv = $("#helpdiv");
	$(helpdiv)
			.html(
					"<div class='bar'><button type=\"button\" aria-hidden=\"true\" class=\"close\" data-notify=\"dismiss\" onclick=\"helpClose(this)\">×</button></div><div class='head'><h4 id='helpHead'></h4></div><div id='helpContent' class='content'></div>");
	$.getJSON(codebase + "/core/ajax.php?plugin=Help&action=show&p=" + alias,
			function(data) {

				$("#helpHead").html(data.title);
				$("#helpContent").html(data.text);
				$(helpdiv).fadeIn(500);
			});
}

function helpClose() {
	$("#helpdiv").fadeOut(500);
}

function showAlert(alias, titolo, testo) {

	$
			.notify(
					{
						// options
						icon : 'fa fa-question-circle',
						title : '',
						message : alias != null ? '<a href="javascript:void(0);" onclick="showHelp(\''
								+ alias + '\');"><p class="text text-center">'+testo+'</p></a>' : testo,

					},
					{
						// settings
						element : 'body',
						position : null,
						type : "success",
						allow_dismiss : true,
						newest_on_top : false,
						showProgressbar : false,
						placement : {
							from : "bottom",
							align : "right"
						},
						offset : 5,
						spacing : 10,
						z_index : 1031,
						delay : 5000,
						timer : 1500,
						url_target : '_blank',
						mouse_over : null,
						animate : {
							enter : 'animated fadeInRight',
							exit : 'animated fadeOutRight'
						},
						onShow : null,
						onShown : null,
						onClose : null,
						onClosed : null,
						icon_type : 'class',
						template : '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0}" role="alert">'
								+ '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'
								+ '<div class="panel panel-success" style="border:none;">'
								+ '<div class="panel-heading">'
								+ '<span data-notify="icon"></span> ' + titolo
								+ '<span data-notify="title">{1}</span> '
								+ '</div>'
								+ '<div class="panel-body">'
								+ '<span data-notify="message">{2}</span>'
								+ '<div class="progress" data-notify="progressbar">'
								+ '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>'
								+ '</div>'
								+ '<a href="{3}" target="{4}" data-notify="url"></a>'
								+ '</div>'
								+ '</div>'
					});
}