<?php
$sessioni = Database::getRows("SELECT s.*,
                               e.titolo AS titolo_evento, 
                               DATE_FORMAT(e.data_inizio,'%d/%m/%Y') AS data_inizio_evento,
                               DATE_FORMAT(e.data_fine,'%d/%m/%Y') AS data_fine_evento,
                               DATE_FORMAT(s.data,'%d/%m/%Y') AS data_sessione
                               FROM eventi e JOIN eventi_sessioni s USING(id_evento) WHERE id_utente=1 AND e.record_attivo=1 AND s.record_attivo=1", [
    User::getLoggedUserId()
]);
$page->assign("sessioni", $sessioni);
foreach($sessioni as $sessione)
{
    if($sessione["inviare"])
        $_POST["sessione[".$sessione["id_sessione"]."]"] = $sessione["inviare_template"];
}
$page->assign("emails", [
    "reminder" => "Reminder",
    "link" => "Link"
]);
