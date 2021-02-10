<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "help";
$tablePk = "id";

$mappings = array(
    "alias" => "alias",
    "text" => "text",
    "title" => "title",
    "stato" => "stato",
    "id_gruppo" => "id_gruppo"
);

Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);

$sql = "SELECT t.*, g.descrizione AS ruolo FROM $table t LEFT JOIN utenti_gruppi g ON t.id_gruppo=g.id_gruppo_utente";
$rows = Database::getRows($sql);
Form::mappingsAssignPost($rows, $action, $actionId, $tablePk, $mappings, $page);

$src = array(
    "writable" => true, // default è true
    "rows" => $rows, // righe ritornate dal db
    "pk" => $tablePk, // chiave primaria tabella
    "inline" => true,
    "title" => "Aggiungi nuova riga", // Testo del botton per nuovo inserimento (solo con inline=false)
    "id" => 'dataTables', // Per attivare la gestione dataTables
    "fields" => array( // fields, usato solo se custom-template è false
        "title" => array(
            "label" => "Titolo"
        ),
        "alias" => array(
            "label" => "Pagina",
            "type" => "text"
        ),
        "text" => array(
            "label" => "Testo",
            "type" => "textarea",
            "others" => array(
                "cols" => "40",
                "rows" => "6"
            )
        ),
        "stato" => array(
            "label" => "Stato",
            "type" => "select",
            "others" => array(
                "src" => array(
                    "Inserito" => "Inserito",
                    "Da validare" => "Da validare",
                    "Pubblicato" => "Pubblicato"
                ),
                "first" => true,
                "required" => "required"
            )
        ),
        "id_gruppo" => array(
            "label" => "Gruppo",
            "value" => "ruolo",
            "type" => "select",
            "others" => array(
                "src" => Database::getRows("SELECT id_gruppo_utente, nome FROM utenti_gruppi ORDER BY nome", null, PDO::FETCH_KEY_PAIR),
                "first" => true,
                "required" => "required"
            )
        )
    )
);
$page->assign("src", $src);