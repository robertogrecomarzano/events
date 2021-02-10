<?php
$page->addPlugin("calendar");

$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;
$table = "eventi";
$tablePk = "id_evento";
$mappings = array(
    "lingua" => "lingua",
    "titolo" => "titolo",
    "nome" => "nome",
    "descrizione" => "descrizione",
    "template" => "template",
    "data" => "data",
    "ora_inizio" => "ora_inizio",
    "ora_fine" => "ora_fine",
    "email" => "email",
    "contact" => "contact",
    "signature" => "signature",
    "subject" => "subject",
    "message" => "message",
    "greeting_message" => "greeting_message",
    "website" => "website",
    "send_zoom_link_on_register" => "send_zoom_link_on_register",
    "zoom_link" => "zoom_link",
    "zoom_id" => "zoom_id",
    "zoom_pwd" => "zoom_pwd",
    "privacy_registrazione_video" => "privacy_registrazione_video",
    "show_logo" => "show_logo",
    "show_logo_ciheam" => "show_logo_ciheam",
    "show_logo_mail" => "show_logo_mail",
    "show_logo_ciheam_mail" => "show_logo_ciheam_mail",
    "show_website_mail" => "show_website_mail"
);

$idUtente = User::getLoggedUserId();
$other = array(
    "record_attivo" => 1,
    "id_utente" => $idUtente
);

/*
 * CONTROLLO DATI
 */
$errors = array();

if ($action == "mod2" || $action == "add2") {

    if (! isset($_POST['titolo']) || empty($_POST['titolo']))
        $errors[] = "Indicare il titolo dell'evento";
    if (! isset($_POST['nome']) || empty($_POST['nome']))
        $errors[] = "Indicare un nome per l'evento (senza spazi)";
    elseif (! preg_match("/^[a-z0-9]+$/", $_POST['nome']))
        $errors[] = "Il campo nome ammette solo lettere e numeri (minuscolo, senza spazi)";
    if (! isset($_POST['template']) || empty($_POST['template']))
        $errors[] = "Selezionare un modello";
    if (! isset($_POST['data']) || empty($_POST['data']))
        $errors[] = "Indicare la data dell'evento";

    if ($action == "add2" && CustomDate::isPrecedente($_POST["data"], "d/m/Y", date("d/m/Y"), "d/m/Y"))
        $errors[] = "La data non può essere riferita ad un giorno passato";

    if ($_POST['send_zoom_link_on_register'] && (! isset($_POST['zoom_link']) || empty($_POST['zoom_link'])))
        $errors[] = "Per attivare l'invio diretto del link di accesso al meeting in fase di registrazione utente, occorre prima indicare il link Zoom";
}

foreach ($errors as $e)
    $page->addError($e);

