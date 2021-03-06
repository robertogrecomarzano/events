<?php

/**
 *
 * @author Roberto
 *        
 */
class Evento extends OrmObj
{

    public $orm_table = "eventi";

    public $orm_pk_field = "id_evento";

    /**
     * Costruttore
     */
    public function __construct()
    {
        ;
    }

    public function all($filter = null)
    {
        if (! empty($filter))
            return $this->orm_all($filter);
        return $this->orm_all([
            "record_attivo" => "1"
        ]);
    }

    public function allKeyPair($label, $filter = null, $order = null)
    {
        if (! empty($filter))
            return $this->orm_all_key_pair($label, $filter, $order);
        return $this->orm_all_key_pair($label, [
            "record_attivo" => "1"
        ], $order);
    }

    public function get($id)
    {
        $this->orm_pk_value = $id;
        return $this->orm_get();
    }

    /**
     * Ritorna l'evento a partire del nome usato nell'url
     *
     * @param string $nome
     * @return array|NULL
     */
    public function getParametriEventoByNome($nome = null)
    {
        if ($nome == null) {
            $url = strtok($_SERVER["REQUEST_URI"], '?');
            $nome = end(explode("/", $url));
        }

        $evento = reset($this->all([
            "nome" => $nome,
            "record_attivo" => "1"
        ]));

        $evento->sessioni = $this->getSessioni($evento->id_evento);

        $evento->data_dmy = CustomDate::format($evento->data, "Y-m-d", "d/m/Y");

        if (Config::$defaultLocale != $evento->lingua)
            setlocale(LC_TIME, $evento->lingua);
        $evento->data_extended = strftime("%e %B %Y", strtotime($evento->data_inizio));
        if ($evento->data_inizio != $evento->data_fine)
            $evento->data_extended .= " - " . strftime("%e %B %Y", strtotime($evento->data_fine));

        if (count($evento->sessioni) == 1) {
            $evento->ora_inizio = $evento->sessioni[0]["ora_inizio"];
            $evento->ora_fine = $evento->sessioni[0]["ora_fine"];
        }

        if (Config::$defaultLocale != $evento->lingua)
            setlocale(LC_TIME, Config::$defaultLocale);
        /**
         * PARAMETRI
         */
        $evento->logo = Config::$urlRoot . "/" . "public" . "/" . $evento->id_evento . "/" . $evento->logo;
        $pdf = Config::$urlRoot . "/" . "public" . "/" . $evento->id_evento . "/" . $evento->pdf;

        switch ($evento->lingua) {
            case "it_IT":
                $evento->checkPresaVisione = Form::check([
                    "label" => "Ho letto ed accettato l'<a href='$pdf' target='_blanck'>informativa sulla privacy</a>",
                    "required" => "required"
                ]);
                break;
            case "en_US":
                $evento->checkPresaVisione = Form::check([
                    "label" => "I have read and accepted the <a href='$pdf' target='_blanck'>privacy policy</a>",
                    "required" => "required"
                ]);
                break;
        }

        if (! empty($evento->privacy_registrazione_video))
            $evento->checkRegistrazione = Form::check([
                "label" => strip_tags($evento->privacy_registrazione_video, "<b><u><i>"),
                "required" => "required"
            ]);

        return $evento;
    }

    /**
     * Update evento
     *
     * @param int $idEvento
     * @param array $params
     * @return number|NULL
     */
    public function update($id, $params)
    {
        $this->orm_pk_value = $id;
        $this->orm_get();

        foreach ($params as $field => $value)
            $this->orm_record->$field = $value;

        $ret = $this->orm_save();

        if ($ret)
            return $this->orm_pk_value;

        return null;
    }

    /**
     * Ritorna le sessioni di un evento
     *
     * @param int $idEvento
     * @return array|NULL
     */
    function getSessioni($idEvento)
    {
        return Database::getRows("SELECT *,DATE_FORMAT(data,'%d/%m/%Y') AS data_dmy FROM eventi_sessioni WHERE id_evento=? AND record_attivo=1 ORDER BY data ASC", [
            $idEvento
        ]);
    }

    /**
     * Ritorna l'ultima sessione dell'evento
     *
     * @param int $idEvento
     * @return array|NULL|mixed
     */
    function getLastSessione($idEvento)
    {
        return Database::getRow("SELECT * FROM eventi_sessioni WHERE id_evento=? AND record_attivo=1 ORDER BY data DESC LIMIT 1", [
            $idEvento
        ]);
    }

