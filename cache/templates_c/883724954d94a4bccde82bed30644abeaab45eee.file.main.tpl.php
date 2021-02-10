<?php /* Smarty version Smarty-3.1.11, created on 2021-02-10 16:14:14
         compiled from "C:\wamp\www\events\pages\user\templates\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5692832746023f846dde6c7-51366563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '883724954d94a4bccde82bed30644abeaab45eee' => 
    array (
      0 => 'C:\\wamp\\www\\events\\pages\\user\\templates\\main.tpl',
      1 => 1603885229,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5692832746023f846dde6c7-51366563',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modal' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6023f846ebbf98_10767641',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6023f846ebbf98_10767641')) {function content_6023f846ebbf98_10767641($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['modal']->value){?> <?php echo Form::hidden(array('iname'=>"modal",'value'=>$_smarty_tpl->tpl_vars['modal']->value),$_smarty_tpl);?>

<style>
.modal  a {
	color: #fcf8e3;
}

#myModal .modal-dialog .modal-content {
	background-color: #fcf8e3 !important;
}
</style>
<div id="myModal" class="modal fade" role="dialog" hidden>
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-center text-warning">Warning</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<p class='text text-warning'><?php echo Form::translate(array('value'=>'UPLOAD_YOUR_PHOTO'),$_smarty_tpl);?>
</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<?php }?> <?php echo Form::form_open(array('id'=>'userform'),$_smarty_tpl);?>

<div class="row">
	<div class="col-lg-4 col-md-4">
		<div class="panel-heading">
			<h3><?php echo Form::translate(array('value'=>"USER_DATA"),$_smarty_tpl);?>
</h3>
		</div>
		<div class="panel-body">
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-user'></i></span><?php ob_start();?><?php echo Form::translate(array('value'=>"SURNAME"),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'cognome','size'=>30,'max'=>45,'placeholder'=>$_tmp1,'required'=>''),$_smarty_tpl);?>

			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-user'></i></span><?php ob_start();?><?php echo Form::translate(array('value'=>"NAME"),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'nome','size'=>30,'max'=>45,'placeholder'=>$_tmp2,'required'=>''),$_smarty_tpl);?>

			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-at'></i></span><?php ob_start();?><?php echo Form::translate(array('value'=>"EMAIL_ADDRESS"),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'email','size'=>30,'max'=>45,'placeholder'=>$_tmp3,'type'=>'email','required'=>"email"),$_smarty_tpl);?>

			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-key'></i></span><?php ob_start();?><?php echo Form::translate(array('value'=>"NEW_PASSWORD"),$_smarty_tpl);?>
<?php $_tmp4=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'password','size'=>20,'max'=>45,'placeholder'=>$_tmp4,'type'=>'password','autocomplete'=>"new-password"),$_smarty_tpl);?>

			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-key'></i></span><?php ob_start();?><?php echo Form::translate(array('value'=>"PASSWORD_CONFIRM"),$_smarty_tpl);?>
<?php $_tmp5=ob_get_clean();?><?php echo Form::textbox(array('iname'=>'password2','size'=>20,'max'=>45,'placeholder'=>$_tmp5,'type'=>'password'),$_smarty_tpl);?>

			</div>
			<label class='text text-info'><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT"),$_smarty_tpl);?>
</label>
			<ul>
				<li class='text text-info'><small><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT_ONE_NUMBER"),$_smarty_tpl);?>
</small></li>
				<li class='text text-info'><small><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT_ONE_CHAR_LOWER"),$_smarty_tpl);?>
</small></li>
				<li class='text text-info'><small><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT_ONE_CHAR_UPPER"),$_smarty_tpl);?>
</small></li>
				<li class='text text-info'><small><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT_ONE_CHAR_BETWEEN"),$_smarty_tpl);?>
</small></li>
				<li class='text text-info'><small><?php echo Form::translate(array('value'=>"PASSWORD_FORMAT_ONE_CHAR_LENGTH"),$_smarty_tpl);?>
</small></li>
			</ul>
		</div>
	</div>

</div>
<div class="btn btn-group"><?php ob_start();?><?php echo Form::translate(array('value'=>'CONFIRM'),$_smarty_tpl);?>
<?php $_tmp6=ob_get_clean();?><?php echo Form::button(array('name'=>"signup",'img'=>'save','text'=>true,'value'=>$_tmp6,'onclick'=>'return	Check(this);','class'=>'btn btn-primary'),$_smarty_tpl);?>
</div>
<?php echo Form::form_close(array(),$_smarty_tpl);?>

<?php }} ?>