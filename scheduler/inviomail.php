<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
include "/var/www/vhosts/h632659.linp066.arubabusiness.it/events.iamb.it/config.php";
include "/var/www/vhosts/h632659.linp066.arubabusiness.it/events.iamb.it/core/framework.php";
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
    $events = Database::getRows("SELECT e.*, DATE_FORMAT(DATA,'%d/%m/%Y') AS data_dmy FROM eventi e JOIN utenti u USING(id_utente) WHERE inviare=1 AND e.record_attivo=1");

    foreach ($events as &$event) {

        $event["logo"] = Config::$urlRoot . "/" . "public" . "/" . $event["id_evento"] . "/" . $event["logo"];

        Config::$config["email"] = $event["email"];

        $template = strtolower($event["inviare_template"]);
        $subject = ! empty($event["subject"]) ? $event["subject"] : $event["titolo"];
        $flag = "is_" . $template . "_inviato";

        $objUser = new User();
        $users = $objUser->all([
            "record_attivo" => 1,
            "$flag" => 0,
            "id_evento" => $event["id_evento"]
        ]);

        $i = 0;
        $perc = 0;
        $oldperc = 0;
        $n = count($users);

        if ($template == "link")
            Database::query("UPDATE eventi SET send_zoom_link_on_register=1 WHERE id_evento=?", [
                $event["id_evento"]
            ]);

        foreach ($users as $user) {

            $msg = new Message("schedule__$template", null, $subject, $user->user_surname . " " . $user->user_name, $user->user_email, [
                "event" => $event
            ], null, [
                Config::$publicRoot . DS . "tutorial_zoom.pdf"
            ]);
            $ret = $msg->render();

            if ($ret["SUCCESS"])
                $objUser->update($user->id_utente, [
                    "$flag" => 1,
                    "ts_" . $template . "_inviato" => date("Y-m-d H:i:s")
                ]);

            $i ++;
            $perc = round(($i / $n) * 100, 2);
            if ((floor($perc * 10) / 10) != $oldperc) {
                $oldperc = floor($perc * 10) / 10;
                flush();
            }

            Database::query("UPDATE exec_progress SET is_occupato=1, progress=?, timestamp=NOW()", array(
                $perc
            ));

            file_put_contents("mail_evento_" . $event["id_evento"] . ".log", $user->id_utente . ", " . $user->user_email . PHP_EOL, FILE_APPEND | LOCK_EX);
            sleep(1);
        }

        $msg = new Message("schedule__end_sending", null, $subject . " :: invio mail terminato", null, $event["email"], [
            "event" => $event
        ], null, [
            Config::$publicRoot . DS . "tutorial_zoom.pdf"
        ]);
        $ret = $msg->render();

        $objEvento->update($event["id_evento"], [
            "inviare" => 0,
            "inviare_template" => null
        ]);

        Database::query("UPDATE exec_progress SET is_occupato=0, progress=0, timestamp=NOW()", [
            $perc
        ]);
    }

    echo "fine";
}