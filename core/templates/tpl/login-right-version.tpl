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

<!-- font awesome  -->
<link
	href="{$siteUrl}/core/templates/vendor/font-awesome-4.7.0/css/font-awesome.min.css"
	rel="stylesheet">

<link rel="stylesheet" href="{$siteUrl}/core/templates/css/login.css">

<!-- font google poppins -->
<link
	href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700'
	rel='stylesheet' type='text/css' />
<style>
body {
	overflow: hidden;
}

.faded-bg {
	background-image: url("../../../../../images/banner-2.jpg");
	background-repeat: no-repeat;
	background-size: cover;
}


#content-events {
	background-image: url({$siteUrl}/core/templates/img/watermark.png);
	background-repeat: no-repeat;
	height: 100vh;
	background-position: center;
	overflow:auto;
}
</style>
</head>

<div class="row">
	<div class="faded-bg animated"></div>
	<div class="col-sm-8 col-md-9" id="content-events">
	
	
		<div class="row col-md-12 col-lg-12 col-xs-12">
		{if $eventi|count > 0}
		<h1 class="text text-primary lead">UPCOMING EVENTS LIST</h1>
			{foreach from=$eventi item=r}


			<div class="event">
				<div class="img">
					<a class="text-primary" href="{$siteUrl}/p/event/{$r.nome}"target="_blank">
					{if !empty($r.logo)}
						<img alt="{$r.titolo}" class="img" src="{$siteUrl}/public/{$r.id_evento}/{$r.logo}" />
					{else}
						<img alt="{$r.titolo}" class="img" src="{$siteUrl}/core/templates/img/logo.png" />
					{/if}
					</a>
				</div>
				<div class="desc">
					<h5>{$r.titolo}</h5>
					<p class="text text-muted">{$r.descrizione}</p>
					<a class="text-primary" href="{$siteUrl}/p/event/{$r.nome}"
						target="_blank">{$siteUrl}/p/event/{$r.nome}</a>
				</div>
				<div class="date pull-right">
					<div class="day">{$r.data_day}</div>
					<div class="month">{$r.data_month}</div>
				</div>
			</div>
			{/foreach}
		{else}
			<h1 class="text text-danger lead">NO UPCOMING EVENTS</h1>
		{/if}
		</div>
	</div>
	<div
		class="hidden-xs col-xs-12 col-sm-4 col-md-3 login-sidebar animated fadeInRightBig">
		<div class="login-container animated fadeInRightBig">
			<div style="text-align:center;">
				<img class="img img-responsive hidden-xs animated fadeIn" style="display:inline;"
					src="{$siteUrl}/core/templates/img/logo.png" alt="{$title}" />
			</div>
			<div class="clearfix"></div>
			{form_opening}
			<div class="group">
				<input type="text" name="username" value="" required> <span
					class="highlight"></span> <span class="bar"></span> <label><i
					class="glyphicon glyphicon-user"></i><span class="span-input">
						Email</span></label>
			</div>

			<div class="group" style="margin-bottom: 10px;">
				<input type="password" name="password" required=""> <span
					class="highlight"></span> <span class="bar"></span> <label><i
					class="glyphicon glyphicon-lock"></i><span class="span-input">
						Password</span></label>
			</div>

			<button type="submit" class="btn btn-block login-button">
				<span class="signingin hidden"><span
					class="glyphicon glyphicon-refresh"></span> {form_lang
					value="LOADING"}</span> <span class="signin">{form_lang
					value="RESERVED_AREA"}</span>
			</button>

			{form_closing}
			<h3 class="lead text-success">{Config::$config["title"]}</h3>
			<p class="change_link">
				<a href="{$recoveryLink}"> {form_lang value="RECOVERY_ACCESS_DATA"}</a>
			</p>
		</div>
		<!-- .login-container -->

	</div>
	<!-- .login-sidebar -->
</div>
<!-- .row -->



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

{$css}{$js}{$mainMessages}{$mainWarnings}{$mainErrors}{$mainInfo}
</body>
</html>