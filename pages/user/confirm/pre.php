<?php
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "confirm.tpl";
$page->template = $templateFile;
$token = $_GET["token"];

$row = Database::getRow("SELECT * FROM utenti WHERE token = ? AND record_attivo=0 AND ts_confirm IS NULL AND NOW() <= DATE_ADD(ts_create, INTERVAL 48 HOUR) ", array(
    $token
));

if (! empty($row)) {

    Database::query("UPDATE utenti SET record_attivo=1, ts_confirm=NOW() WHERE id_utente=?", array(
        $row["id_utente"]
    ));
    $page->addMessages(Language::get("SIGNUP_CONFIRM", Config::$config["web"]));
    $page->assign("confirmed",true);
} else
    $page->addError(Language::get("SIGNUP_ERROR."));

    
     