<?php /* Smarty version Smarty-3.1.11, created on 2021-04-21 17:13:33
         compiled from "C:\wamp\www\events\core\templates\mail\profile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:287292636080411d6cd5f0-63148415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac6dc80076df9d509d9eede7ec1ab2a48aeae399' => 
    array (
      0 => 'C:\\wamp\\www\\events\\core\\templates\\mail\\profile.tpl',
      1 => 1604657895,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '287292636080411d6cd5f0-63148415',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sitename' => 0,
    'params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6080411d70ede0_13482720',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6080411d70ede0_13482720')) {function content_6080411d70ede0_13482720($_smarty_tpl) {?><p>
	<?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
<br> The Portal password is: <b><?php echo $_smarty_tpl->tpl_vars['params']->value['password'];?>
</b>.
</p>
<?php }} ?>