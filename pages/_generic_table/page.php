<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;
$table = "table_name";
$tablePk = "primary_key";
$mappings = array(
    "field_1" => "field_1",
    "field_2" => "field_2",
    "field_n" => "field_n"
);

Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);

$sql = "SELECT * FROM $table WHERE record_attivo=1 ...";
$rows = Database::getRows($sql);
Form::mappingsAssignPost($rows, $action, $actionId, $tablePk, $mappings, $page);

/**
 * Gestione delle tabelle inline (e non)
 *
 * Basta fare $page->assign("src"=>$src) e nel template scrivere {form_table src=$src}
 */
$src = array(
    "writable" => true | false, // default è true
    "rows" => $rows, // righe ritornate dal db
    "pk" => $tablePk, // chiave primaria tabella
    "inline" => true | false,
    "title" => "Aggiungi nuova riga", // Testo del botton per nuovo inserimento (solo con inline=false)
    "id" => 'dataTables', // Per attivare la gestione dataTables
    "custom-template" => true | false, // Per usare dei template custom (table.tpl e add.tpl)
    "fields" => array( // fields, usato solo se custom-template è false
        "field_1" => array(
            "label" => "Es. textbox",
            "type" => "text",
            "writable" => true | false, // true di default
            
        ),
        "dettaglio" => array(
            "label" => "Dettaglio",
            
        ),
        "field_3" => array(
            "label" => "Es. checkbox",
            "type" => "checkbox",
            "others" => array(
                "required" => "required"
            )
        
        ),
        "field_4" => array(
            "label" => "Es. select option",
            "type" => "select",
            "others" => array(
                "src" => array(
                    "1" => "si",
                    "0" => "no"
                ),
                "first" => true,
                "required" => "required"
            )
        ),
        "field_5" => array(
            "label" => "Es. radio",
            "type" => "radio",
            "others" => array(
                "required" => "required"
            )
        ),
        "field_6" => array(
            "label" => "Es. text con value",
            "value" => "numero_release", // se il campo ritornato dalla query è differente dal nome della colonna
            "type" => "number",
            "others" => array(
                "size" => 8,
                "required" => "required",
                "min" => 1
            
            )
        )
    )
);
$page->assign("src", $src);