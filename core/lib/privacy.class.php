<?php

/**
 * Classe per la gestione della Privacy
 * @author Roberto
 *
 */
class Privacy extends OrmObj implements IPermissions
{

    private $id;

    private $destinatario;

    public $orm_table = "privacy";

    public $orm_pk_field = "id_privacy";

    /**
     * Costruttore
     *
     * @param string $destinatario
     * @param int $id
     */
    function __construct($destinatario = null, $id = null)
    {
        $this->destinatario = $destinatario;

        if (! empty($destinatario)) {
            $this->orm_pk_field = "destinatario";
            $this->orm_pk_value = $destinatario;
            $this->orm_get();

            $this->id = $this->orm_record->id_privacy;
        } else if (! empty($id)) {
            $this->id = $id;
            $this->orm_pk_value = $id;
            $this->orm_get();
        }
    }

    public function all($filter = null)
    {
        return $this->orm_all($filter);
    }

    public function allKeyPair($label, $filter = null)
    {
        return $this->orm_all_key_pair($label, $filter);
    }

    public function get($id)
    {
        $this->orm_pk_value = $id;
        return $this->orm_get();
    }

    /**
     * Ritorna true se l'utente è proprietario dell'oggetto
     */
    function isUserOwner()
    {}

    /**
     * Ritorna true se l'oggetto risulta visibile
     */
    function isReadable()
    {}

    /**
     * Ritorna true se l'oggetto risulta modificabile
     */
    function isWritable($groups)
    {}

    /**
     * Ritorna tutti gli oggetti simili
     *
     * @param int $id
     */
    static function getAll($id)
    {}

    /**
     * Ritorna la lista delle privacu
     *
     * @param array $filtro
     * @return array
     */
    function getList($filtro = [])
    {
        $rows = $this->all($filtro);

        foreach ($rows as &$row) {
            $row->ts_create_dmy = CustomDate::format($row->ts_create, "Y-m-d H:i:s", "d/m/Y H:i:s");
            $row->ts_delete_dmy = CustomDate::format($row->ts_delete, "Y-m-d H:i:s", "d/m/Y H:i:s");
            $row->ts_update_dmy = CustomDate::format($row->ts_update, "Y-m-d H:i:s", "d/m/Y H:i:s");
        }

        return $rows;
    }

    /**
     * Ritorna i motivi della singola privacy (se $this->id è impostato dal costruttore)
     * o di tutte le privacy
     *
     * @return array
     */
    function getMotivi($tipo = null)
    {
        $params = array();
        $sql = "SELECT * FROM
                privacy_motivi m JOIN
                privacy p USING(id_privacy) WHERE p.record_attivo=1";

        if ($this->id) {
            $sql .= " AND m.id_privacy = ?";
            $params[] = $this->id;
        }

        if (! empty($tipo)) {
            $sql .= " AND m.tipo=?";
            $params[] = $tipo;
        }

        $sql .= " ORDER BY titolo, motivo";
        $rows = Database::getRows($sql, $params);

        return $rows;
    }

    /**
     * Ritorna l'html contenente le info sulla privacy con i vari motivi
     * da inserire nel modulo di registrazione
     *
     * Intestazione
     * Motivi
     * Testo
     * Consensi
     * Piè pagina
     *
     * @param boolean $with_data,
     *            abilitare l'inserimento data
     * @return string
     */
    function getFormHtml($with_data = false, $id_destinatario = null, $isRegistrationForm = false)
    {
        $html = null;

        if ($isRegistrationForm) {
            $motivi = $this->getMotivi("motivo");

            foreach ($motivi as $m) {
                $attr = [
                    "label" => strip_tags($m["motivo"], "<a><b><br><u>")
                ];
                if ($m["is_required"] == 1)
                    $attr["required"] = "required";
                $html .= Form::check($attr);
            }
        }

        $consensi = $this->getMotivi("consenso");
        if ($id_destinatario)
            $risposte = $this->getConsensiRisposte($id_destinatario);
        $indice = 1;
        foreach ($consensi as $consenso) {

            $id = $consenso["id_motivo_privacy"];

            $attrAccetto = array(
                "type" => "radio",
                "id" => $indice ++,
                "name" => "privacy[" . $id . "]",
                "value" => true,
                "label" => Language::get("PRIVACY_ACCEPT")
            );

            $attrNonAccetto = array(
                "type" => "radio",
                "id" => $indice ++,
                "name" => "privacy[" . $id . "]",
                "value" => false,
                "label" => Language::get("PRIVACY_DO_NOT_ACCEPT")
            );

            $attr_calendar = array(
                "id" => "privacy_data[$id]",
                "name" => "privacy_data[$id]",
                "placeholder" => "gg/mm/aaaa"
            );

            if ($id_destinatario) {

                foreach ($risposte["new"] as $k => $v) {
                    if ($id == $v["id_motivo_privacy"]) {
                        if ($v["consenso"] == 1)
                            $attrAccetto["checked"] = "checked";
                        else
                            $attrNonAccetto["checked"] = "checked";
                        $attr_calendar["value"] = $v["data_consenso_dmy"];
                        break;
                    }
                }
            }

            $radioAccetto = Form::radio($attrAccetto);

            $radioNonAccetto = Form::radio($attrNonAccetto);

            $calendar = null;

            $html .= '<div class="well">';
            $html .= "<div style='float:left; margin-right:20px;'>$radioAccetto</div><div>$radioNonAccetto</div>";
            $html .= '<p>' . $consenso["motivo"] . '</p>';

            if ($with_data) {
                $calendar = Form::calendar($attr_calendar);
                $html .= "<div class='pull-right'><label>$calendar</label></div>";
            }

            $html .= "</div>";
        }

        return $html;
    }

