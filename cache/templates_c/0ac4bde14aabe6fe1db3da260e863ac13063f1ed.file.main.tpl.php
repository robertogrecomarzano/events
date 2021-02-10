<?php /* Smarty version Smarty-3.1.11, created on 2021-02-10 16:14:17
         compiled from "C:\wamp\www\events\pages\admin\eventi\templates\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2751780346023f849555f14-61366285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ac4bde14aabe6fe1db3da260e863ac13063f1ed' => 
    array (
      0 => 'C:\\wamp\\www\\events\\pages\\admin\\eventi\\templates\\main.tpl',
      1 => 1603879409,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2751780346023f849555f14-61366285',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'src' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_6023f8495e59e5_71971296',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6023f8495e59e5_71971296')) {function content_6023f8495e59e5_71971296($_smarty_tpl) {?><?php echo Form::form_table(array('src'=>$_smarty_tpl->tpl_vars['src']->value,'enctype'=>"multipart/form-data"),$_smarty_tpl);?>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="max-width: 450px;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php }} ?>