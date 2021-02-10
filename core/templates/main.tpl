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

<!-- Bootstrap-select Core CSS -->
<link
	href="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/css/bootstrap-select.min.css"
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

<!-- font poppins  -->
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

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery -->


<!-- simplebar  -->
<link href="{$siteUrl}/core/templates/vendor/simplebar/simplebar.css"
	rel="stylesheet">
<script src="{$siteUrl}/core/templates/vendor/simplebar/simplebar.js"></script>

</head>

<body>
	<div id='listposts'></div>
	<button onclick="topFunction()" id="myBtn" title="Torna su">
		<i class='fa fa-chevron-up'></i>
	</button>

	<!-- Modal -->
	<div class="modal fade" id="myCustomModal" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" id='myCustomModalContent'>
				<div class="modal-header">
					<h2 class="modal-title" id="myCustomModalTitle"></h2>
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id='myCustomModalBody'></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">{form_lang value='CLOSE'}</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /.modal -->

	<div class="wrapper">

		<!-- Navigation -->
		<nav id="sidebar">
			<div class="sidebar-header">
				<div class="profile clearfix text-center">
				{if !empty($logo)}
					<div>
						<a href='{$siteUrl}'> <img alt="{Config::$config["
							sitename"]}" class="img img-responsive img-thumbnail"
							src="{$siteUrl}/core/templates/img/{$logo}.png" />
						</a>
					</div>
					{/if}
				</div>
				<div class="profile_infos">
						{if !empty($userNominativo)} <h5>{form_lang value='WELCOME'}</h4>
						<h5>{$userNominativo}</h5>
						{/if}

					</div>
				</div>
			<div class="clearfix"></div>
			<ul class='list-unstyled' id='main'>{$left}
			</ul>

		</nav>

		<div id="content">
			<div class="container-fluid">

				<nav class="navbar navbar-default">

					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->


						<div class="navbar-header">
							<button type="button" id="sidebarCollapse"
								class="navbar-brand navbar-btn">
								<span></span> <span></span> <span></span>
							</button>
							<span class="navbar-brand lead">{$contentSubTitle}</span>
							
							<button type="button" class="navbar-toggle collapsed"
								data-toggle="collapse"
								data-target="#bs-example-navbar-collapse-1"
								aria-expanded="false">
								<span class="sr-only">Toggle navigation</span> <span
									class="icon-bar"></span> <span class="icon-bar"></span> <span
									class="icon-bar"></span>
							</button>

						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse"
							id="bs-example-navbar-collapse-1">

							<div class="nav navbar-nav navbar-right">
								<ul class="nav navbar-top-links navbar-right">
									<li>{if
										!empty($userSimulationSuper)}{$userSimulationSuper}{/if}</li>
									{if $welcome != ""}{$userSimulationProfilo}
									{$userSimulationEnte}
									<!-- /.dropdown -->

									{$plgHelpMini}
									<li class="dropdown"><a class="dropdown-toggle"
										data-toggle="dropdown" href="#" id='profile'
										title='{$userNominativo}'>

											<div class="avatar-circle">
												<span class="initials">{$userNominativo|substr:0:1|upper}</span>
											</div>
									</a>{$tecnico}
										<ul class="dropdown-menu dropdown-user">
											<li><a href="{$siteUrl}/p/user">{$userNominativo}</a></li>
											<li class="divider"></li>
											<li><a href="{$siteUrl}/p/user"><i class="fas fa-user fa-2x"></i>
													{form_lang value='PROFILE'}</a></li>
											<li><a href="{$logout}" id='logout'><i class="fas fa-sign-out-alt fa-2x"></i>
													{form_lang value='LOGOUT'} </a></li>
											<li>{if !empty($tecnico)}
												<form method="post">{$formToken}{$tecnico}</form>{/if}
											</li>
										</ul> <!-- /.dropdown-user --></li>
									<!-- /.dropdown -->
									{else}

									<li><a id='accedi' href="{$siteUrl}/p/login"><i
											class="fas fa-user fa-2x"></i> {form_lang value='LOGIN'}</a></li>
									</li>

									<!-- /.navbar-top-links -->

									{/if}
								</ul>
							</div>
						</div>
						<!-- /.navbar-collapse -->
					</div>
					<!-- /.container-fluid -->
				</nav>



			</div>



			<div id='helpdiv' class='helpdiv'>{$plgHelpDiv}</div>

			<!-- /.col-lg-12 -->


			<div class="container-fluid">
				{$newspic}

				<div class="row">
					<div class="col-lg-12">
						<div class="clearfix"></div>
						{form_wizard}
						{include file="$mainContent"}
					</div>
					<!-- /.col-lg-12 -->

				</div>

			</div>
		</div>

	</div>

	<!-- JQuery -->
	<script
		src="{$siteUrl}/core/templates/vendor/jquery/jquery-3.3.1.min.js"></script>


	<!-- Bootstrap Core JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Bootstrap-Select Core JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/js/bootstrap-select.min.js"></script>
