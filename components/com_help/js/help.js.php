$(document).ready(init);

function init() {
	$("#help a").click(function() {
		bootbox.alert("<?php Security::getAndStoreCSRFToken(); ?>");
	});
}