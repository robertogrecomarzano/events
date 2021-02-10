<?php

/**
 * Classe per gestire le comunicazioni da verso gli utenti tramite mail
 * e generazione del pdf relativo
 * @author Roberto
 *
 */
class Message
{

    private $subject;

    private $model;

    private $object;

    private $pdf;

    private $title;

    private $idOggetto;

    private $barcode_start;

    private $destinatario;

    private $destinatario_email;

    private $params;

    private $message;

    private $allegati;

    /**
     * Crea un messaggio specifico per modello, salva l'eventuale Pdf ed invia la mail
     *
     * @param string $model
     * @param int $idOggetto
     * @param string $subject
     * @param string $destinatario
     * @param string $destinatario_email
     * @param array $params
     * @param string $message
     * @param string|array $allegati
     */
    public function __construct($model, $idOggetto, $subject, $destinatario = null, $destinatario_email = null, $params = array(), $message = null, $allegati = null)
    {
        $this->model = $model;
        $this->subject = empty($subject) ? Config::$config["sitename"] : $subject;

        $this->idOggetto = $idOggetto;
        $this->params = $params;
        $this->message = $message;
        $this->allegati = ! is_array($allegati) ? [
            $allegati
        ] : $allegati;

        if (! empty($destinatario) && ! empty($destinatario_email)) {
            $this->destinatario = $destinatario;
            $this->destinatario_email = $destinatario_email;
        }
    }

    /**
     * Crea il corpo della mail, usando i template
     */
    public function render()
    {
        $info = array(
            "regione" => Config::$config["denominazione"],
            "denominazione" => Config::$config["denominazione"],
            "ufficio" => Config::$config["ufficio"],
            "ente" => Config::$config["ente"],
            "sede" => Config::$config["sede"],
            "tel" => Config::$config["telefono"],
            "fax" => Config::$config["fax"],
            "email" => Config::$config["email"],
            "web" => Config::$config["sito_web"]
        );
        $page = Page::getInstance();

        $header = null;
        $footer = null;

        $pageMailHeader = new Page();
        $pageMailHeader->template = Config::$serverRoot . DS . "core" . DS . "templates" . DS . "mail" . DS . "header_mail.tpl";
        $header = $pageMailHeader->render([
            "info" => $info,
            "logo_base64" => base64_encode(file_get_contents(Config::$serverRoot . DS . "core" . DS . "templates" . DS . "img" . DS . "logo.png")),
            "params" => $this->params
        ]);

        $pageMailFooter = new Page();
        $pageMailFooter->template = Config::$serverRoot . DS . "core" . DS . "templates" . DS . "mail" . DS . "footer_mail.tpl";
        $footer = $pageMailFooter->render([
            "info" => $info,
            "params" => $this->params
        ]);

        $pageMail = new Page();
        $pageMail->template = Config::$serverRoot . DS . "core" . DS . "templates" . DS . "mail" . DS . $this->model . ".tpl";

        $this->barcode_start = $this->params["barcode_start"];
        $this->object = $this->params["object"];
        $this->pdf = $this->params["pdf"];
        $this->title = $this->params["title"];

        if (! empty($this->message))
            $page->addMessages($this->message);

        if (! empty($this->pdf)) {
            $pdf = Config::$urlRoot . "/pdf/" . $this->pdf . "/" . $this->idOggetto;
            $page->addMessages("<a href='$pdf' title='Pdf' target='_blank'>" . Language::get("PRINT") . "</a> " . $this->title);
        }
        if (! empty($this->object)) {
            $edit = Config::$urlRoot . "/p/" . $this->object . "/principale/" . $this->idOggetto;
            $page->addMessages("<a href='$edit' title='" . Language::get("LOGIN") . "' target='_blank'>" . Language::get("SHOW") . "</a> " . $this->title);
        }

        $retvalue = null;

        if (! file_exists($pageMail->template))
            $page->addWarning(Language::get("MAIL_ERROR_TEMPLATE", array(
                $pageMail->template
            )));
        else {

            if (RegExp::checkEmail($this->destinatario_email) && Config::$config["mail"]) {

                $message = $pageMail->render(array(
                    "info" => $info,
                    "barcode" => $this->barcode_start . Security::maskId($this->idOggetto),
                    "sitename" => Config::$config["sitename"],
                    "utente" => array(
                        "utente" => $this->destinatario,
                        "email" => $this->destinatario_email
                    ),
                    "params" => $this->params
                ));
                $retvalue = Mail::sendPHPMailer($this->destinatario_email, $this->subject, $header . $message . $footer, $header . $message . $footer, $this->allegati);

                if ($retvalue['SUCCESS'] == "FALSE")
                    $page->addWarning(Language::get("MAIL_ERROR", array(
                        $this->destinatario_email,
                        Config::$config["web"]
                    )));
                else
                    $page->addMessages(Language::get("EMAIL_PROGRESS_MESSAGE", array(
                        $this->destinatario_email,
                        Config::$config["web"]
                    )));

                $retvalue["message"] = $message;
                return $retvalue;
            }
        }
        return $retvalue;
    }
}