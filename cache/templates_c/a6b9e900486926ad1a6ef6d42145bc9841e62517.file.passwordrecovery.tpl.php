<?php /* Smarty version Smarty-3.1.11, created on 2021-04-21 17:10:22
         compiled from "C:\wamp\www\events\core\templates\mail\passwordrecovery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3340405646080405e749aa3-16451671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6b9e900486926ad1a6ef6d42145bc9841e62517' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\mail\\passwordrecovery.tpl',
      1 => 1605197408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3340405646080405e749aa3-16451671',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6080405e783546_50838773',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6080405e783546_50838773')) {function content_6080405e783546_50838773($_smarty_tpl) {?><p>
	The password recovery procedure was successful.<br />To log in use the following password: <b><?php echo $_smarty_tpl->tpl_vars['params']->value['password'];?>
</b>
</p><?php }} ?>