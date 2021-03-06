<?php
$obj = new Evento();
$evento = $obj->getParametriEventoByNome();
$isRegistrazionePossibile = $obj->isRegistrazionePossibile($evento);
if (! $isRegistrazionePossibile)
    $page->redirect("expirated", $evento->titolo);

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

           /* $numrows = Database::getCount("utenti", "record_attivo=1 AND user_email=? AND id_evento=?", array(
                $email,
                $evento->id_evento
            ));
            if ($numrows > 0)
                $page->addError("User already registered");
*/
            if (! RegExp::checkEmail($email))
                $page->addError("Email not valid");

            $words = count(explode(" ", $_POST["user_note"]));
            if ($words > 400)
                $page->addError("Reasons for attending the course allow max 400 words ($words typed)");

            if (empty($page->errors))
                $obj->registraUtente($_POST, $evento);
        }
    } else
        $page->addError(Language::get("CAPTCHA_NOT_VALID", array(
            $_REQUEST['captcha_value'],
            $_SESSION['captcha']
        )));
}
$page->assign("writable", $obj->isWritable($evento));
$page->assign("captcha", $captcha->Draw());
$page->assign("evento", $evento);
$page->assign("nazioni", Istat::getNazioni(true));

$file = HTML::tag("input", [
    "type" => "file",
    "name" => "user_attachment",
    "class" => "btn btn-outline btn-default",
    "accept" => ".pdf"
]);
$page->assign("file", $file);

if (count($evento->sessioni) > 1) {
    foreach ($evento->sessioni as &$sessione) {
        $sessione["isEnabled"] = $obj->isRegistrazioneSessionePossibile($sessione);
        $sessione["label"] = "<b class='text-primary'>" . $sessione["titolo"] . "</b> " . CustomDate::format($sessione["data"], "Y-m-d", "d/m/Y") . " <small>" . $sessione["ora_inizio"] . "-" . $sessione["ora_fine"] . "</small>";
    }
    $page->assign("sessions", $evento->sessioni);
}
    