<!-- Bootstrap-Select translate -->
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap-select-1.13.7/js/i18n/defaults-{Config::$defaultLocale}.min.js"></script>

	<!-- Bootbox dialog boxes JavaScript -->
	<script src="{$siteUrl}/core/templates/vendor/bootbox/bootbox.min.js"></script>

	<!-- Bootstrap Notify -->
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap-notify-master/bootstrap-notify.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script
		src="{$siteUrl}/core/templates/vendor/metisMenu/metisMenu.min.js"></script>

	<!-- DataTables -->
	<script
		src="{$siteUrl}/core/templates/vendor/datatables/jquery.dataTables.min.js"></script>

	<link rel="stylesheet" type="text/css"
		href="{$siteUrl}/core/templates/vendor/datatables/datatables.min.css" />

	<script type="text/javascript"
		src="{$siteUrl}/core/templates/vendor/datatables/datatables.min.js"></script>

	<!-- pdf make -->
	<script type="text/javascript"
		src="{$siteUrl}/core/templates/vendor/pdfmake/pdfmake.min.js"></script>
	<script type="text/javascript"
		src="{$siteUrl}/core/templates/vendor/pdfmake/vfs_fonts.js"></script>




	<!-- Custom Theme JavaScript -->
	<script src="{$siteUrl}/core/templates/js/template-script.js"></script>

	<!-- Main Language JavaScript -->
	<script src="{$siteUrl}/core/templates/js/language.js"></script>


	<!-- Main JavaScript -->
	<script src="{$siteUrl}/core/templates/js/main.js"></script>


	<!-- Summernote, usato per l'editing html -->
	<link href="{$siteUrl}/core/templates/vendor/summernote/summernote.css"
		rel="stylesheet">
	<script
		src="{$siteUrl}/core/templates/vendor/summernote/summernote.min.js"></script>
	<!-- include summernote-ko-KR -->
	<script
		src="{$siteUrl}/core/templates/vendor/summernote/lang/summernote-it-IT.js"></script>
	<script
		src="{$siteUrl}/core/templates/vendor/summernote/summernote-cleaner.js"></script>
		
	{$css}{$js}

	<!-- bootstrap Toggle to convert checkboxes into toggles -->
	<link
		href="{$siteUrl}/core/templates/vendor/bootstrap-toggle/bootstrap-toggle.min.css"
		rel="stylesheet">
	<script
		src="{$siteUrl}/core/templates/vendor/bootstrap-toggle/bootstrap-toggle.min.js"></script>


	<div id='loading' onclick="$(this).hide();" class="modal fade in"
		tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
		data-backdrop="static" data-keyboard="false"
		style="padding-right: 17px;" aria-hidden="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{form_lang value='LOADING'}</h4>
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
	<script type="text/javascript">
		$(document).ready(function() {

			$(document).ready(function() {
				$('#sidebarCollapse').on('click', function() {
					$('#sidebar').toggleClass('active');
					$(this).toggleClass('active');
				});
			});

			$( "#sidebar ul.list-unstyled:has( > li.active:last):last").css({ backgroundColor: "#2c3b41"});

			/*
			$("#sidebar li>a").each(function() {
				var that = $(this);
				var p = that.parentsUntil("ul#main").filter("li").length;
				that.css("padding-left", p * 5);
			});*/

		})
		<!-- start validazione di campi numerici che hanno class number -->
		.on('keydown', '.number', function(e) {
			if (
		        $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,  190]) !== -1 ||
		        ($.inArray(e.keyCode, [65, 67, 88]) !== -1 && (e.ctrlKey === true || e.metaKey === true)) ||
		        (e.keyCode >= 35 && e.keyCode <= 39)) 
		        return;
		    
		    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
		        e.preventDefault();
		});
		<!-- end validazione di campi numerici che hanno class number -->
	</script>
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
	{$mainMessages}{$mainWarnings}{$mainErrors}{$mainInfo}
	<!-- // start disable backbutton -->
	<script>
	/*function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };*/
	</script>
	<!-- // end disable backbutton -->
{if Config::$config["debug"] == 1}
	<div class="clearfix debug-footer">DEBUG</div>
	{/if} {if Config::$config["collaudo"] == 1}
	<div class="clearfix debug-footer">COLLAUDO</div>
{/if}
</body>
</html>

