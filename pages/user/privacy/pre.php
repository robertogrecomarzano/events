<?php
$privacy = new Privacy("tecnico");

$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$userId = User::getLoggedUserId();

if ($action == "confirm")
    $privacy->update($userId);

$privacy_html = $privacy->getFormHtml(false, $userId);
$privacy_html_history = $privacy->getHistory($userId);
$page->assign("privacy_html", $privacy_html);
$page->assign("privacy_html_history", $privacy_html_history);
$page->assign("privacy_link", Config::$urlRoot . "/core/download.php?file=privacy.pdf");