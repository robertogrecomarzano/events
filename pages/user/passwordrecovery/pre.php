<?php
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "passwordrecovery.tpl";
$page->template = $templateFile;

$captcha = $page->addPlugin("Captcha");
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";

if (! empty($action)) {
    if ($captcha->Validate()) {
        if ($action == "recovery") {

            User::setConfig(true);

            $email = $_POST['email'];
            $row = Database::getRow("SELECT * FROM utenti WHERE email=? AND record_attivo=1", array(
                $email
            ));
            if (count($row) > 0) {
                $clearPassword = User::createRandomPassword();
                $saltPassword = User::saltPassword($clearPassword);
                $id = $row['id_utente'];
                $query = "UPDATE utenti SET password=? WHERE id_utente=?";
                Database::query($query, array(
                    $saltPassword,
                    $id
                ));

               $msg = new Message("passwordrecovery", null, Language::get("RECOVERY_ACCESS_DATA"), $row['cognome'] . " " . $row['nome'], $row['email'], array(
                    "password" => $clearPassword,
                    "sitename" => Config::$config["sitename"]
                ));
                $msg->render();
                $page->assign("recovery", true);
            } else
                $page->addError(Language::get("USER_NOT_FOUND"));
        }
    } else
        $page->addError(Language::get("CAPTCHA_NOT_VALID", array(
            $_REQUEST['captcha_value'],
            $_SESSION['captcha']
        )));
}
$page->assign("captcha", $captcha->Draw());