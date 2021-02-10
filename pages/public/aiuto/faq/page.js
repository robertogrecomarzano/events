$(document).ready
(
	function ()
	{
		$(".faq .a").hide();
		$(".faq .q a").click(toggleFaq);
	}
)

function toggleFaq(e)
{
	$(this).parent().parent().find(".a").slideToggle(200);
}
