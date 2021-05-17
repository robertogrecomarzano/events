<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
// include "/var/www/vhosts/h632659.linp066.arubabusiness.it/events.iamb.it/config.php";
// include "/var/www/vhosts/h632659.linp066.arubabusiness.it/events.iamb.it/core/framework.php";

include "../config.php";
include "../core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

User::setConfig();

$progress = Database::getRow("SELECT * FROM exec_progress");
$is_occupato = $progress["is_occupato"];

if ($is_occupato)
    die("servizio occupato");
else {

    $objEvento = new Evento();
    $events = Database::getRows("SELECT *, 
                                   DATE_FORMAT(s.data,'%d/%m/%Y') AS data_dmy,
                                   e.data_inizio, e.data_fine,
                                   e.titolo AS titolo,
                                   e.lingua
                                   FROM eventi_sessioni s
                                   JOIN eventi e USING(id_evento)
                                   WHERE s.inviare=1 AND e.record_attivo=1 AND s.record_attivo=1
                                   GROUP BY s.id_sessione");

    foreach ($events as &$event) {

        $event["logo"] = Config::$urlRoot . "/" . "public" . "/" . $event["id_evento"] . "/" . $event["logo"];

        if (Config::$defaultLocale != $event["lingua"])
            setlocale(LC_TIME, $event["lingua"]);

        /*
         * switch ($event["modalita"]) {
         * case "singola":
         * $event["data_extended"] = strftime("%e %B %Y", strtotime($event["data_inizio"]));
         * if ($event["data_inizio"] != $event["data_fine"])
         * $event["data_extended"] .= " - " . strftime("%e %B %Y", strtotime($event["data_fine"]));
         * break;
         * case "multipla":
         * $event["data_extended"] = strftime("%e %B %Y", strtotime($event["data"]));
         * break;
         * }
         */

        Config::$config["email"] = $event["email"];

        $template = strtolower($event["inviare_template"]);
        $subject = ! empty($event["subject"]) ? $event["subject"] : $event["titolo"];
        $flag = "is_" . $template . "_inviato";

        $users = Database::getRows("SELECT * FROM eventi_sessioni_utenti s JOIN utenti USING(id_utente) WHERE id_sessione=? AND $flag=0", [
            $event["id_sessione"]
        ]);

        $i = 0;
        $perc = 0;
        $oldperc = 0;
        $n = count($users);

        if ($template == "link")
            Database::query("UPDATE eventi_sessioni SET zoom_send_link_on_register=1 WHERE id_sessione=?", [
                $event["id_sessione"]
            ]);

        foreach ($users as $user) {

            $msg = new Message("schedule__$template", null, $subject, $user["user_surname"] . " " . $user["user_name"], $user["user_email"], [
                "event" => $event
            ], null, [
                Config::$publicRoot . DS . "tutorial_zoom.pdf"
            ]);
            $ret = $msg->render();

            if ($ret["SUCCESS"]) {

                $field = "ts_" . $template . "_inviato";
                Database::query("UPDATE eventi_sessioni_utenti SET $flag=1, $field=? WHERE id_sessione=? AND id_utente=?", [
                    date("Y-m-d H:i:s"),
                    $user["id_sessione"],
                    $user["id_utente"]
                ]);
            }

            $i ++;
            $perc = round(($i / $n) * 100, 2);
            if ((floor($perc * 10) / 10) != $oldperc) {
                $oldperc = floor($perc * 10) / 10;
                flush();
            }

            Database::query("UPDATE exec_progress SET is_occupato=1, progress=?, timestamp=NOW()", array(
                $perc
            ));

            file_put_contents("mail_evento_" . $event["id_sessione"] . ".log", $user["id_utente"] . ", " . $user["user_email"] . PHP_EOL, FILE_APPEND | LOCK_EX);
            sleep(1);
        }

        $msg = new Message("schedule__end_sending", null, $subject . " :: invio mail terminato", null, $event["email"], [
            "event" => $event
        ], null, [
            Config::$publicRoot . DS . "tutorial_zoom.pdf"
        ]);
        $ret = $msg->render();

        Database::query("UPDATE eventi_sessioni SET inviare=0, inviare_template=NULL WHERE id_sessione=?", [
            $event["id_sessione"]
        ]);

        Database::query("UPDATE exec_progress SET is_occupato=0, progress=0, timestamp=NOW()", [
            $perc
        ]);
    }

    echo "fine";
}