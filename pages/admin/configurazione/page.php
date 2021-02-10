<?php
$table = "config";
$tablePk = "id";
$mappings = array();
$describe = Database::describeTableFields($table, array(
    "id"
));

$fields_str = Database::getFieldsString($table, array(
    "id"
));
$fields = explode(",", $fields_str);
foreach ($fields as $f)
    $mappings[$f] = $f;

$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$action_id = isset($_POST['form_id']) ? $_POST['form_id'] : "";

if ($action == "mod2") {
    Form::processAction($action, $action_id, $table, $tablePk, $mappings);
    User::setConfig(true);
}
$page->assign("fields", $describe);

$riga = Database::getRow("SELECT * FROM $table");

$page->assign("pkValue", $riga[$tablePk]);

foreach (array_keys($riga) as $k)
    $_POST["$k"] = $riga["$k"];
            
            
            
            