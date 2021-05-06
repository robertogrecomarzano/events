<?php /* Smarty version Smarty-3.1.11, created on 2021-04-22 19:49:02
         compiled from "C:\wamp\www\events\core\templates\tpl\signup_preadvanced.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1203231646608038699be128-30462891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56acc99d08f90323af21b64617c6149a5896e81b' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\tpl\\signup_preadvanced.tpl',
      1 => 1619113717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1203231646608038699be128-30462891',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_60803869a6daa6_04728478',
  'variables' => 
  array (
    'nazioni' => 0,
    'sectors' => 0,
    'groups' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_60803869a6daa6_04728478')) {function content_60803869a6daa6_04728478($_smarty_tpl) {?><div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">First name</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_surname','size'=>25,'max'=>45,'tabindex'=>'1'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Last name</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_name','size'=>25,'max'=>45,'tabindex'=>'2'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Country</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'user_country','required'=>'','src'=>$_smarty_tpl->tpl_vars['nazioni']->value,'first'=>true,'class'=>"selectpicker",'data-live-search'=>"true",'tabindex'=>'3'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label
		class="control-label col-md-6 col-sm-6 col-xs-12 required">Email</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_email','size'=>30,'max'=>45,'tabindex'=>'4','type'=>'email','required'=>"email"),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Organization</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_organization','size'=>30,'max'=>45,'tabindex'=>'5'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Age<span class="help-block">Indicate a range</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>"user_age",'first'=>true,'src'=>array("0-18"=>"0-18","19-30"=>"19-30","31-50"=>"31-50","51-65"=>"51-65","66-80"=>"66-80","80+"=>"80+"),'tabindex'=>'6'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Gender</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'user_gender','first'=>true,'src'=>array('m'=>"Male",'f'=>"Female",'n'=>"Prefer not to say"),'inline'=>true,'tabindex'=>'7'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Sector</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'user_sector','first'=>true,'tabindex'=>'8','src'=>$_smarty_tpl->tpl_vars['sectors']->value),$_smarty_tpl);?>
</div>
</div>
<div class="form-group"  hidden id="div_user_sector_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_sector_other','size'=>30,'max'=>45,'tabindex'=>'5'),$_smarty_tpl);?>
</div>
</div>
<div class="form-group">
	<label class="control-label col-md-6 col-sm-6 col-xs-12 required">Stakeholder group</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'user_group','first'=>true,'tabindex'=>'9','src'=>$_smarty_tpl->tpl_vars['groups']->value),$_smarty_tpl);?>
</div>
</div>
<div class="form-group"  hidden id="div_user_group_other">
	<label class="control-label col-md-6 col-sm-6 col-xs-12">Please state</label>
	<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::textbox(array('iname'=>'user_group_other','size'=>30,'max'=>45,'tabindex'=>'5'),$_smarty_tpl);?>
</div>
</div><?php }} ?>