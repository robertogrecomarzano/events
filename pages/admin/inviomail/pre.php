<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";

switch ($action) {
    case "confirm":
        foreach ($_POST["sessione"] as $id_sessione => $type) {
            Database::query("UPDATE eventi_sessioni SET inviare=1, inviare_template=? WHERE id_sessione=?", [
                $type,
                $id_sessione
            ]);
            if ($_POST["reset"])
                Database::query("UPDATE eventi_sessioni_utenti SET is_reminder_inviato=0, ts_reminder_inviato=NULL, is_link_inviato=0, ts_link_inviato=NULL WHERE id_sessione=?", [
                    $id_sessione
                ]);
        }

        $page->addMessages("L'invio della mail è stato predisposto, riceverai una mail di conferma al termine dell'operazione");
        break;
    case "annulla":
        /**
         * Annulla la schedulazione per tutti gli eventi dell'Utente
         */
        Database::query("UPDATE eventi SET inviare=0, inviare_template=NULL WHERE id_utente=? AND record_attivo=1", [
            User::getLoggedUserId()
        ]);
        break;
    case "prova":

        foreach ($_POST["event"] as $id_evento => $type) {
            $objEvento = new Evento();
            $event = $objEvento->get($id_evento);

            $event = json_decode(json_encode($event), true);
            $event["logo"] = Config::$urlRoot . "/" . "public" . "/" . $event["id_evento"] . "/" . $event["logo"];

            Config::$config["email"] = $event["email"];

            $template = strtolower($type);

            $subject = ! empty($event["subject"]) ? $event["subject"] : $event["titolo"];

            $msg = new Message("schedule__$template", null, $subject, $event["email"], $event["email"], [
                "event" => $event
            ], null, [
                Config::$publicRoot . DS . "tutorial_zoom.pdf"
            ]);

            $msg->render();
        }
        break;
}