<!DOCTYPE html>
<html lang="{Config::$defaultLocale|substr:0:2}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{$title}</title>

<!-- Bootstrap Core CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">

<!-- MetisMenu CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/metisMenu/metisMenu.min.css"
	rel="stylesheet">

<!-- Common CSS -->
<link href="{$siteUrl}/core/templates/css/common.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="{$siteUrl}/core/templates/css/style.css" rel="stylesheet">

<!-- Sidebar CSS -->
<link href="{$siteUrl}/core/templates/css/sidebar.css" rel="stylesheet">

<link href="{$siteUrl}/core/templates/css/custom.css" rel="stylesheet">

<!-- font awesome  -->
<link
	href="{$siteUrl}/core/templates/vendor/font-poppins/font-poppins.css"
	rel="stylesheet">

<!-- font awesome  -->
<link
	href="{$siteUrl}/core/templates/vendor/font-awesome-free-5.6.3/css/all.css"
	rel="stylesheet">
<link
	href="{$siteUrl}/core/templates/vendor/font-awesome-4.7.0/css/font-awesome.min.css"
	rel="stylesheet">

</head>

<div class="row">
	<div class="faded-bg animated"></div>
	<div class="col-sm-12 col-md-12">
		<div class="clearfix">
			<div class="col-sm-12 col-md-12">
				<div class="col-lg-6 col-md-offset-3">
					<h1>{form_lang value='SIGNUP_CONFIRM_TITLE'}</h1>
					{if $confirmed}
					<div class="panel">
						<p>{form_lang value='SIGNUP_CONFIRM_TEXT'}</p>
					</div>
					{/if}
					<p class="lead">
						<a href="{$siteUrl}" class="btn btn-lg btn-default">Home</a>
					</p>

				</div>
			</div>

		</div>

	</div>


</div>
<!-- .row -->
</div>
<!-- .container-fluid -->

<!-- JQuery -->
<script
	src="{$siteUrl}/core/templates/vendor/jquery/jquery-3.3.1.min.js"></script>


<!-- Bootstrap Core JavaScript -->
<script
	src="{$siteUrl}/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>



<!-- Bootbox dialog boxes JavaScript -->
<script src="{$siteUrl}/core/templates/vendor/bootbox/bootbox.min.js"></script>

<!-- Bootstrap Notify -->
<script
	src="{$siteUrl}/core/templates/vendor/bootstrap-notify-master/bootstrap-notify.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script
	src="{$siteUrl}/core/templates/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="{$siteUrl}/core/templates/js/template-script.js"></script>

<!-- Main Language JavaScript -->
<script src="{$siteUrl}/core/templates/js/language.js"></script>


<!-- Main JavaScript -->
<script src="{$siteUrl}/core/templates/js/main.js"></script>

{$css}{$js}


<div id='loading' onclick="$(this).hide();" class="modal fade in"
	tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
	data-backdrop="static" data-keyboard="false"
	style="padding-right: 17px;" aria-hidden="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{form_lang value="LOADING"}</h4>
				<h4 class="modal-title">
					<small id="myModalLabel"></small>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="progress progress-striped active">
							<div class="progress-bar" style="width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- start-smoth-scrolling -->
<script type="text/javascript"
	src="{$siteUrl}/core/templates/vendor/smart-scrolling/move-top.js"></script>

<script type="text/javascript"
	src="{$siteUrl}/core/templates/vendor/smart-scrolling/easing.js"></script>

<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop : $(this.hash).offset().top
				}, 1000);
			});

			return false;
		});
	</script>
<!-- //end-smoth-scrolling -->
<!-- start validazione di campi numerici che hanno class number -->
<script>	
	$('.number').on("keydown", function (e) {
    if (
        $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,  190]) !== -1 ||
        ($.inArray(e.keyCode, [65, 67, 88]) !== -1 && (e.ctrlKey === true || e.metaKey === true)) ||
        (e.keyCode >= 35 && e.keyCode <= 39)) 
        return;
    
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
        e.preventDefault();
    
});
</script>
<!-- // end validazione di campi numerici che hanno class number -->
{$mainMessages}{$mainWarnings}{$mainErrors}{$mainInfo}
</body>
</html>