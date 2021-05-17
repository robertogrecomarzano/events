<?php
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
$actionId = isset($_POST['form_id']) ? $_POST['form_id'] : 0;

$table = "utenti";
$tablePk = "id_utente";

$mappings = array(
    "cognome" => "cognome",
    "nome" => "nome",
    "citta" => "comune",
    "email" => "email",
    "indirizzo" => "indirizzo",
    "telefono" => "telefono"
);

$objEvento = new Evento();

if ($action == "cancella") {

    Database::query("UPDATE utenti SET record_attivo=0 WHERE id_evento=?", [
        $_POST["evento"]
    ]);
}

if ($action == "export") {

    $sql = "SELECT *
                    FROM utenti u
                    WHERE record_attivo=1 AND id_evento=?
                    ORDER BY user_surname, user_name ASC";
    $iscritti = Database::getRows($sql, [
        $_POST["evento"]
    ]);

    $evento = $objEvento->get($_POST["evento"]);

    $fields = [];
    switch ($evento->template) {
        case "basicit":
            $fields = [
                "Nome",
                "Cognome",
                "Email",
                "Categoria",
                "Ente di appartenenza"
            ];
            break;
        case "baseinnovazioneit":
            $fields = [
                "Nome",
                "Cognome",
                "Email",
                "Settore",
                "Ente di appartenenza"
            ];
            break;
        case "basic":
            $fields = [
                "Name",
                "Surname",
                "Email",
                "Groups",
                "Business name"
            ];
            break;
        case "intermediate":
            $fields = [
                "Name",
                "Surname",
                "Email",
                "Country",
                "Organization",
                "Groups",
                "Hearsay"
            ];
            break;
        case "preadvanced":
            $fields = [
                "Name",
                "Surname",
                "Email",
                "Country",
                "Organization",
                "Age",
                "Gender",
                "Sectors",
                "Groups"
            ];
            break;
        case "advanced":
            $fields = [
                "Name",
                "Surname",
                "Gender",
                "Nationality",
                "Age",
                "Email",
                "Phone",
                "Groups",
                "Topics",
                "Hearsay"
            ];
            break;
        case "international":
            $fields = [
                "Name",
                "Surname",
                "Email",
                "Groups",
                "Organization",
                "Position"
            ];
            break;
        case "call":
            $fields = [
                "Name",
                "Surname",
                "Country",
                "Email",
                "Phone",
                "Address",
                "Job position",
                "Institution",
                "Note"
            ];
            break;
        case "callfull":
            $fields = [
                "Name",
                "Surname",
                "Gender",
                "Country",
                "Email",
                "Phone",
                "Address",
                "Job position",
                "Institution",
                "Submission title",
                "List of authors",
                "Session",
                "Type of presentation"
            ];
            break;
        case "expert":
            $fields = [
                "Title",
                "Name",
                "Surname",
                "Gender",
                "Country",
                "Email",
                "Phone",
                "Organisation",
                "Acronym",
                "Institute/Department",
                "Position"
            ];
            break;
        case "experttwo":
            $fields = [
                "Title",
                "Name",
                "Surname",
                "Gender",
                "Country",
                "Email",
                "Organisation",
                "Position",
                "Category"
            ];
            break;
    }

    $sessions = $objEvento->getSessioni($_POST["evento"]);

    $record = [];
    foreach ($iscritti as $iscritto) {
        $data = [];

        if (in_array("Title", $fields))
            $data["Title"] = $iscritto["user_title"];
        if (in_array("Submission title", $fields))
            $data["Submission title"] = $iscritto["user_title"];
        if (in_array("Name", $fields))
            $data["Name"] = $iscritto["user_name"];
        if (in_array("Surname", $fields))
            $data["Surname"] = $iscritto["user_surname"];
        if (in_array("Nome", $fields))
            $data["Nome"] = $iscritto["user_name"];
        if (in_array("Cognome", $fields))
            $data["Cognome"] = $iscritto["user_surname"];
        if (in_array("Email", $fields))
            $data["Email"] = $iscritto["user_email"];
        if (in_array("Gender", $fields))
            $data["Gender"] = $iscritto["user_gender"];
        if (in_array("Country", $fields))
            $data["Country"] = $iscritto["user_country"];
        if (in_array("Address", $fields))
            $data["Address"] = $iscritto["user_address"];
        if (in_array("Phone", $fields))
            $data["Phone"] = $iscritto["user_phone"];
        if (in_array("Organization", $fields))
            $data["Organization"] = $iscritto["user_organization"];
        if (in_array("Organisation", $fields))
            $data["Organisation"] = $iscritto["user_organization"];
        if (in_array("Organization", $fields))
            $data["Organization"] = $iscritto["user_organization"];
        if (in_array("Acronym", $fields))
            $data["Acronym"] = $iscritto["user_organization_acronym"];
        if (in_array("Institute/Department", $fields))
            $data["Institute/Department"] = $iscritto["user_institution"];
        if (in_array("Position", $fields))
            $data["Position"] = $iscritto["user_position"];
        if (in_array("Nationality", $fields))
            $data["Nationality"] = $iscritto["user_nationality"];
        if (in_array("Age", $fields))
            $data["Age"] = $iscritto["user_age"];
        if (in_array("Phone", $fields))
            $data["Phone"] = $iscritto["user_phone"];
        if (in_array("Groups", $fields)) {
            $data["Groups"] = str_replace(",", "\r\n", $iscritto["user_group"]);
            if (! empty($iscritto["user_group_other"]))
                $data["Groups"] .= "\r\n" . $iscritto["user_group_other"];
        }
        if (in_array("Category", $fields)) {
            $data["Category"] = str_replace(",", "\r\n", $iscritto["user_group"]);
            if (! empty($iscritto["user_group_other"]))
                $data["Category"] .= "\r\n" . $iscritto["user_group_other"];
        }
        if (in_array("Sectors", $fields)) {
            $data["Sectors"] = str_replace(",", "\r\n", $iscritto["user_sector"]);
            if (! empty($iscritto["user_sector_other"]))
                $data["Sectors"] .= "\r\n" . $iscritto["user_sector_other"];
        }
        if (in_array("Categoria", $fields)) {
            $data["Categoria"] = str_replace(",", "\r\n", $iscritto["user_group"]);
            if (! empty($iscritto["user_group_other"]))
                $data["Categoria"] .= "\r\n" . $iscritto["user_group_other"];
        }
        if (in_array("Settore", $fields)) {
            $data["Settore"] = str_replace(",", "\r\n", $iscritto["user_group"]);
            if (! empty($iscritto["user_group_other"]))
                $data["Settore"] .= "\r\n" . $iscritto["user_group_other"];
        }
        if (in_array("Business name", $fields))
            $data["Business name"] = $iscritto["user_business_name"];
        if (in_array("Ente di appartenenza", $fields))
            $data["Ente di appartenenza"] = $iscritto["user_business_name"];

        if (in_array("Policy maker institution", $fields))
            $data["Policy maker institution"] = $iscritto["user_policy_maker_institution"];
        if (in_array("Policy maker department", $fields))
            $data["Policy maker department"] = $iscritto["user_policy_maker_department"];
        if (in_array("Policy maker position", $fields))
            $data["Policy maker position"] = $iscritto["user_policy_maker_position"];
        if (in_array("International organisation institution", $fields))
            $data["International organisation institution"] = $iscritto["user_international_organisation_institution"];
        if (in_array("International organisation department", $fields))
            $data["International organisation department"] = $iscritto["user_international_organisation_department"];
        if (in_array("International organisation position", $fields))
            $data["International organisation position"] = $iscritto["user_international_organisation_position"];
        if (in_array("Topics", $fields))
            $data["Topics"] = str_replace(",", "\r\n", $iscritto["user_topic"]);
        if (in_array("Hearsay", $fields)) {
            $data["Hearsay"] = str_replace(",", "\r\n", $iscritto["user_hear"]);
            if (! empty($iscritto["user_hear_other"]))
                $data["Hearsay"] .= "\r\n" . $iscritto["user_hear_other"];
        }

        if (in_array("Job position", $fields))
            $data["Job position"] = $iscritto["user_job_position"];
        if (in_array("Institution", $fields))
            $data["Institution"] = $iscritto["user_institution"];
        if (in_array("Note", $fields))
            $data["Note"] = $iscritto["user_note"];
        if (in_array("List of authors", $fields))
            $data["List of authors"] = $iscritto["user_authors"];
        if (in_array("Session", $fields))
            $data["Session"] = $iscritto["user_session"];
        if (in_array("Type of presentation", $fields))
            $data["Type of presentation"] = $iscritto["user_presentation"];

        if (! empty($iscritto["user_attachment"]) && file_exists(Config::$serverRoot . DS . "public" . DS . $iscritto["evento"] . DS . $iscritto["id_utente"] . DS . $iscritto["user_attachment"]))
            $data["Attachment"] = $iscritto["user_attachment"];

        if ($objEvento->orm_record->modalita == "multipla" && count($sessions) > 1) {

            $i = 1;
            foreach ($sessions as $session) {
                $fields[] = "Session $i";
                $data["Session $i"] = "";
                $tot = Database::getCount("eventi_sessioni_utenti", "id_utente=? AND id_sessione=?", [
                    $iscritto["id_utente"],
                    $session["id_sessione"]
                ]);

                if ($tot > 0)
                    $data["Session $i"] = $session["titolo"] . " :: " . CustomDate::format($session["data"], "Y-m-d", "d/m/Y") . " " . $session["ora_inizio"] . "-" . $session["ora_fine"];
                $i ++;
            }
        }

        $record[] = $data;
    }

    foreach ($fields as $field)
        foreach ($record[0] as $k => $v) {
            if ($k == $field)
                $header[$k] = "string";
        }

    $path = Config::$publicRoot;
    $writer = new XLSXWriter();
    $writer->setAuthor("CIHEAM");
    $foglio = "Iscritti";

    $writer->writeSheetHeader($foglio, $header, array(
        'font' => 'Arial',
        'font-size' => 10,
        'font-style' => 'bold',
        'fill' => '#eee',
        'valign' => 'center',
        'border' => 'left,right,top,bottom'
    ));

    foreach ($record as $row) {
        $riga = [];
        foreach ($fields as $field)
            $riga[$field] = $row[$field];
        $writer->writeSheetRow($foglio, $riga, [
            'wrap_text' => true,
            'valign' => 'center'
        ]);
    }
    $filename = "users.xlsx";
    $writer->writeToFile($path . DS . $filename);

    if (file_exists($path . DS . $filename)) {
        $page->addMessages("Operazione completata, per avviare il download del file clicca sul link in basso.");
        $page->assign("filename", $filename);
    }
}

