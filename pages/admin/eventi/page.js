$(document)
		.ready(
				function() {

					$('#nome').keyup(function() {
						this.value = this.value.toLocaleLowerCase();
					});

					$(".pop").on("click", function() {

						$('#imagepreview').attr('src', $(this).data("img"));
						$('#imagemodal').modal('show');
						$("#myModalLabel").html($(this).data("title"));
						$('.modal-backdrop').removeClass("modal-backdrop");
					});

					// Changing the class of status label to support Bootstrap 4
					var bs = $.fn.tooltip.Constructor.VERSION;
					var str = bs.split(".");
					if (str[0] == 4) {
						$(".label").each(
								function() {
									var classStr = $(this).attr("class");
									var newClassStr = classStr.replace(
											/label/g, "badge");
									$(this).removeAttr("class").addClass(
											newClassStr);
								});
					}

					$('#descrizione, #privacy_registrazione_video')
							.summernote(
									{
										toolbar : [ [
												'style',
												[ 'bold', 'italic',
														'underline', 'clear' ] ] ],

										dialogsInBody : true,
										height : "100px",
										width : "100%",
										cleaner : {
											action : 'both',
											newline : '<br>',
											notStyle : 'position:absolute;top:0;left:0;right:0',
											icon : '<i class="note-icon">[Your Button]</i>',
											keepHtml : false,
											keepClasses : false,
											badTags : [ 'style', 'script',
													'applet', 'embed',
													'noframes', 'noscript',
													'html' ],
											badAttributes : [ 'style', 'start' ],
											limitChars : false,
											limitDisplay : 'both',
											limitStop : false

										}

									});

					$('#message, #greeting_message')
							.summernote(
									{
										toolbar : [
												['style',[ 'bold', 'italic','underline','clear' ]],
												['para', ['ul', 'ol', 'paragraph']],
												[ 'insert', [ 'link' ] ], ],

										dialogsInBody : true,
										height : "100px",
										width : "100%",
										cleaner : {
											action : 'both',
											newline : '<br>',
											notStyle : 'position:absolute;top:0;left:0;right:0',
											icon : '<i class="note-icon">[Your Button]</i>',
											keepHtml : false,
											keepClasses : false,
											badTags : [ 'style', 'script',
													'applet', 'embed',
													'noframes', 'noscript',
													'html' ],
											badAttributes : [ 'style', 'start' ],
											limitChars : false,
											limitDisplay : 'both',
											limitStop : false

										}

									});

					$('a[rel=popover]').popover(
							{
								container : '.form-horizontal',
								html : true,
								trigger : 'hover',
								placement : 'bottom',
								content : function() {
									return '<img width="350px" src="'
											+ $(this).data('img') + '" />';
								}
							});

				});

function form_insert(obj) {

	if (checkRequired({
		"*$('input[name^=lingua]:checked').length > 0" : "Selezionare la lingua",
		titolo : "Indicare il titolo",
		nome : "Indicare il nome",
		"*$('input[name^=template]:checked').length > 0" : "Selezionare un modello",
		data : "Indicare la data dell'evento"
	}))
		bootbox.confirm({
			title : "Registrazione evento",
			message : "Registrazione/modifica di un evento. Vuoi procedere?",
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