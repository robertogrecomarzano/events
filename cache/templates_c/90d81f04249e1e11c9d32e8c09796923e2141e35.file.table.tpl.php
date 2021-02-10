<?php /* Smarty version Smarty-3.1.11, created on 2021-02-10 16:14:17
         compiled from "C:\wamp\www\events\pages\admin\eventi\templates\table.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9804854726023f849603300-59689804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90d81f04249e1e11c9d32e8c09796923e2141e35' => 
    array (
      0 => 'C:\\wamp\\www\\events\\pages\\admin\\eventi\\templates\\table.tpl',
      1 => 1605285035,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9804854726023f849603300-59689804',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'src' => 0,
    'pk' => 0,
    'row' => 0,
    'siteUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6023f84974f052_48666002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6023f84974f052_48666002')) {function content_6023f84974f052_48666002($_smarty_tpl) {?><!-- Questo file è da usare solo se si vuole attivare la modalita custom-template -->
<table
	class="table table-hover dataTable no-footer dtr-inline">
	<thead>
		<th></th>
		<th>Evento</th>
		<th>Modello</th>
		<th>Data e ora</th>
		<th>Dati di accesso Zoom</th>
		<th>Logo</th>
		<th>Privacy</th>
	</thead>
	<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['src']->value['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
	<tr>
		<td><?php echo Form::edit(array('id'=>$_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['pk']->value]),$_smarty_tpl);?>
<?php echo Form::delete(array('id'=>$_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['pk']->value]),$_smarty_tpl);?>
</td>
		<td>
			<label><?php echo $_smarty_tpl->tpl_vars['row']->value['titolo'];?>
 <img src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/core/templates/img/<?php echo $_smarty_tpl->tpl_vars['row']->value['lingua'];?>
.png" height="20px"/></label><br /><small><a class="text-primary" href="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/p/event/<?php echo $_smarty_tpl->tpl_vars['row']->value['nome'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/p/event/<?php echo $_smarty_tpl->tpl_vars['row']->value['nome'];?>
</a></small>
			
		</td>
		<td><a rel='popover' class='pop' href='#' data-title='<?php echo mb_strtoupper($_smarty_tpl->tpl_vars['row']->value['template'], 'UTF-8');?>
' data-img='<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/public/<?php echo $_smarty_tpl->tpl_vars['row']->value['template'];?>
.png'><img class='#imageresource' src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/public/<?php echo $_smarty_tpl->tpl_vars['row']->value['template'];?>
.png" width="100px"/></a></td>
		<td><label class="block"><?php echo $_smarty_tpl->tpl_vars['row']->value['data'];?>
</label><?php echo $_smarty_tpl->tpl_vars['row']->value['ora_inizio'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['ora_fine'];?>
</td>
		<td><label class="block"><a class="text-primary" href="<?php echo $_smarty_tpl->tpl_vars['row']->value['zoom_link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['row']->value['zoom_link'];?>
</a></label><label class="block">ID: <?php echo $_smarty_tpl->tpl_vars['row']->value['zoom_id'];?>
</label><label class="block">PWD: <?php echo $_smarty_tpl->tpl_vars['row']->value['zoom_pwd'];?>
</label>
		</td>
		<td><?php if (!empty($_smarty_tpl->tpl_vars['row']->value['logo'])){?><img src="<?php echo $_smarty_tpl->tpl_vars['siteUrl']->value;?>
/public/<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['pk']->value];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['logo'];?>
" width="40px"/><?php }?></td>
		<td><?php if (!empty($_smarty_tpl->tpl_vars['row']->value['pdf'])){?><?php echo Form::link(array('href'=>((string)$_smarty_tpl->tpl_vars['siteUrl']->value)."/public/".((string)$_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['pk']->value])."/".((string)$_smarty_tpl->tpl_vars['row']->value['pdf']),'value'=>"Informativa sulla privacy",'target'=>'_blanck','img'=>'file-pdf-o','class'=>"btn btn-danger btn-xs"),$_smarty_tpl);?>
<?php }?></td>
	</tr>
	<?php } ?>
</table><?php }} ?>