if (empty($errors)) {

    switch ($action) {
        case "mod":
            $row = Database::getRow("SELECT * FROM $table WHERE $tablePk=?", [
                $actionId
            ]);
            Form::mappingsAssignPost($row, $action, $actionId, $tablePk, $mappings, $page);
            break;
        case "add2":
        case "mod2":
            unset($mappings["data"]);
            $idRiga = Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);

            $_POST["nome"] = strtolower($_POST["nome"]);
            Database::query("UPDATE $table SET data=STR_TO_DATE(?,'%d/%m/%Y') WHERE $tablePk=?", [
                $_POST["data"],
                $idRiga
            ]);

            $url = "event/" . $_POST["nome"] . "|" . $_POST["template"];
            $ini_array = parse_ini_file(Config::$serverRoot . '/events.ini');

            if (! in_array($url, $ini_array))
                file_put_contents(Config::$serverRoot . '/events.ini', "event$idRiga = \"$url\"" . PHP_EOL, FILE_APPEND | LOCK_EX);

            $directory = Config::$serverRoot . DS . "public" . DS . $idRiga;

            if (! is_dir($directory))
                mkdir($directory, 0755, TRUE);
            $time = date("dHis");

            if ((! empty($_FILES["foto"]['name']) && $_FILES["foto"]['error'] == 0 && $_FILES["foto"]['size'] > 0)) {

                $extension = strtolower(strrchr($_FILES["foto"]['name'], '.'));

                if (in_array($extension, [
                    ".jpg",
                    ".jpeg",
                    ".png"
                ])) {

                    if (! move_uploaded_file($_FILES["foto"]["tmp_name"], $directory . DS . "$time$extension"))
                        $errors[] = "Errore con l'upload della foto";
                    else {
                        Database::query("UPDATE $table SET logo=? WHERE $tablePk=?", [
                            "$time$extension",
                            $idRiga
                        ]);
                    }
                } else
                    $errors[] = "Tipo file non ammesso ($extension). Caricare solo file con estensione [" . implode(", ", [
                        "jpg",
                        "jpeg",
                        "png"
                    ]) . "]";
            } elseif ($action == "add2") {
                Database::query("UPDATE $table SET logo=? WHERE $tablePk=?", [
                    $time . ".png",
                    $idRiga
                ]);
                copy(Config::$serverRoot . DS . "core" . DS . "templates" . DS . "img" . DS . "logo.png", $directory . DS . $time . ".png");
            }

            if ((! empty($_FILES["pdf"]['name']) && $_FILES["pdf"]['error'] == 0 && $_FILES["pdf"]['size'] > 0)) {

                $extension = strtolower(strrchr($_FILES["pdf"]['name'], '.'));

                if (in_array($extension, [
                    ".pdf"
                ])) {

                    if (! move_uploaded_file($_FILES["pdf"]["tmp_name"], $directory . DS . "$time$extension"))
                        $errors[] = "Errore con l'upload dell'informativa sulla privacy";
                    else {
                        Database::query("UPDATE $table SET pdf=? WHERE $tablePk=?", [
                            "$time$extension",
                            $idRiga
                        ]);
                    }
                } else
                    $errors[] = "Tipo file non ammesso ($extension). Caricare solo file con estensione [" . implode(", ", [
                        "pdf"
                    ]) . "]";
            }

            break;
        case "del":
            Form::processAction($action, $actionId, $table, $tablePk, $mappings, $other);
            $righe = Database::getRows("SELECT * FROM $table WHERE record_attivo=1");
            file_put_contents(Config::$serverRoot . '/events.ini', "[EVENTS]" . PHP_EOL);
            foreach ($righe as $riga) {
                $url = "event/" . $riga["nome"];
                $idriga = $riga["id_evento"];
                $template = $riga["template"];
                $ini_array = parse_ini_file(Config::$serverRoot . '/events.ini');
                if (! in_array($url, $ini_array))
                    file_put_contents(Config::$serverRoot . '/events.ini', "event$idriga = \"$url|$template\"" . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            break;
    }
}

if (User::isSuperUser()) {

    $sql = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y') AS data FROM $table WHERE record_attivo=1 AND record_attivo=1";
    $rows = Database::getRows($sql);
} else {
    $sql = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y') AS data FROM $table WHERE record_attivo=1 AND id_utente=? AND record_attivo=1";
    $rows = Database::getRows($sql, [
        $idUtente
    ]);
}
Form::mappingsAssignPost($rows, $action, $actionId, $tablePk, $mappings, $page);

if ($action == "mod" || $action == "add" || (! empty($errors) && ($action == "mod2" || $action == "add2"))) {
    $riga = array_filter($rows, function ($var) use ($actionId) {
        return ($var["id_evento"] == $actionId);
    });

    $riga = reset($riga);

    $immagine = null;
    if (file_exists(Config::$serverRoot . DS . "public" . DS . $actionId . DS . $riga["logo"]) && $action != "add" && ! empty($riga["logo"]))
        $immagine = Config::$urlRoot . "/" . "public" . "/" . $actionId . "/" . $riga["logo"];
    $page->assign("immagine", $immagine);

    $file = HTML::tag("input", [
        "type" => "file",
        "name" => "foto",
        "class" => "btn btn-outline btn-default"
    ]);
    $page->assign("file", $file);

    $fileprivacy = HTML::tag("input", [
        "type" => "file",
        "name" => "pdf",
        "class" => "btn btn-outline btn-default"
    ]);
    $page->assign("fileprivacy", $fileprivacy);
    $pdf = null;
    if (file_exists(Config::$serverRoot . DS . "public" . DS . $actionId . DS . $riga["pdf"]) && $action != "add" && ! empty($riga["pdf"]))
        $pdf = Config::$urlRoot . "/" . "public" . "/" . $actionId . "/" . $riga["pdf"];
    $page->assign("pdf", $pdf);
}

/**
 * Gestione delle tabelle inline (e non)
 *
 * Basta fare $page->assign("src"=>$src) e nel template scrivere {form_table src=$src}
 */
$isWritable = User::isUserInGroups([
    "superuser",
    "editor"
]);

$ore = [];
for ($i = 8; $i <= 22; $i ++) {
    $ore["$i:00"] = "$i:00";
    $ore["$i:15"] = "$i:15";
    $ore["$i:30"] = "$i:30";
    $ore["$i:45"] = "$i:45";
}


$page->assign("ore", $ore);
$src = array(
    "writable" => $isWritable, // default è true
    "rows" => $rows, // righe ritornate dal db
    "pk" => $tablePk, // chiave primaria tabella
    "inline" => false,
    "title" => "Aggiungi nuovo evento", // Testo del botton per nuovo inserimento (solo con inline=false)
    "id" => 'dataTables', // Per attivare la gestione dataTables
    "custom-template" => true
);
$page->assign("src", $src);