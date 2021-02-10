<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";

if (! empty($action)) {
    $oggetto = $_POST["oggetto"];
    $testo = str_replace("\n", '<br/>', $_POST["messaggio"]);
    $destinatario = empty($_POST["destinatario"]) ? Config::$config["sitename"] : $_POST["destinatario"];
    $email_destinatario = empty($_POST["email_destinatario"]) ? Config::$config["email"] : $_POST["email_destinatario"];

    $msg = new Message("test", null, $oggetto, $destinatario, $email_destinatario, array(
        "oggetto" => $oggetto,
        "testo" => $testo
    ));
    $ret = $msg->render();

    if ($ret["SUCCESS"] === "FALSE") {
        $page->assign("return", print_r($ret["ERROR"], true));
        $page->assign("debug_message", $ret["DEBUG"]);
    }
}