    function getList($isAttivo = true)
    {
        $where = "";
        if ($isAttivo)
            $where = "HAVING DATE(NOW()) <=MIN(s.data) ";

        $sql = "SELECT e.* FROM eventi e JOIN eventi_sessioni s USING(id_evento) WHERE e.record_attivo=1 AND s.record_attivo=1
                GROUP BY e.id_evento 
                $where
                ORDER BY DATA ASC";
        return Database::getRows($sql);
    }

    function registraUtente($post, $evento)
    {
        try {

            $page = Page::getInstance();

            $db = Database::getDb();
            $db->beginTransaction();

            $surname = trim($post["user_surname"]);
            $name = trim($post["user_name"]);
            $email = trim($post['user_email']);

            $result = false;

            switch ($evento->template) {
                case "basic":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_group=?,
                            user_group_other=?,
                            user_organization=?";
                    $parameters = array(
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_group"],
                        trim($post["user_group_other"]),
                        trim($post["user_organization"])
                    );
                    $result = true;
                    break;
                case "basicit":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_group=?,
                            user_group_other=?,
                            user_business_name=?";
                    $parameters = array(
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_group"],
                        trim($post["user_group_other"]),
                        trim($post["user_business_name"])
                    );
                    $result = true;
                    break;
                case "intermediate":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_country=?,
                            user_organization=?,
                            user_group=?,
                            user_group_other=?,
                            user_policy_maker_institution=?,
                            user_policy_maker_department=?,
                            user_policy_maker_position=?,
                            user_hear=?,
                            user_hear_other=?";
                    $parameters = array(
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                        $post["user_organization"],
                        implode(",", $post["user_group"]),
                        trim($post["user_group_other"]),
                        $post["user_policy_maker_institution"],
                        $post["user_policy_maker_department"],
                        $post["user_policy_maker_position"],
                        implode(",", $post["user_hear"]),
                        trim($post["user_hear_other"])
                    );
                    $result = true;
                    break;
                case "international":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_group=?,
                            user_group_other=?,
                            user_organization=?,
                            user_position=?";
                    $parameters = array(
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_group"],
                        trim($post["user_group_other"]),
                        trim($post["user_organization"]),
                        trim($post["user_position"])
                    );
                    $result = true;
                    break;
                case "preadvanced":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_gender=?,
                            user_country=?,
                            user_age=?,
                            user_organization=?,
                            user_group=?,
                            user_group_other=?,
                            user_sector=?,
                            user_sector_other=?";
                    $parameters = [
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_gender"],
                        Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                        $post["user_age"],
                        trim($post["user_organization"]),
                        $post["user_group"],
                        trim($post["user_group_other"]),
                        $post["user_sector"],
                        trim($post["user_sector_other"])
                    ];
                    $result = true;
                    break;

                case "advanced":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_gender=?,
                            user_nationality=?,
                            user_age=?,
                            user_phone=?,
                            user_group=?,
                            user_group_other=?,
                            user_policy_maker_institution=?,
                            user_policy_maker_department=?,
                            user_policy_maker_position=?,
                            user_international_organisation_institution=?,
                            user_international_organisation_department=?,
                            user_international_organisation_position=?,
                            user_topic=?,
                            user_hear=?,
                            user_hear_other=?";
                    $parameters = [
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_gender"],
                        Istat::getDenominazioneNazioneFromCode($post["user_nationality"]),
                        $post["user_age"],
                        $post["user_phone"],
                        implode(",", $post["user_group"]),
                        trim($post["user_group_other"]),
                        $post["user_policy_maker_institution"],
                        $post["user_policy_maker_department"],
                        $post["user_policy_maker_position"],
                        $post["user_international_organisation_institution"],
                        $post["user_international_organisation_department"],
                        $post["user_international_organisation_position"],
                        implode(",", $post["user_topic"]),
                        implode(",", $post["user_hear"]),
                        trim($post["user_hear_other"])
                    ];
                    $result = true;
                    break;

                case "call":

                    /**
                     * Salvataggio eventuale allegato
                     */

                    $directory = Config::$serverRoot . DS . "public" . DS . "call";
                    if (! is_dir($directory))
                        mkdir($directory, 0755, TRUE);

                    $upload = new Upload(null, $evento->nome, false, "$email", "user_attachment", "filedesc", "dettaglio", array(
                        ".pdf"
                    ));
                    $ret = $upload->save();

                    if ($ret) {
                        $rowsUpload = $upload->getRows("dettaglio='$email' AND record_attivo=1");
                        if (count($rowsUpload) > 0) {
                            $row = end($rowsUpload);

                            $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_job_position=?,
                            user_institution=?,
                            user_country=?,
                            user_address=?,
                            user_phone=?,
                            user_note=?,
                            user_attachment=?";
                            $parameters = [
                                $evento->id_evento,
                                $evento->nome,
                                $surname,
                                $name,
                                $email,
                                $post["user_job_position"],
                                $post["user_institution"],
                                Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                                $post["user_address"],
                                $post["user_phone"],
                                $post["user_note"],
                                Config::$urlRoot . "/public/" . $evento->nome . "/" . $row["filename"]
                            ];

                            $result = true;
                        }
                    }
                    break;

                case "callfull":

                    /**
                     * Salvataggio eventuale allegato
                     */

                    $directory = Config::$serverRoot . DS . "public" . DS . "call";
                    if (! is_dir($directory))
                        mkdir($directory, 0755, TRUE);

                    $upload = new Upload(null, $evento->nome, false, "$email", "user_attachment", "filedesc", "dettaglio", array(
                        ".doc",
                        '.docx'
                    ));
                    $ret = $upload->save();

                    if ($ret) {
                        $rowsUpload = $upload->getRows("dettaglio='$email' AND record_attivo=1");
                        if (count($rowsUpload) > 0) {
                            $row = end($rowsUpload);

                            $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_gender=?,
                            user_email=?,
                            user_job_position=?,
                            user_institution=?,
                            user_country=?,
                            user_address=?,
                            user_phone=?,
                            user_title=?,
                            user_authors=?,
                            user_session=?,
                            user_presentation=?,
                            user_attachment=?";
                            $parameters = [
                                $evento->id_evento,
                                $evento->nome,
                                $surname,
                                $name,
                                $post["user_gender"],
                                $email,
                                $post["user_job_position"],
                                $post["user_institution"],
                                Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                                $post["user_address"],
                                $post["user_phone"],
                                $post["user_title"],
                                $post["user_authors"],
                                $post["user_session"],
                                $post["user_presentation"],
                                Config::$urlRoot . "/public/" . $evento->nome . "/" . $row["filename"]
                            ];

                            $result = true;
                        }
                    }
                    break;

                case "expert":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_title=?,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_gender=?,
                            user_country=?,
                            user_phone=?,
                            user_organization=?,
                            user_organization_acronym=?,
                            user_institution=?,
                            user_position=?";
                    $parameters = [
                        $evento->id_evento,
                        $evento->nome,
                        $post["user_title"],
                        $surname,
                        $name,
                        $email,
                        $post["user_gender"],
                        Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                        $post["user_phone"],
                        $post["user_organization"],
                        $post["user_organization_acronym"],
                        $post["user_institution"],
                        $post["user_position"]
                    ];
                    $result = true;
                    break;

                case "experttwo":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_title=?,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_gender=?,
                            user_country=?,
                            user_organization=?,
                            user_position=?,
                            user_group=?,
                            user_group_other=?";
                    $parameters = [
                        $evento->id_evento,
                        $evento->nome,
                        $post["user_title"],
                        $surname,
                        $name,
                        $email,
                        $post["user_gender"],
                        Istat::getDenominazioneNazioneFromCode($post["user_country"]),
                        $post["user_organization"],
                        $post["user_position"],
                        implode(",", $post["user_group"]),
                        trim($post["user_group_other"])
                    ];
                    $result = true;
                    break;

                case "baseinnovazioneit":
                    $sql = "INSERT INTO utenti SET
                            id_evento=?,
                            evento=?,
                            record_attivo=1,
                            user_surname=?,
                            user_name=?,
                            user_email=?,
                            user_group=?,
                            user_group_other=?,
                            user_business_name=?";
                    $parameters = array(
                        $evento->id_evento,
                        $evento->nome,
                        $surname,
                        $name,
                        $email,
                        $post["user_group"],
                        trim($post["user_group_other"]),
                        trim($post["user_business_name"])
                    );
                    $result = true;
                    break;
            }

            if ($result) {

                /**
                 * Registrazione utente database
                 */
                $res = Database::insert($sql, $parameters);

                if ($res != null) {

                    $db = Database::getDb();
                    $idUtente = $db->lastInsertId();

                    /**
                     * Registrazione sessioni utente
                     */
                    if (! isset($post["sessions"]) || empty($post["sessions"])) {
                        foreach ($this->getSessioni($evento->id_evento) as $sessione)
                            if ($this->isRegistrazioneSessionePossibile($sessione))
                                $sessioni[] = $sessione["id_sessione"];
                    } else
                        $sessioni = $post["sessions"];

                    $sessioni = array_values($sessioni);

                    foreach ($sessioni as $id_sessione)
                        Database::query("INSERT INTO eventi_sessioni_utenti SET id_evento=?, id_sessione=?, id_utente=?", [
                            $evento->id_evento,
                            $id_sessione,
                            $idUtente
                        ]);

                    /**
                     * Invio mail di conferma registrazione
                     */
                    $nominativo = "$surname $name";
                    $mail_template = "schedule__register";
                    $allegati = null;
                    if ($evento->zoom_send_link_on_register) {
                        $mail_template = "schedule__register_with_link";
                        $allegati = [
                            Config::$publicRoot . DS . "tutorial_zoom.pdf"
                        ];
                    }

                    $subject = ! empty($evento->subject) ? $evento->subject : $evento->titolo;
                    $msg = new Message($mail_template, null, $subject, $nominativo, $email, [
                        "event" => json_decode(json_encode($evento), true)
                    ], null, $allegati);

                    $msg->render();
                    $db->commit();

                    unset($_POST);
                }
            } else
                $page->addError("An error occurred and registration was not completed");
        } catch (Exception $ex) {
            $page->addError($ex->getMessage());
            $db->rollBack();
        }
    }