    function getHistory($id_destinatario)
    {
        $html = null;

        if ($id_destinatario)
            $risposte = $this->getConsensiRisposte($id_destinatario);

        if (! empty($risposte["old"])) {
            $html .= "<h3>" . Language::get("PRIVACY_HISTORY") . "</h3>";

            $html .= "<table class='table no-footer dtr-inline'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>" . Language::get("PRIVACY_REASON") . "</th>";
            $html .= "<th>" . Language::get("PRIVACY_ANSWER") . "</th>";
            $html .= "<th>" . Language::get("PRIVACY_DATE") . "</th>";
            $html .= "</tr>";
            $html .= "</thead>";
            foreach ($risposte["old"] as $k => $v) {
                if ($v["consenso"] == 1)
                    $answer = Language::get("PRIVACY_ACCEPT");
                else
                    $answer = Language::get("PRIVACY_DO_NOT_ACCEPT");
                $html .= "<tr>";
                $html .= "<td>" . strip_tags($v["motivo"]) . "</td>";
                $html .= "<td>" . $answer . "</td>";
                $html .= "<td>" . $v["data_consenso_dmy"] . "</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        return $html;
    }

    /**
     * Ritorna l'html contenente le info sulla privacy con i vari motivi
     * da inserire nel modulo di registrazione
     *
     * Intestazione
     * Motivi
     * Testo
     * Consensi
     * Piè pagina
     *
     * @param boolean $with_data,
     *            abilitare l'inserimento data
     * @return string
     */
    function getFormPdf()
    {
        if (empty($this->orm_record))
            return null;

        $data = date("d/m/Y");

        $html = '<div style="text-align:center; padding-top:50px;"><b>Privacy</b></div>';

        $header = $this->orm_record->intestazione;
        $footer = $this->orm_record->pie_pagina;
        $body = $this->orm_record->testo;

        $html .= $header;

        $motivi = $this->getMotivi("motivo");
        $html .= "<ul>";
        foreach ($motivi as $m) {
            $html .= "<li>" . $m["motivo"] . "</li>";
        }
        $html .= "</ul>";

        $html .= $body;

        $consensi = $this->getMotivi("consenso");
        foreach ($consensi as $consenso) {
            $id = $consenso["id_motivo_privacy"];

            $html .= '<p>';
            $html .= $consenso["motivo"];
            $html .= "</p>";

            $attr = array(
                "type" => "checkbox"
            );

            $check = HTML::tag("input", $attr, Language::get("PRIVACY_ACCEPT"));
            $check2 = HTML::tag("input", $attr, Language::get("PRIVACY_DO_NOT_ACCEPT"));

            $html .= "<table><tr><td>$data<br />" . Language::get("SIGN") . "<br/><br/>_________________________</td><td class='right'>$check<br />$check2</td></tr></table>";
        }

        $html .= $footer;

        return $html;
    }

    /**
     * Ritorna la tabella ed il campo di riferimento in base alla tipologia del destinatario
     *
     * @return string[]
     */
    private function getTable()
    {
        $table = "privacy_tecnici";
        $field = "id_utente";
        $field2 = "";

        return array(
            "table" => $table,
            "field" => $field,
            "field2" => $field2
        );
    }

    /**
     * Registrazione di una nuova privacy policy
     *
     * @param array $post
     */
    function inserisciPrivacy($post)
    {
        try {

            $page = Page::getInstance();

            $db = Database::getDb();
            if (! $db->inTransaction())
                $db->beginTransaction();

            $sql = "INSERT INTO $this->orm_table SET 
                destinatario=?,
				titolo=?,
                intestazione=?,
                testo=?,
                pie_pagina=?,
                id_utente_create = ?";
            $params = [
                $post['destinatario'],
                $post["titolo"],
                $post["intestazione"],
                $post["testo"],
                $post["pie_pagina"],
                User::getLoggedUserId()
            ];

            Database::query($sql, $params);
            $idPrivacy = $db->lastInsertId();

            if ($db->inTransaction())
                $db->commit();

            $page->redirect("privacy/principale/$idPrivacy");
        } catch (PDOException $ex) {
            if ($db->inTransaction())
                $db->rollBack();
            $page->addWarning(Language::get("DB_ERROR", $ex->getMessage()));
        } catch (Exception $e) {
            if ($db->inTransaction())
                $db->rollBack();
            $page->addWarning(Language::get("ERROR_WITH_MESSAGE", $e->getMessage()));
        }
    }

    /**
     * Aggiornamento della privacy policy
     *
     * @param array $post
     */
    function modificaPrivacy($post)
    {
        $page = Page::getInstance();
        $idPrivacy = $this->id;

        try {

            $db = Database::getDb();
            $db->beginTransaction();

            $sql = "UPDATE $this->orm_table SET
                destinatario=?,
				titolo=?,
                intestazione=?,
                testo=?,
                pie_pagina=?,
                ts_update = NOW(),
                id_utente_update = ?
				WHERE $this->orm_pk_field = ?";
            $params = array(
                $post['destinatario'],
                $post["titolo"],
                $post["intestazione"],
                $post["testo"],
                $post["pie_pagina"],
                User::getLoggedUserId(),
                $idPrivacy
            );

            Database::query($sql, $params);

            if ($db->inTransaction())
                $db->commit();

            /**
             * Ricarico dopo l'update in tabella
             */
            $this->orm_get();

            $page->addMessages(Language::get("PRIVACY_POLICY_UPDATE_MSG"));
        } catch (PDOException $ex) {
            if ($db->inTransaction())
                $db->rollBack();
            $page->addWarning(Language::get("ABORT_TITLE") . $ex->getMessage());
        } catch (Exception $e) {
            if ($db->inTransaction())
                $db->rollBack();
            $page->addWarning(Language::get("ABORT_TITLE") . $e->getMessage());
        }
    }

    /**
     * Elimina una privacy policy
     */
    function eliminaPrivacy()
    {
        $page = Page::getInstance();

        try {

            $this->orm_record->record_attivo = 0;
            $this->orm_record->ts_delete = date("Y-m-d H:i:s");
            $this->orm_record->id_utente_delete = User::getLoggedUserId();
            $this->orm_save();

            Page::redirect("privacy", null, true);
        } catch (Exception $ex) {

            $page->addError(Language::get("ERROR"));
        }
    }

    /**
     * Elimina una privacy policy
     */
    function ripristinaPrivacy()
    {
        $page = Page::getInstance();

        try {

            $this->orm_record->record_attivo = 1;
            $this->orm_record->ts_restore = date("Y-m-d H:i:s");
            $this->orm_record->id_utente_restore = User::getLoggedUserId();
            $this->orm_save();

            Page::redirect("privacy/principale/" . $this->orm_record->id_privacy, null, true);
        } catch (Exception $ex) {

            $page->addError(Language::get("ERROR"));
        }
    }

    /**
     * Processa le risposte date dall'utente ai vari consensi proposti
     * e registra nell'apposita tabella
     */
    function insert($id_destinatario)
    {
        $rif = $this->getTable();
        $table = $rif["table"];
        $field = $rif["field"];
        $field2 = $rif["field2"];

        foreach ($_POST["privacy"] as $key => $value) {
            try {

                $data = empty($_POST["privacy_data[$key]"]) ? date("d/m/y H:i:s") : $_POST["privacy_data[$key]"];

                $sql = "INSERT INTO $table SET $field=?, id_motivo_privacy=?, consenso_data=STR_TO_DATE(?,'%d/%m/%Y %H:%i:%s'), consenso=?";
                $params = array(
                    $id_destinatario,
                    $key,
                    $data,
                    $value
                );

                Database::query($sql, $params);
            } catch (Exception $ex) {
                $page = Page::getInstance();
                $page->addError($ex->getMessage());
                return false;
            }
        }

        $this->createPdfLog($id_destinatario);

        return true;
    }

    /**
     * Processa le risposte date dall'utente ai vari consensi proposti
     * e registra nell'apposita tabella
     */
    function update($id_destinatario)
    {
        $rif = $this->getTable();
        $table = $rif["table"];
        $field = $rif["field"];

        Database::query("UPDATE $table SET record_attivo=0 WHERE $field=? AND record_attivo=1", array(
            $id_destinatario
        ));

        $this->insert($id_destinatario);

        $this->createPdfLog($id_destinatario);

        return true;
    }

    /**
     * Ritorna i motivi della singola privacy (se $this->id è impostato dal costruttore)
     * o di tutte le privacy
     *
     * @param int $id_destinatario
     * @return array
     */
    function getConsensiRisposte($id_destinatario)
    {
        $rif = $this->getTable();
        $table = $rif["table"];
        $field = $rif["field"];

        $params = array(
            $id_destinatario
        );
        $sql = "SELECT *,DATE_FORMAT(consenso_data,'%d/%m/%Y %H:%i:%s') AS data_consenso_dmy FROM
                privacy_motivi m JOIN
                privacy p USING(id_privacy) JOIN
                $table t USING(id_motivo_privacy)
                WHERE t.record_attivo=1 AND p.record_attivo=1 AND $field = ?";

        $sql .= " ORDER BY consenso_data DESC, motivo ASC";
        $rows = Database::getRows($sql, $params);

        $sql2 = "SELECT *,DATE_FORMAT(consenso_data,'%d/%m/%Y %H:%i:%s') AS data_consenso_dmy FROM
                privacy_motivi m JOIN
                privacy p USING(id_privacy) JOIN
                $table t USING(id_motivo_privacy)
                WHERE t.record_attivo=0 AND p.record_attivo=1 AND $field = ?";

        $sql2 .= " ORDER BY consenso_data DESC, motivo ASC";
        $rows2 = Database::getRows($sql2, $params);

        return array(
            "new" => $rows,
            "old" => $rows2
        );
    }

    /**
     * Ritorna il record del singolo motivo della privacy
     *
     * @param int $id
     * @return array
     */
    private function getMotivo($id)
    {
        return Database::getRow("SELECT * FROM privacy_motivi WHERE id_motivo_privacy=?", array(
            $id
        ));
    }

    /**
     * Ritorna il testo della normativa di riferimento ad una certa data.
     */
    function getNormativaRiferimento($data = null)
    {
        if (empty($data))
            $data = date("Y-m-d");

        return Database::getRow("SELECT testo FROM privacy_normative WHERE data_validita <= ?", array(
            $data
        ));
    }

    /**
     * Ritorna le privacy policy idonee alla copia
     * Al momento vengono ritornate tutte
     *
     * @return array
     */
    function getIdoneeCopia()
    {
        return $this->all();
    }

    /**
     * Copia una intera privacy policy, in modo da evitare di riscrivere tutte le informazioni da zero
     *
     * @param int $idPrivacyOld
     * @return int|NULL
     */
    static function copia($idPrivacyOld)
    {
        try {
            $db = Database::getDb();
            if (! $db->inTransaction())
                $db->beginTransaction();

            /**
             * Copia record principale della privacy
             */
            $table = "privacy";
            $key = "id_privacy";
            $fields = Database::getFieldsString($table, array(
                $key,
                "ts_update",
                "ts_delete",
                "ts_restore",
                "is_copia"
            ));

            Database::query("INSERT INTO $table ($fields,is_copia) SELECT $fields, 1 FROM $table WHERE $key=?", array(
                $idPrivacyOld
            ));
            $db = Database::getDb();
            $idPrivacy = $db->lastInsertId();

            $fields = Database::getFieldsString("privacy_motivi", array(
                "id_privacy",
                "id_motivo_privacy"
            ));
            Database::query("INSERT INTO privacy_motivi ($key,$fields) SELECT $idPrivacy, $fields FROM privacy_motivi WHERE $key=?", array(
                $idPrivacyOld
            ));

            Database::query("INSERT INTO privacy_copie SET id_privacy=?, id_privacy_old=?", array(
                $idPrivacy,
                $idPrivacyOld
            ));

            if ($db->inTransaction())
                $db->commit();
            return $idPrivacy;
        } catch (Exception $ex) {

            if ($db->inTransaction())
                $db->rollBack();
            $page = Page::getInstance();
            $page->addWarning($ex->getMessage());
            return null;
        }
    }

    /**
     * Generazione del pdf relativo alla privacy dell'utente, generato ad ogni conferma/modifica delle risposte ai vari consensi
     *
     * @param int $idUtente
     */
    public function createPdfLog($idUtente)
    {
        // error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_WARNING & ~ E_DEPRECATED);
        $html = null;
        $top = 40;
        $bottom = 30;
        $right = 15;
        $left = 15;
        $printHeader = true;
        $printFooter = true;

        $Serverpath = Config::$publicRoot . DS . "privacy" . DS . $this->destinatario;
        if (! is_dir($Serverpath))
            mkdir($Serverpath, 0755, TRUE);

        $logo = Config::$serverRoot . "/core/templates/img/logo.png";
        $logo = "<img src='$logo' max-height='90' />";
        $fontsize = 9;
        $font = "dejavusanscondensed";

        $path = $Serverpath . DS . $idUtente;
        if (! is_dir($path))
            mkdir($path, 0755, TRUE);

        $file = $path . DS . "privacy.pdf";

        if (file_exists($file))
            rename($file, $path . DS . "privacy_" . date("YmdHis") . ".pdf");

        if (PHP_VERSION >= 5.6) {

            $setting = array(
                'format' => 'A4',
                'margin_left' => $left,
                'margin_right' => $right,
                'margin_top' => $top,
                'margin_bottom' => $bottom,
                'margin_header' => 1,
                'margin_footer' => 2,
                'orientation' => 'P',
                'default_font' => $font,
                'default_font_size' => $fontsize
            );

            $pdf = new \Mpdf\Mpdf($setting);
        } else
            $pdf = new mPDF('', 'A4', $fontsize, $font, $left, $right, $top, $bottom, 1, 2);

        $pdf->SetDisplayMode('fullpage');
        $pdf->FontSize = 5;
        $pdf->simpleTables = true;

        $pdf->SetDisplayMode('fullpage');
        $pdf->FontSize = 6;
        $stylesheet = file_get_contents(Config::$serverRoot . DS . "pdf" . DS . "style.css");
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->simpleTables = true;
        $pdf->AliasNbPages('[pagetotal]');

        $privacyData = $this->get($id);

        $html .= $privacyData->intestazione;

        $motivi = $this->getMotivi("motivo");
        foreach ($motivi as $m)
            $html .= $m["motivo"] . "<br />";

        $html .= $privacyData->testo;

        $consensi = $this->getConsensiRisposte($idUtente);
        foreach ($consensi["new"] as $consenso) {
            if ($consenso["consenso"] == 1)
                $answer = Language::get("PRIVACY_ACCEPT");
            else
                $answer = Language::get("PRIVACY_DO_NOT_ACCEPT");
            $html .= '<p>';
            $html .= $consenso["motivo"];
            $html .= $answer;
            $html .= "</p>";
        }

        $html .= $privacyData->pie_pagina;

        // ------
        // Header
        // ------
        if ($printHeader) {
            $titolo = Config::$config["denominazione"];
            $header = "<div style='border-bottom: 5px double #000000;'><div style='padding-top:30px; float:left; width:75%;'><strong>$titolo</strong></div><div style='padding-top:30px; float:right; width:25%; text-align:right;'>$logo</div></div>";
            $pdf->SetHTMLHeader($header);
        }

        // ------
        // Footer
        // ------
        if ($printFooter) {
            if (empty($footer))
                $footer = "<div style='float:left; width:25%'>{DATE j/m/Y}</div><div style='float:left; width:40%;' class='center'> PREVENTIVO NUMERO $idPreventivo </div><div style='float:right; text-align:right; width:25%;'>Pag. {PAGENO}/[pagetotal]</div>";
            $pdf->SetHTMLFooter($footer);
        }

        $pdf->WriteHTML($html);

        $pdf->Output($file, 'F');
    }
}

