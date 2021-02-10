<?php
$obj = new Evento();
$evento = $obj->getParametriEventoByNome();
$isRegistrazionePossibile = $obj->isRegistrazionePossibile($evento);
if (! $isRegistrazionePossibile)
    $page->redirect("notfound", "evento");

$templateFile = $mainTemplateDir . DS . "tpl" . DS . "signup.tpl";
$page->template = $templateFile;
$page->assign("signupContent", $evento->template);
$captcha = $page->addPlugin("Captcha");
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";

if (! empty($action)) {
    if ($captcha->Validate()) {
        if ($action == "confirm") {

            User::setConfig(true);

            $email = trim($_POST['user_email']);

            $numrows = Database::getCount("utenti", "record_attivo=1 AND user_email=? AND id_evento=?", array(
                $email,
                $evento->id_evento
            ));
            if ($numrows > 0)
                $page->addError("User already registered");

            if (! RegExp::checkEmail($email))
                $page->addError("Email not valid");

            if (empty($page->errors))
                $obj->registraUtente($_POST, $evento);
        }
    } else
        $page->addError(Language::get("CAPTCHA_NOT_VALID", array(
            $_REQUEST['captcha_value'],
            $_SESSION['captcha']
        )));
}

$page->assign("captcha", $captcha->Draw());
$page->assign("evento", $evento);
$page->assign("nazioni", Istat::getNazioni(true));