if ($action == "del")
    Form::processAction($action, $actionId, $table, $tablePk, $mappings);

if (User::isSuperUser()) {
    $sql = "SELECT u.*, e.titolo
FROM utenti u
JOIN eventi e USING(id_evento)
WHERE u.record_attivo=1";
    $righe = Database::getRows($sql);
} else {
    $sql = "SELECT u.*, e.titolo
FROM utenti u
JOIN eventi e USING(id_evento)
WHERE u.record_attivo=1
AND e.id_utente=?";
    $righe = Database::getRows($sql, [
        User::getLoggedUserId()
    ]);
}

$page->assign('righe', $righe);

Form::mappingsAssignPost($righe, $action, $actionId, $tablePk, $mappings, $page);

$src = array(
    "writable" => false, // default è true
    "delete" => true,
    "rows" => $righe, // righe ritornate dal db
    "pk" => $tablePk, // chiave primaria tabella
    "inline" => true,
    "id" => 'dataTables', // Per attivare la gestione dataTables
    "custom-template" => false, // Per usare dei template custom (table.tpl e add.tpl)
    "fields" => array( // fields, usato solo se custom-template è false
        "titolo" => array(
            "label" => "Evento",
            "type" => "text",
            "writable" => false // true di default
        ),
        "user_surname" => array(
            "label" => "Cognome",
            "type" => "text",
            "writable" => false // true di default
        ),
        "user_name" => array(
            "label" => "Nome",
            "type" => "text",
            "writable" => false // true di default
        ),

        "user_email" => array(
            "label" => "Email",
            "type" => "text",
            "writable" => false // true di default
        ),
        "user_phone" => array(
            "label" => "Telefono",
            "type" => "text",
            "writable" => false // true di default
        ),
        "user_attachment" => array(
            "label" => "Attachment",
            "type" => "link",
            "others" => [
                "target" => "_blank"
            ]
        )
    )
);
if (User::isSuperUser())
    $eventi = $objEvento->allKeyPair("titolo", [
        "record_attivo" => 1
    ]);
else
    $eventi = $objEvento->allKeyPair("titolo", [
        "id_utente" => User::getLoggedUserId(),
        "record_attivo" => 1
    ]);
$page->assign("src", $src);
$page->assign("eventi", $eventi);