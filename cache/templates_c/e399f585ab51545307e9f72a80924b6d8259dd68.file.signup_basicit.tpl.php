<?php /* Smarty version Smarty-3.1.11, created on 2021-04-21 16:27:18
         compiled from "C:\wamp\www\events\core\templates\tpl\signup_basicit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:71999945260803646d85e98-95951213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e399f585ab51545307e9f72a80924b6d8259dd68' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\tpl\\signup_basicit.tpl',
      1 => 1605800866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71999945260803646d85e98-95951213',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_60803646e24987_53734970',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_60803646e24987_53734970')) {function content_60803646e24987_53734970($_smarty_tpl) {?><div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Cognome</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_surname','size'=>30,'max'=>45,'tabindex'=>'1','required'=>''),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Nome</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_name','size'=>30,'max'=>45,'tabindex'=>'2','required'=>''),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_email','size'=>30,'max'=>45,'tabindex'=>'3','type'=>'email','required'=>"email"),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Categoria</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'user_group','first'=>true,'tabindex'=>'4','src'=>array("ente_pubblico"=>"Ente pubblico","universita"=>"Università / ente di ricerca","impresa"=>"Impresa","other"=>"Altro")),$_smarty_tpl);?>
</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Specificare</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_group_other','size'=>30,'max'=>45,'tabindex'=>'5'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Ente di appartenenza</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_business_name','size'=>30,'max'=>45,'tabindex'=>'6','required'=>''),$_smarty_tpl);?>
</div>
</div><?php }} ?>