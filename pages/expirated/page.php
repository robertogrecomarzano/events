<?php
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "expirated.tpl";
$page->template = $templateFile;

$page->assign("evento",$_GET["param"]);