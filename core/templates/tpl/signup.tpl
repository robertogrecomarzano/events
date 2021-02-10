<!DOCTYPE html>
<html lang="{Config::$defaultLocale|substr:0:2}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{$evento->titolo}</title>
<!-- Bootstrap Core CSS -->
<link href="{$siteUrl}/core/templates/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap-select Core CSS -->
<link href="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/css/bootstrap-select.min.css"	rel="stylesheet">
<!-- Common CSS -->
<link href="{$siteUrl}/core/templates/css/common.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="{$siteUrl}/core/templates/css/style.css" rel="stylesheet">
<!-- font awesome  -->
<link href="{$siteUrl}/core/templates/vendor/font-poppins/font-poppins.css"	rel="stylesheet">
<link href="{$siteUrl}/core/templates/vendor/font-awesome-free-5.6.3/css/all.css" rel="stylesheet">
<link href="{$siteUrl}/core/templates/vendor/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery -->
<style>
form {
	border: 1px solid gray;
	padding: 20px !important;
	box-shadow: 0px 0px 10px 0px #888;
}
</style>
</head>
<div class="row">
	<div class="col-sm-12 col-md-12" style="margin-top:10px;">
		<div class="clearfix">
			<div class="col-sm-12 col-md-12">
				<div class="logo-title-container logo-title-container">
					{form_opening class="col-lg-8 col-md-offset-2" enctype="multipart/form-data"}
						<div class="row">
						<div class="col-lg-8 col-xs-12">
						{if !empty($evento->logo) && $evento->show_logo}
							<img class="img" src="{$evento->logo}" style="max-height:120px"/>
						{/if}
						</div>
						<div class="col-lg-4 col-xs-12">
						{if $evento->show_logo_ciheam}
							<img class="img pull-right" src="{$siteUrl}/core/templates/img/{$logo}.png" height="120px" />
						{/if}
						</div>
						</div>
						<div class="clearfix row form-horizontal">
							<h2 class="text text-center text-primary lead" style="margin-bottom:5px;">{$evento->titolo}</h2>
							<div class="text-center" style="font-size:16px; margin-bottom:10px;">{$evento->descrizione}</div>
							{if $evento->template!="call"}<h3 class="text-center">{$evento->data_extended} {$evento->ora_inizio} - {$evento->ora_fine}</h3>{/if}
							<div class="text-center" style="margin-bottom:10px;">
								{if !empty($evento->email)}<label class="block"><i class="fas fa-envelope text-info">&nbsp;</i><a href="mailto:{$email}">{$evento->email}</a></label>{/if}
								{if !empty($evento->website)}<label class="block"><i class="fas fa-globe text-info">&nbsp;</i><a target="_blank" href="{$evento->website}">{$evento->website}</a></label> {/if}
							</div>
							{include file="./signup_$signupContent.tpl"}
							<div class="form-group">
								<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Captcha code</label>
								<div class="col-md-6 col-sm-6 col-xs-12">{$captcha}</div>
							</div>
							<div class="form-group">
								<div>{$evento->checkPresaVisione}{$evento->checkRegistrazione}</div>
							</div>
							<div class="clearfix"></div>
							<div class="text-center">
					 			{form_button name="signup" img="save" text=true value="CONFIRM REGISTRATION" onclick='return form_signup_check(this);' class='btn btn-success btn-block'}
							</div>
						</div>
					{form_closing}
				</div>
			</div>
		</div>
	</div>
</div>


<!-- JQuery -->
<script	src="{$siteUrl}/core/templates/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script	src="{$siteUrl}/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Bootstrap-Select Core JavaScript -->
<script	src="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/js/bootstrap-select.min.js"></script>
<!-- Bootstrap-Select translate -->
<script	src="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/js/i18n/defaults-{Config::$defaultLocale}.min.js"></script>
<!-- Bootbox dialog boxes JavaScript -->
<script src="{$siteUrl}/core/templates/vendor/bootbox/bootbox.min.js"></script>
<!-- Bootstrap Notify -->
<script	src="{$siteUrl}/core/templates/vendor/bootstrap-notify-master/bootstrap-notify.min.js"></script>
<!-- DataTables -->
<script	src="{$siteUrl}/core/templates/vendor/datatables/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"	href="{$siteUrl}/core/templates/vendor/datatables/datatables.min.css" />
<script type="text/javascript"	src="{$siteUrl}/core/templates/vendor/datatables/datatables.min.js"></script>
<!-- Main Language JavaScript -->
<script src="{$siteUrl}/core/templates/js/language.js"></script>
<!-- Main JavaScript -->
<script src="{$siteUrl}/core/templates/js/main.js"></script>
{$css}{$js}{$mainMessages}{$mainWarnings}{$mainErrors}{$mainInfo}
</body>
</html>