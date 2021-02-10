<?php
$templateFile = $mainTemplateDir . DS . "tpl" . DS . "login-right-version.tpl";
$page->template = $templateFile;

if (isset($_POST['username']) && isset($_POST['password']) && ! User::isUserLogged()) {
    $isValidLogin = User::login($_POST['username'], $_POST['password']);

    if (! $isValidLogin)
        $page->addError(Language::get("ERROR_LOGIN"));
    else {
        $idUtente = User::getLoggedUserId();

        // Abilito i servizi per l'utente, sistemando così eventuali problemi di associazioni mancanti
        $default = Servizi::getServiziDefault("id_servizio", true);
        $idUtente = $_SESSION['user']["id"];

        foreach ($default as $s)
            Servizi::addServizioUtente($idUtente, $s);

        $default_page = Database::getField("SELECT default_page FROM utenti WHERE id_utente=?", array(
            $idUtente
        ));
        $default_page = is_null($default_page) ? "user" : $default_page;
        Page::redirect($default_page);
    }
}
