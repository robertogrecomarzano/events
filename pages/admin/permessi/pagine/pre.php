<?php
Servizi::getPagine();
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "utenti_permessi";
$tablePk = "id";

$mappings = array(
    "id_gruppo" => "gruppo",
    "id_risorsa" => "risorsa",
    "$table.read" => "read",
    "$table.add" => "add",
    "$table.update" => "update",
    "$table.delete" => "delete"
);

$errors = array();
if ($action == "mod2" || $action == "add") {
    if (! isset($_POST['gruppo']) || empty($_POST['gruppo']))
        $errors[] = "Manca il gruppo";
    if (! isset($_POST['risorsa']) || empty($_POST['risorsa']))
        $errors[] = "Manca la risorsa";
    foreach ($errors as $e)
        $page->addError($e);
}

if (empty($errors)) {
    Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);
}

$sql = "SELECT p.id, r.name AS risorsa,g.nome AS gruppo,
		IF(p.read=1,'x','') AS 'read', 
		IF(p.update=1,'x','') AS 'update', 
		IF(p.delete=1,'x','') AS 'delete', 
		IF(p.add=1,'x','') AS 'add' 
		FROM utenti_permessi_risorse r JOIN utenti_permessi p USING(id_risorsa) JOIN utenti_gruppi g ON id_gruppo=id_gruppo_utente
		WHERE type='PAGE'
		ORDER BY gruppo, risorsa";
$rows = Database::getRows($sql);

Form::mappingsAssignPost($rows, $action, $actionId, $tablePk, $mappings, $page);

$page->assign("righe", $rows);
$page->assign("risorse", Database::getRows("SELECT * FROM utenti_permessi_risorse WHERE type='PAGE' ORDER BY 2"));
$page->assign("gruppo", Database::getRows("SELECT g.id_gruppo_utente AS id_gruppo, g.nome AS gruppo FROM utenti_gruppi g ORDER BY 1 "));