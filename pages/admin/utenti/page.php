<?php

$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "utenti";
$tablePk = "id_utente";

$mappings = array(
    "cognome" => "cognome",
    "nome" => "nome",
    "username" => "username",
    "citta" => "comune",
    "email" => "email",
    "indirizzo" => "indirizzo",
    "telefono" => "telefono",
    "readonly" => "sola_lettura"
);

$other = array(
    "record_attivo" => 1
);

if (! empty($_POST['password']))
    $other["password"] = User::saltPassword($_POST['password']);

if (! empty($action)) {

    $errors = array();

    switch ($action) {
        case "mod2":
        case "add2":
            $numrows = Database::getCount("utenti", "record_attivo=1 AND username=? AND email=?", array(
                $_POST["username"],
                $_POST["email"]
            ));

            if ($numrows > 0 && $action == "add2")
                $errors[] = "Utente già presente";
            if (! isset($_POST['username']) || empty($_POST['username']))
                $errors[] = "Indicare lo username.";
            break;
    }

    foreach ($errors as $e)
        $page->addError($e);

    if (empty($errors)) {
        switch ($action) {
            case "mod2":
            case "add2":
                $newId = Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);
                $actionId = ($action == "add2" && empty($actionId)) ? $newId : $actionId;

                Database::query("DELETE FROM utenti_has_gruppi WHERE id_utente=?", array(
                    $actionId
                ));

                if (isset($_POST['gruppo']))
                    foreach ($_POST['gruppo'] as $g)
                        Database::query("INSERT INTO utenti_has_gruppi SET id_utente=?, id_gruppo_utente=?", array(
                            $actionId,
                            $g
                        ));

                Database::query("DELETE FROM servizi_utenti WHERE id_utente=?", array(
                    $actionId
                ));
                if (isset($_POST['servizio']))
                    foreach ($_POST['servizio'] as $ids)
                        Servizi::addServizioUtente($actionId, $ids);

                $subject = Language::get("SIGNUP_SUCCESS_OBJECT_MAIL", array(
                    Config::$config["sitename"]
                ));

                /**
                 * Invio mail con username
                 */
                $msg = new Message("signup1", null, $subject, $_POST['cognome'] . " " . $_POST['nome'], $_POST['email'], array(
                    "username" => $_POST["username"]
                ));
                $retvalue = $msg->render();

                if ($retvalue['SUCCESS'] == "TRUE" && ! empty($_POST["password"])) {
                    /**
                     * Invio mail con password
                     */
                    $msg = new Message("signup2", null, $subject, $_POST['cognome'] . " " . $_POST['nome'], $_POST['email'], array(
                        "password" => $_POST["password"],
                        "nominativo" => $_POST['cognome'] . " " . $_POST['nome']
                    ));
                    $msg->render();
                }
                break;
            case "del":
                Database::query("UPDATE utenti SET record_attivo=0 WHERE id_utente=?", array(
                    $actionId
                ));
                break;
        }
    }
}


if ($actionId > 0 && $action == "mod") {

    unset($_POST['gruppo']);
    $gruppo = Database::getRows("SELECT * FROM utenti_gruppi g JOIN utenti_has_gruppi USING(id_gruppo_utente) WHERE id_utente=?", array(
        $actionId
    ));
    foreach ($gruppo as $a)
        $_POST['gruppo'][] = $a['id_gruppo_utente'];

    unset($_POST['servizio']);
    $servizio = Database::getRows("SELECT DISTINCT cs.id_servizio,  cs.servizio 
			FROM servizi_utenti us 
			JOIN servizi cs USING(id_servizio)
			JOIN servizi_config_gruppo USING(id_servizio)
			WHERE id_utente=?", array(
        $actionId
    ));
    foreach ($servizio as $ids)
        $_POST['servizio'][] = $ids['id_servizio'];

    $where2 = "AND u.id_utente = $actionId";
}

$params = [];


$sql = "SELECT u.*, 
GROUP_CONCAT(DISTINCT(g.nome)) AS profili
FROM utenti u
LEFT JOIN utenti_has_gruppi ug USING(id_utente)
LEFT JOIN utenti_gruppi g USING(id_gruppo_utente)
WHERE u.record_attivo=1 
AND (evento IS NULL OR evento='')
GROUP BY id_utente
ORDER BY g.nome ASC";
$righe = Database::getRows($sql, $params);

$page->assign('righe', $righe);
$gruppi = Database::getRows("SELECT id_gruppo_utente,nome FROM utenti_gruppi", null, PDO::FETCH_KEY_PAIR);

$page->assign("gruppi", $gruppi);
$servizi = Database::getRows("SELECT DISTINCT id_servizio,servizio FROM servizi_config_gruppo cs JOIN servizi USING(id_servizio) ", null, PDO::FETCH_KEY_PAIR);

$page->assign("servizi", $servizi);

Form::mappingsAssignPost($righe, $action, $actionId, $tablePk, $mappings, $page);

$page->assign("src", array(
    "writable" => User::isSuperUser(),
    "custom-template" => true,
    "title" => "Registra nuovo utente"
));

