<?php
$eventi = Database::getRows("SELECT * FROM eventi WHERE id_utente=? AND record_attivo=1", [
    User::getLoggedUserId()
]);
$page->assign("eventi", $eventi);
foreach($eventi as $event)
{
    if($event["inviare"])
        $_POST["event[".$event["id_evento"]."]"] = $event["inviare_template"];
}
$page->assign("emails", [
    "reminder" => "Reminder",
    "link" => "Link"
]);
