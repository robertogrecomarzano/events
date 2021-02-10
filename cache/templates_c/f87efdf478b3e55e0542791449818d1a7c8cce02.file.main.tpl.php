<?php /* Smarty version Smarty-3.1.11, created on 2021-02-10 16:14:14
         compiled from "C:\wamp\www\events\core\templates\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6218576106023f846ac92b2-86996842%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f87efdf478b3e55e0542791449818d1a7c8cce02' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\main.tpl',
      1 => 1606233926,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6218576106023f846ac92b2-86996842',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'siteUrl' => 0,
    'logo' => 0,
    'userNominativo' => 0,
    'left' => 0,
    'contentSubTitle' => 0,
    'userSimulationSuper' => 0,
    'welcome' => 0,
    'userSimulationProfilo' => 0,
    'userSimulationEnte' => 0,
    'plgHelpMini' => 0,
    'tecnico' => 0,
    'logout' => 0,
    'formToken' => 0,
    'plgHelpDiv' => 0,
    'newspic' => 0,
    'css' => 0,
    'js' => 0,
    'mainMessages' => 0,
    'mainWarnings' => 0,
    'mainErrors' => 0,
    'mainInfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6023f846dc8432_93107328',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6023f846dc8432_93107328')) {function content_6023f846dc8432_93107328($_smarty_tpl) {?><!DOCTYPE html>
<html lang="<?php echo substr(Config::$defaultLocale,0,2);?>
">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

<!-- Bootstrap Core CSS -->
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">

<!-- Bootstrap-select Core CSS -->
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-select-1.13.7/css/bootstrap-select.min.css"
	rel="stylesheet">


<!-- MetisMenu CSS -->
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/metisMenu/metisMenu.min.css"
	rel="stylesheet">

<!-- Common CSS -->
<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/css/common.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/css/style.css" rel="stylesheet">

<!-- Sidebar CSS -->
<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/css/sidebar.css" rel="stylesheet">

<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/css/custom.css" rel="stylesheet">

<!-- font poppins  -->
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/font-poppins/font-poppins.css"
	rel="stylesheet">

<!-- font awesome  -->
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/font-awesome-free-5.6.3/css/all.css"
	rel="stylesheet">
<link
	href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/font-awesome-4.7.0/css/font-awesome.min.css"
	rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery -->


<!-- simplebar  -->
<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/simplebar/simplebar.css"
	rel="stylesheet">
<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/simplebar/simplebar.js"></script>

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
						data-dismiss="modal"><?php echo Form::translate(array('value'=>'CLOSE'),$_smarty_tpl);?>
</button>
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
				<?php if (!empty($_smarty_tpl->tpl_vars['logo']->value)){?>
					<div>
						<a href='<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
'> <img alt="<?php echo Config::$config["
							sitename"];?>
" class="img img-responsive img-thumbnail"
							src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/img/<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
.png" />
						</a>
					</div>
					<?php }?>
				</div>
				<div class="profile_infos">
						<?php if (!empty($_smarty_tpl->tpl_vars['userNominativo']->value)){?> <h5><?php echo Form::translate(array('value'=>'WELCOME'),$_smarty_tpl);?>
</h4>
						<h5><?php echo $_smarty_tpl->tpl_vars['userNominativo']->value;?>
</h5>
						<?php }?>

					</div>
				</div>
			<div class="clearfix"></div>
			<ul class='list-unstyled' id='main'><?php echo $_smarty_tpl->tpl_vars['left']->value;?>

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
							<span class="navbar-brand lead"><?php echo $_smarty_tpl->tpl_vars['contentSubTitle']->value;?>
</span>
							
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
									<li><?php if (!empty($_smarty_tpl->tpl_vars['userSimulationSuper']->value)){?><?php echo $_smarty_tpl->tpl_vars['userSimulationSuper']->value;?>
<?php }?></li>
									<?php if ($_smarty_tpl->tpl_vars['welcome']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['userSimulationProfilo']->value;?>

									<?php echo $_smarty_tpl->tpl_vars['userSimulationEnte']->value;?>

									<!-- /.dropdown -->

									<?php echo $_smarty_tpl->tpl_vars['plgHelpMini']->value;?>

									<li class="dropdown"><a class="dropdown-toggle"
										data-toggle="dropdown" href="#" id='profile'
										title='<?php echo $_smarty_tpl->tpl_vars['userNominativo']->value;?>
'>

											<div class="avatar-circle">
												<span class="initials"><?php echo mb_strtoupper(substr($_smarty_tpl->tpl_vars['userNominativo']->value,0,1), 'UTF-8');?>
</span>
											</div>
									</a><?php echo $_smarty_tpl->tpl_vars['tecnico']->value;?>

										<ul class="dropdown-menu dropdown-user">
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/p/user"><?php echo $_smarty_tpl->tpl_vars['userNominativo']->value;?>
</a></li>
											<li class="divider"></li>
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/p/user"><i class="fas fa-user fa-2x"></i>
													<?php echo Form::translate(array('value'=>'PROFILE'),$_smarty_tpl);?>
</a></li>
											<li><a href="<?php echo $_smarty_tpl->tpl_vars['logout']->value;?>
" id='logout'><i class="fas fa-sign-out-alt fa-2x"></i>
													<?php echo Form::translate(array('value'=>'LOGOUT'),$_smarty_tpl);?>
 </a></li>
											<li><?php if (!empty($_smarty_tpl->tpl_vars['tecnico']->value)){?>
												<form method="post"><?php echo $_smarty_tpl->tpl_vars['formToken']->value;?>
<?php echo $_smarty_tpl->tpl_vars['tecnico']->value;?>
</form><?php }?>
											</li>
										</ul> <!-- /.dropdown-user --></li>
									<!-- /.dropdown -->
									<?php }else{ ?>

									<li><a id='accedi' href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/p/login"><i
											class="fas fa-user fa-2x"></i> <?php echo Form::translate(array('value'=>'LOGIN'),$_smarty_tpl);?>
</a></li>
									</li>

									<!-- /.navbar-top-links -->

									<?php }?>
								</ul>
							</div>
						</div>
						<!-- /.navbar-collapse -->
					</div>
					<!-- /.container-fluid -->
				</nav>



			</div>



			<div id='helpdiv' class='helpdiv'><?php echo $_smarty_tpl->tpl_vars['plgHelpDiv']->value;?>
</div>

			<!-- /.col-lg-12 -->


			<div class="container-fluid">
				<?php echo $_smarty_tpl->tpl_vars['newspic']->value;?>


				<div class="row">
					<div class="col-lg-12">
						<div class="clearfix"></div>
						<?php echo Form::wizard(array(),$_smarty_tpl);?>

						<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['mainContent']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

					</div>
					<!-- /.col-lg-12 -->

				</div>

			</div>
		</div>

	</div>

	<!-- JQuery -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/jquery/jquery-3.3.1.min.js"></script>


	<!-- Bootstrap Core JavaScript -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Bootstrap-Select Core JavaScript -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-select-1.13.7/js/bootstrap-select.min.js"></script>
<!-- Bootstrap-Select translate -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-select-1.13.7/js/i18n/defaults-<?php echo Config::$defaultLocale;?>
.min.js"></script>

	<!-- Bootbox dialog boxes JavaScript -->
	<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootbox/bootbox.min.js"></script>

	<!-- Bootstrap Notify -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-notify-master/bootstrap-notify.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/metisMenu/metisMenu.min.js"></script>

	<!-- DataTables -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/datatables/jquery.dataTables.min.js"></script>

	<link rel="stylesheet" type="text/css"
		href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/datatables/datatables.min.css" />

	<script type="text/javascript"
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/datatables/datatables.min.js"></script>

	<!-- pdf make -->
	<script type="text/javascript"
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/pdfmake/pdfmake.min.js"></script>
	<script type="text/javascript"
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/pdfmake/vfs_fonts.js"></script>




	<!-- Custom Theme JavaScript -->
	<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/template-script.js"></script>

	<!-- Main Language JavaScript -->
	<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/language.js"></script>


	<!-- Main JavaScript -->
	<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/main.js"></script>


	<!-- Summernote, usato per l'editing html -->
	<link href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/summernote/summernote.css"
		rel="stylesheet">
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/summernote/summernote.min.js"></script>
	<!-- include summernote-ko-KR -->
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/summernote/lang/summernote-it-IT.js"></script>
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/summernote/summernote-cleaner.js"></script>
		
	<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
<?php echo $_smarty_tpl->tpl_vars['js']->value;?>


	<!-- bootstrap Toggle to convert checkboxes into toggles -->
	<link
		href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-toggle/bootstrap-toggle.min.css"
		rel="stylesheet">
	<script
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap-toggle/bootstrap-toggle.min.js"></script>


	<div id='loading' onclick="$(this).hide();" class="modal fade in"
		tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
		data-backdrop="static" data-keyboard="false"
		style="padding-right: 17px;" aria-hidden="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?php echo Form::translate(array('value'=>'LOADING'),$_smarty_tpl);?>
</h4>
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
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/smart-scrolling/move-top.js"></script>
	<script type="text/javascript"
		src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/smart-scrolling/easing.js"></script>
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
	<?php echo $_smarty_tpl->tpl_vars['mainMessages']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainWarnings']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainErrors']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainInfo']->value;?>

	<!-- // start disable backbutton -->
	<script>
	/*function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };*/
	</script>
	<!-- // end disable backbutton -->
<?php if (Config::$config["debug"]==1){?>
	<div class="clearfix debug-footer">DEBUG</div>
	<?php }?> <?php if (Config::$config["collaudo"]==1){?>
	<div class="clearfix debug-footer">COLLAUDO</div>
<?php }?>
</body>
</html>

<?php }} ?>