    /**
     * Determina se per l'evento sono ancora aperte le registrazioni
     * Al massimo entro la fine dell'ultima sessione
     *
     * @param object $evento
     * @return boolean
     */
    function isRegistrazionePossibile($evento)
    {
        if (empty($evento))
            return false;

        $lastSession = $this->getLastSessione($evento->id_evento);

        $data = date_create_from_format("Y-m-d H:i", $lastSession["data"] . " " . $lastSession["ora_fine"]);
        return CustomDate::isPrecedente(date("Y-m-d H:i"), "Y-m-d H:i", date_format($data, "Y-m-d H:i"), "Y-m-d H:i");
    }

    /**
     * Determina se per la singola sessione sono ancora aperte le registrazioni
     * Al massimo entro l'ora di fine della sessione
     *
     * @param array $sessione
     * @return boolean
     */
    function isRegistrazioneSessionePossibile($sessione)
    {
        if (empty($sessione))
            return false;

        $data = date_create_from_format("Y-m-d H:i", $sessione["data"] . " " . $sessione["ora_fine"]);
        return CustomDate::isPrecedente(date("Y-m-d H:i"), "Y-m-d H:i", date_format($data, "Y-m-d H:i"), "Y-m-d H:i");

        // $data = date_create_from_format("Y-m-d H:i", $sessione["data"] . " " . $sessione["ora_inizio"]);
        // $data_inizio_add_1_hour = date_add($data, date_interval_create_from_date_string("+1 hour"));
        // return CustomDate::isPrecedente(date("Y-m-d H:i"), "Y-m-d H:i", date_format($data_inizio_add_1_hour, "Y-m-d H:i"), "Y-m-d H:i");
    }

    /**
     * Determina se per l'evento le registrazioni sono temporaneamente sospese per consentire la modifica all'evento stesso
     *
     * @param object $evento
     * @return boolean
     */
    function isWritable($evento)
    {
        if ($evento->is_offline)
            return [
                "writable" => false,
                "message" => $evento->lingua == "it_IT" ? "Attenzione, la registrazione all'evento è momentaneamente sospesa.<br />Si prega di riprovare più tardi. Grazie" : "Attention, registration for the event is temporarily suspended.<br/>Please try again later. Thank you "
            ];

        return [
            "writable" => true
        ];
    }
}

