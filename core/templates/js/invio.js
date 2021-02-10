$(document)
		.ready(
				function() {
					var box;

					$(window)
							.keydown(
									function(event) {
										if ((event.keyCode == 13)
												&& ($(event.target)[0] != $("textarea")[0] && $(event.target)[0] != $("div.note-editable")[0])) {
											event.preventDefault();
											box = bootbox
													.alert({
														message : "Per confermare cliccare sul relativo bottone.",
														backdrop : true
													});
											setTimeout(function() {
												bootbox.hideAll();
											}, 3000);
											return false;
										}
									});

				});