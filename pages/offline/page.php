<?php
$page->assign("recoveryLink", Page::getURLStatic("user/passwordrecovery"));
$page->assign("signupLink", Page::getURLStatic("user/signup"));
$page->assign("isUserLogged", User::isUserLogged());
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "offline.tpl";
$page->template = $templateFile;