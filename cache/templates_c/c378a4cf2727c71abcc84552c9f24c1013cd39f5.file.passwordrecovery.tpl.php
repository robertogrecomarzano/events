<?php /* Smarty version Smarty-3.1.11, created on 2021-04-21 17:10:11
         compiled from "C:\wamp\www\events\core\templates\tpl\passwordrecovery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1606396139608040535df936-08941176%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c378a4cf2727c71abcc84552c9f24c1013cd39f5' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\tpl\\passwordrecovery.tpl',
      1 => 1569333468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1606396139608040535df936-08941176',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'siteUrl' => 0,
    'recovery' => 0,
    'formToken' => 0,
    'captcha' => 0,
    'css' => 0,
    'js' => 0,
    'mainMessages' => 0,
    'mainWarnings' => 0,
    'mainErrors' => 0,
    'mainInfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_60804053705ab1_28826836',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_60804053705ab1_28826836')) {function content_60804053705ab1_28826836($_smarty_tpl) {?><!DOCTYPE html>
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

<!-- font awesome  -->
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

</head>

<div class="row">
	<div class="faded-bg animated"></div>
	<div class="col-sm-12 col-md-12">
		<div class="clearfix">
			<div class="col-sm-12 col-md-12">
				<div class="logo-title-container logo-title-container">
					<?php if ($_smarty_tpl->tpl_vars['recovery']->value!=true){?>
					<form method="post" role='form' class="col-lg-6 col-md-offset-3">
						<?php echo $_smarty_tpl->tpl_vars['formToken']->value;?>
 <?php echo Form::hidden(array('iname'=>'form_action'),$_smarty_tpl);?>

						<h1><?php echo Form::translate(array('value'=>'PASSWORD_RECOVERY_TITLE'),$_smarty_tpl);?>
</h1>
						<div class="panel">
							<blockquote><?php echo Form::translate(array('value'=>'PASSWORD_RECOVERY_HEADER_TEXT'),$_smarty_tpl);?>
</blockquote>
						</div>
						<div class="form-group input-group">
							<span class="input-group-addon">@</span><?php ob_start();?><?php echo Form::translate(array('value'=>'EMAIL'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo Form::translate(array('value'=>'EMAIL_REQUIRED'),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'email','size'=>30,'max'=>45,'tabindex'=>'11','placeholder'=>$_tmp1,'type'=>'email','required'=>"email",'oninvalid'=>"this.setCustomValidity('".$_tmp2."')"),$_smarty_tpl);?>

						</div>
						<div class="form-group"><?php echo $_smarty_tpl->tpl_vars['captcha']->value;?>
</div>
						<div class='btn-group'>
							<input type='button' value="<?php echo Form::translate(array('value'=>'RECOVERY'),$_smarty_tpl);?>
"
								onclick='recovery(this);' class="btn btn-primary" />
						</div>
					</form>
					<?php }else{ ?>
						<div class="col-lg-6 col-md-offset-3">
							<h1><?php echo Form::translate(array('value'=>'PASSWORD_RECOVERY_TITLE'),$_smarty_tpl);?>
</h1>
							<p class="lead">
								<a href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
" class="btn btn-lg btn-default">Home</a>
							</p>
						</div>
					<?php }?>
				</div>
				<!-- .logo-title-container -->

			</div>

		</div>

	</div>


</div>
<!-- .row -->
</div>
<!-- .container-fluid -->

<!-- JQuery -->
<script
	src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/jquery/jquery-3.3.1.min.js"></script>


<!-- Bootstrap Core JavaScript -->
<script
	src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/vendor/bootstrap/js/bootstrap.min.js"></script>



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

<!-- Custom Theme JavaScript -->
<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/template-script.js"></script>

<!-- Main Language JavaScript -->
<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/language.js"></script>


<!-- Main JavaScript -->
<script src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/js/main.js"></script>

<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
<?php echo $_smarty_tpl->tpl_vars['js']->value;?>



<div id='loading' onclick="$(this).hide();" class="modal fade in"
	tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
	data-backdrop="static" data-keyboard="false"
	style="padding-right: 17px;" aria-hidden="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo Form::translate(array('value'=>"LOADING"),$_smarty_tpl);?>
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
<?php echo $_smarty_tpl->tpl_vars['mainMessages']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainWarnings']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainErrors']->value;?>
<?php echo $_smarty_tpl->tpl_vars['mainInfo']->value;?>

</body>
</html><?php }} ?>