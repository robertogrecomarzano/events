<?php
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "notauth.tpl";
$page->template = $templateFile;

$check = $_GET['param'];
if (empty($check))
    Page::redirect("user");