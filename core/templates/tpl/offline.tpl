<!DOCTYPE html>
<html lang="{Config::$defaultLocale|substr:0:2}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description"
	content="Biobank Open Project, è stato realizzato con lo scopo di consentire la gestione on line delle notifiche di attività con metodo biologico, dei programmi annuali di produzione (Pap), delle varie comunicazioni e documentazione relativa all'agricoltura biologica.">
<meta name="author" content="Regione {Config::$config["denominazione"]}">

<title>{$title}</title>

<!-- Bootstrap Core CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">


<!-- MetisMenu CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/metisMenu/metisMenu.min.css"
	rel="stylesheet">

<!-- Bootstrap Social CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/bootstrap-social/bootstrap-social.css"
	rel="stylesheet">

<!-- DataTables CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/datatables-plugins/dataTables.bootstrap.css"
	rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/datatables-responsive/dataTables.responsive.css"
	rel="stylesheet">

<!-- Custom CSS -->
<link href="{$siteUrl}/core/templates/css/common.css"
	rel="stylesheet">

<!-- Custom Fonts -->
<link
	href="{$siteUrl}/core/templates/vendor/font-awesome-4.7/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">

					<div id='errorbox'>{$mainMessages}{$mainWarnings}{$mainErrors}</div>
					<div class="panel-body text-center">
						<img alt="{Config::$config["sitename"]}" class="img-thumbnail"
							src="{$siteUrl}/core/templates/img/{$logo}.png" />
						<div class="panel-body text-center">
							<strong>{$title}</strong>
							<p>
								<span class="text text-muted">{form_lang value="OFFLINE"}</span>
							</p>
							<form method="post" name="first" class="form-signin">
								{$formToken}
								<fieldset>
									<p id="profile-name" class="profile-name-card"></p>
									<div class="form-group">
										<input type="text" id="username" name="username"
											class="form-control" placeholder="Username" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password"
											class="form-control" placeholder="Password" required>
									</div>
									<div class="form-group">
										<button class="btn btn-lg btn-primary btn-block btn-signin"
											type="submit">{forn_lang value="LOGIN"}</button>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="{$siteUrl}/core/templates/vendor/jquery/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/metisMenu/metisMenu.min.js"></script>

	<!-- DataTables JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/datatables/js/jquery.dataTables.js"></script>
	<script
		src="{$siteUrl}/core/templates/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
	<script
		src="{$siteUrl}/core/templates/vendor/datatables-responsive/dataTables.responsive.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="{$siteUrl}/core/templates/js/template-script.js"></script>

	<!-- Main JavaScript -->
	<script src="{$siteUrl}/core/templates/js/main.js"></script>

	{$css}{$js}
</body>
</html>