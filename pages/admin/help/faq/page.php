<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "faq";
$tablePk = "id_faq";

$mappings = array(
    "question" => "question",
    "answer" => "answer"
);

/*
 * CONTROLLO DATI
 */
$errors = array();
if ($action == "mod2" || $action == "add2") {
    if (! isset($_POST['question']) || empty($_POST['question']))
        $errors[] = "Manca la domanda.";
    if (! isset($_POST['answer']) || empty($_POST['answer']))
        $errors[] = "Manca la risposta.";

    foreach ($errors as $e)
        $page->addError($e);
}

if (empty($errors)) {
    Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);
}

$righe = Database::getRows("SELECT id_faq, question, answer FROM faq ORDER BY question, answer");
Form::mappingsAssignPost($righe, $action, $actionId, $tablePk, $mappings, $page);
$page->assign("righe", $righe);