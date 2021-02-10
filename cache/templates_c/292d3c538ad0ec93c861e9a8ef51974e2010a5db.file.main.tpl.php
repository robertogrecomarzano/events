<?php /* Smarty version Smarty-3.1.11, created on 2021-02-10 16:14:19
         compiled from "C:\wamp\www\events\pages\admin\iscritti\templates\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19131086586023f84b317222-58973796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '292d3c538ad0ec93c861e9a8ef51974e2010a5db' => 
    array (
      0 => 'C:\\wamp\\www\\events\\pages\\admin\\iscritti\\templates\\main.tpl',
      1 => 1606483279,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19131086586023f84b317222-58973796',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'eventi' => 0,
    'filename' => 0,
    'siteUrl' => 0,
    'src' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6023f84b3db309_50280434',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6023f84b3db309_50280434')) {function content_6023f84b3db309_50280434($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['action']->value!="mod"&&$_smarty_tpl->tpl_vars['action']->value!="add"){?>
<?php echo Form::form_open(array('class'=>"form-horizontal"),$_smarty_tpl);?>

	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Evento<span class="help-block">seleziona l'evento per cui vuoi esportare gli iscritti</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::select(array('iname'=>'evento','src'=>$_smarty_tpl->tpl_vars['eventi']->value,'first'=>true),$_smarty_tpl);?>
</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php echo Form::button(array('text'=>true,'value'=>'Esporta excel','img'=>'file-excel','onclick'=>"form_esporta(this);",'read-allowed'=>true),$_smarty_tpl);?>

			<?php echo Form::button(array('text'=>true,'value'=>'Elimina iscritti evento','img'=>'trash','onclick'=>"form_delete(this);",'class'=>"btn btn-danger"),$_smarty_tpl);?>

		</div>
	</div>
	
	<?php if (!empty($_smarty_tpl->tpl_vars['filename']->value)){?>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
			<div class="col-md-6 col-sm-6 col-xs-12"><?php echo Form::link(array('img'=>"download",'text'=>true,'class'=>"btn btn-primary",'value'=>"Clicca qui per avviare il download del file",'target'=>'_blank','href'=>((string)$_smarty_tpl->tpl_vars['siteUrl']->value)."/core/download.php?t=x&file=".((string)$_smarty_tpl->tpl_vars['filename']->value),'read-allowed'=>true),$_smarty_tpl);?>
</div>
		</div>
		
	<?php }?>
<?php echo Form::form_close(array(),$_smarty_tpl);?>

<?php }?>
<?php echo Form::form_table(array('src'=>$_smarty_tpl->tpl_vars['src']->value),$_smarty_tpl);?>
<?php }} ?>