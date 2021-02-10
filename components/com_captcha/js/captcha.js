function reloadCaptcha()
{
	var captchaimg = $("#captcha");
	$.getJSON(codebase + "/core/ajax.php?plugin=Captcha&action=Reload",
		function(data) {
			$(captchaimg).attr("src",data+"?"+Math.random());
		});
}