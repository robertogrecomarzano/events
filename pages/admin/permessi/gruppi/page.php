<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "utenti_gruppi";
$tablePk = "id_gruppo_utente";

$mappings = array(
    "nome" => "gruppo",
    "descrizione" => "descrizione"
);

/*
 * CONTROLLO DATI
 */
$errors = array();
if ($action == "mod2" || $action == "add2") {
    if (! isset($_POST['gruppo']) || empty($_POST['gruppo']))
        $errors[] = "Indicare il gruppo.";
    if (! isset($_POST['descrizione']) || empty($_POST['descrizione']))
        $errors[] = "Indicare una descrizione per il gruppo.";

    if ($action == "add2")
        if (Form::checkDupes($table, $mappings, array(
            "nome"
        )))
            $errors[] = "Gruppo già inserito, indicare un'altra voce e riprovare!";
    foreach ($errors as $e)
        $page->addError($e);
}

if (empty($errors)) {
    Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);

    if ($action == "add2") {
        $servizi = Servizi::getServizi("id_servizio");
        foreach ($servizi as $s)
            Servizi::addServizioGruppoRegione($actionId, $s['servizio']);
    }
}

$sql = "SELECT * FROM $table";
$righe = Database::getRows($sql);

Form::mappingsAssignPost($righe, $action, $actionId, $tablePk, $mappings, $page);

$src = array(
    "rows" => $righe, // righe ritornate dal db
    "pk" => $tablePk, // chiave primaria tabella
    "inline" => true,
    "title" => "Aggiungi nuovo gruppo", // Testo del botton per nuovo inserimento (solo con inline=false)
    "id" => 'dataTables',
    "fields" => array( // fields, usato sulo se custom-template è false
        "nome" => array(
            "label" => "Gruppo",
            "type" => "text",
            "name" => "gruppo",
            "others" => array(
                "size" => 40,
                "required" => "required"
            )
        ),
        "descrizione" => array(
            "label" => "Descrizione",
            "type" => "textarea",
            "others" => array(
                "rows" => 2,
                "required" => "required"
            )
        )
    )
);
$page->assign("src", $src);