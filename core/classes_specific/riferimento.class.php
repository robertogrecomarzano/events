<?php

/**
 * Il riferimento rappresenta una serie di dati anagrafici (nome, indirizzo,
 * contatti) organizzati in una classe organica e riferibile a qualsiasi soggetto
 * che interagisce col sito o che fa parte dei suoi dati (azienda, utenti, eccetera).
 * Fornisce una serie di metodi per rappresentazioni organiche di questi dati,
 * necessita dell'apposita tabella su db. 
 * 
 * @author Roberto
 */
class Riferimento
{

    private $ente;

    private $sede;

    private $cap;

    private $citta;

    private $telefono;

    private $fax;

    private $web;

    private $email;

    public function __construct()
    {
        ;
    }

    public function getEmailLink()
    {}

    public function getNomeCognome($swapNome = false, $uppercaseCognome = false)
    {}

    /**
     * Ottiene tutti i riferimenti telefonici
     */
    public function getPhones()
    {}

    /**
     * Costruisce l'indirizzo completo
     */
    public function buildAddress()
    {
        // usare Language per cambiare a seconda del locale, o meglio ancora
        // la nazione dell'utente
    }

    /**
     * Ritorna il testo da inserire nei Pdf per la sezione Spett.le
     *
     * @param string $istat_provincia
     * @param string $tipo
     * @param int $id_riferimento_ente
     * @param array $opzioni,
     *            valori da inserire nella stampa, es. telefono=>true, web=>false
     * @return string
     */
    public function getSpettle($istat_provincia = null, $tipo = null, $id_riferimento_ente = null, $opzioni = array("telefono"=>false, "web"=>false, "email"=>false, "fax"=>false))
    {
        if (! empty($id_riferimento_ente))
            $rif = Database::getRow("SELECT * FROM riferimenti_enti r WHERE id_riferimento_ente = ?", array(
                $id_riferimento_ente
            ));
        elseif (! empty($istat_provincia))
            $rif = Database::getRow("SELECT * FROM riferimenti_enti r JOIN istat_comuni ON istat=istat_comune WHERE LEFT(istat,3)=?", array(
                $istat_provincia
            ));

        if (empty($rif))
            $rif = Database::getRow("SELECT * FROM riferimenti_enti");

        if (count($rif) > 0) {
            $this->ente = $rif['denominazione'];
            $this->sede = $rif['indirizzo'];
            if (! empty($rif["cap"]) && ! empty($rif['istat']))
                $this->sede .= "<br />" . $rif['cap'] . " " . Istat::getNomeComune($rif['istat']);
            if (! isset($opzioni["telefono"]) || $opzioni["telefono"])
                $this->telefono = $rif['telefono1'];
            if (! isset($opzioni["fax"]) || $opzioni["fax"])
                $this->fax = $rif['fax'];
            if (! isset($opzioni["email"]) || $opzioni["email"])
                $this->email = $rif['email'];
            if (! isset($opzioni["web"]) || $opzioni["web"])
                $this->web = $rif['web'];
        } else {
            $this->ente = str_replace(", ", "<br />", Config::$config["ente"]);
            $this->sede = Config::$config["sede"];
            if (! isset($opzioni["telefono"]) || $opzioni["telefono"])
                $this->telefono = Config::$config["telefono"];
            if (! isset($opzioni["fax"]) || $opzioni["fax"])
                $this->fax = Config::$config["fax"];
            if (! isset($opzioni["email"]) || $opzioni["email"])
                $this->email = Config::$config["email"];
            if (! isset($opzioni["web"]) || $opzioni["web"])
                $this->web = Config::$config["web"];
        }

        if (! empty($tipo))
            if (! isset($opzioni["email"]) || $opzioni["email"])
                $this->email = $this->getEmailExtra($tipo);

        return $this->render();
    }

    /**
     * Ritorna un indirizzo email usato specifico per tipologia documento, es.
     * invio delega "email_delega"
     *
     * @param string $tipo
     */
    public function getEmailExtra($tipo)
    {
        $email = Database::getField("SELECT email FROM config_mail WHERE tipo=?", array(
            $tipo
        ));
        if (empty($email))
            $email = Config::$config["email"];
        return $email;
    }

    /**
     * Ritorna l'output
     */
    private function render()
    {
        $Spett = <<<HTML
		<div style='float:right; width:60%;'>
Spett.<br />$this->ente<br />
$this->sede
HTML;

        if (! empty($this->telefono))
            $Spett .= "<br />tel.: " . $this->telefono;

        if (! empty($this->fax))
            $Spett .= "<br />fax: " . $this->fax;

        if (! empty($this->web))
            $Spett .= "<br />" . $this->web;

        if (! empty($this->email))
            $Spett .= "<br />" . $this->email;

        $Spett .= "</div><div style='clear: both; margin: 0pt; padding: 0pt; '></div>";

        return $Spett;
    }
}