<?php

/**
 * Classe che gestisce il protocollo informatico per ogni tipologia di documento
 * @author Roberto
 *
 * NB- tabelle Protocolli, Protocolli_head_foot
 * Protocolli (numero, sito, servizio)
 * Protocolli_head_foot contiene eventuali header e footer da associare ad un protocollo per un certo servizio oppure unico per tutti i servizi della regione
 */
class Protocollo
{

    public $sito = "";

    public $servizio = "";

    private $idServizio = 0;

    private $protocollo = "";

    private $header = "";

    private $footer = "";

    /**
     * Crea un oggetto Protocollo
     *
     * @param string $servizio
     * @param int $idSito
     */
    function Protocollo($servizio, $idSito = null)
    {
        if (empty($servizio))
            return null;

        $this->servizio = $servizio;

        $servizioRow = Servizi::get("servizio", $this->servizio);
        $this->idServizio = $servizioRow['id_servizio'];

        $hf = Database::getRow("SELECT * FROM protocolli_head_foot WHERE id_servizio=?", array(
            $this->idServizio
        ));

        $this->header = $hf['header'];
        $this->footer = $hf['footer'];
    }

    /**
     * Ritorna il protocollo
     *
     * @param bool $byYear,
     *            se true la numerazione riparte da 1 ogni anno
     * @return array(id,numero)
     */
    function get($byYear = true)
    {
        try {
            $db = Database::getInstance()->getDb();
            if (! $db->inTransaction())
                $db->beginTransaction();
            $params = array(
                $this->idServizio
            );
            $sql = "SELECT id_protocollo, numero FROM protocolli WHERE id_servizio=?";
            $prot = Database::getRow($sql, $params);
            if (is_null($prot))
                return null;

            $id = $prot['id_protocollo'];
            $numero = $prot['numero'];
            $userId = User::getLoggedUserId();

            // il protocollo riparte ogni anno da 1 se il parametro $byYear è true
            $newYear = Database::getField("SELECT YEAR(NOW())!=YEAR(MAX(data_operazione)) FROM protocolli WHERE id_protocollo=?", array(
                $id
            ));
            $numero = ($newYear && $byYear) ? 1 : ++ $numero;

            Database::query("UPDATE protocolli SET numero=$numero, data_operazione=NOW() WHERE id_protocollo=?", array(
                $id
            ));

            $numero = $this->header . $numero . $this->footer;

            // TODO: Da verificare questo controllo per evitare che venga generato un numero di protocollo già presente nel sistema per lo stesso servizio nel caso in cui si utilizzano header e footer differenti per anno
            if (! empty($this->header || ! empty($this->footer))) {
                $t = Database::getCount("protocolli_storico", "id_servizio=? AND protocollo=?", [
                    $this->idServizio,
                    $numero
                ]);
                if ($t > 0) {
                    if ($db->inTransaction())
                        $db->rollBack();
                    $page = Page::getInstance();
                    $page->addError("Errore nella generazione del protocollo: il numero <b>$numero</b> è già presente in archivio per il servizio " . $this->servizio . ".");
                    return null;
                }
            }

            Database::query("INSERT INTO protocolli_storico SET id_sito=?, id_servizio=?, protocollo=?, id_protocollo=?, data_operazione=NOW(), id_utente=?", array(
                $this->sito,
                $this->idServizio,
                $numero,
                $id,
                $userId
            ));
            if ($db->inTransaction())
                $db->commit();
            return array(
                "id" => $id,
                "numero" => $numero
            );
        } catch (Exception $ex) {
            if ($db->inTransaction())
                $db->rollBack();
            $page = Page::getInstance();
            $page->addError("Errore nella generazione del protocollo: " . $ex->getMessage());
            return null;
        }
    }

    /**
     * Inserisce il record per il nuovo servizio
     *
     * @param int $idServizio
     */
    static function addServizio($idServizio)
    {
        Database::query("INSERT INTO protocolli SET id_servizio=?, data_operazione=NOW()", array(
            $idServizio
        ));
        Database::query("INSERT INTO protocolli_head_foot SET id_servizio=?", array(
            $idServizio
        ));
    }
}