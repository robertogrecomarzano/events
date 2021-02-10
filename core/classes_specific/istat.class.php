<?php

/**
 * Classe istat per la gestione della tabella comuni
 * 
 * @author Roberto
 *
 */
class Istat extends OrmObj
{

    public $orm_table = "istat_comuni";

    public $orm_pk_field = "id";

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

    public function allKeyPair($label, $filter = null)
    {
        if (! empty($filter))
            return $this->orm_all_key_pair($label, $filter);
        return $this->orm_all_key_pair($label, [
            "record_attivo" => "1"
        ]);
    }

    public function get($id)
    {
        $this->orm_pk_value = $id;
        return $this->orm_get();
    }

    /**
     * Ritorna il record della regione partendo dal codice
     *
     * @param string $codRegione
     * @return array
     */
    public static function getDenominazioneRegioneFromCode($codRegione)
    {
        $sql = "SELECT * FROM istat_regioni WHERE istat_regione = ?";
        return Database::getRow($sql, array(
            $codRegione
        ));
    }

    /**
     * Ritorna la denominazione della nazione partendo dal codice
     *
     * @param string $codice
     * @return string
     */
    public static function getDenominazioneNazioneFromCode($codice, $lingua = "en_US")
    {
        $sql = "SELECT denominazione_$lingua FROM istat_nazioni_multilingua WHERE codice_istat_lungo = ?";
        return Database::getField($sql, array(
            $codice
        ));
    }

    /**
     * Ritorna il record nazione partendo dal nome
     *
     * @param string $name
     * @return array
     */
    public static function getNazioneFromName($name, $lingua = "en_US")
    {
        $sql = "SELECT * FROM istat_nazioni_multilingua WHERE denominazione_$lingua  = ?";
        return Database::getRow($sql, array(
            $name
        ));
    }

    /**
     * Ritorna il codice belfiore del comune partendo dal codice istat
     *
     * @param string $istat
     * @return string
     */
    public static function getBelfiore($istat)
    {
        $sql = "SELECT codice_comune FROM istat_comuni WHERE istat_comune = ?";
        return Database::getField($sql, array(
            $istat
        ));
    }

    /**
     * Ritorna il nome del comune partendo dal codice istat
     *
     * @param string $istat
     * @return string
     */
    public static function getNomeComune($istat)
    {
        if (empty($istat))
            return "";

        $sql = "SELECT CONCAT(citta,' (',provincia,')') FROM istat_comuni JOIN istat_province ON codice_provincia=codice_prov WHERE istat_comune=?";
        return Database::getField($sql, array(
            $istat
        ));
    }

    /**
     * Ritorna la riga relativa al comune
     *
     * @param $istat string
     * @return array
     */
    public static function getComune($istat)
    {
        $sql = "SELECT * 
        FROM istat_comuni i 
        JOIN istat_province p ON i.codice_provincia = p.codice_prov
		WHERE istat_comune = ?";
        return Database::getRow($sql, [
            $istat
        ]);
    }

    /**
     * Ritorna l'array dei comuni di una provincia
     *
     * @param string $prov
     * @param boolean $ass
     * @return array
     */
    public static function getComuni($prov, $ass = true)
    {
        $comuni = array();

        $sql = "SELECT DISTINCT citta,istat_comune FROM istat_comuni WHERE codice_provincia=? ORDER BY citta ASC";
        $res = Database::getRows($sql, [
            $prov
        ]);

        foreach ($res as $row) {
            if (! $ass)
                array_push($comuni, $row['istat_comune']);
            else
                $comuni[$row['istat_comune']] = $row['citta'];
        }
        return $comuni;
    }

    /**
     * Ritorna l'array delle province ( [0]=AA [1]=BB etc.)
     *
     * @param bool $ass
     * @param string $regione
     * @return multitype:unknown
     */
    public static function getProvince($ass = true, $regione = null)
    {
        $params = array();
        $sqlRegione = null;
        if (! empty($regione)) {
            $sqlRegione = "AND codice_regione=?";
            $params = array(
                $regione
            );
        }
        $sql = "SELECT DISTINCT codice_prov,sigla FROM istat_comuni i LEFT JOIN istat_province p ON codice_provincia=codice_prov WHERE codice_prov IS NOT NULL $sqlRegione ORDER BY sigla ASC";
        $rows = Database::getRows($sql, $params, $ass ? PDO::FETCH_KEY_PAIR : PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Ritorna l'array delle regioni
     *
     * @param bool $ass
     * @return multitype:unknown
     */
    public static function getRegioni($ass = true)
    {
        $sql = "SELECT DISTINCT istat_regione, nome_lungo FROM istat_regioni ORDER BY nome_lungo ASC";
        $rows = Database::getRows($sql, null, $ass ? PDO::FETCH_KEY_PAIR : PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Ritorna la riga relativa al comune dalla tabella istat_varie
     *
     * @param $istat string
     * @return array
     */
    public static function getVarie($istat)
    {
        $sql = "SELECT *
        FROM istat_varie i
        WHERE istat = ?";
        return Database::getRow($sql, [
            $istat
        ]);
    }

    /**
     * Ritorna l'array dei Continenti
     *
     * @param bool $ass
     * @return array
     */
    public static function getContinenti($ass = true)
    {
        $sql = "SELECT DISTINCT id_continente,continente FROM istat_nazioni_multilingua ORDER BY continente ASC";
        $rows = Database::getRows($sql, null, $ass ? PDO::FETCH_KEY_PAIR : PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Ritorna l'array delle Aree con possibilità di filtro per continente
     *
     * @param boolean $ass
     * @param int $id_continente
     * @return array
     */
    public static function getAree($ass = true, $id_continente = null)
    {
        $params = null;
        if (! empty($id_continente)) {
            $where = "WHERE id_continente=?";
            $params[] = $id_continente;
        }
        $sql = "SELECT DISTINCT id_area,area FROM istat_nazioni_multilingua $where ORDER BY area ASC";
        $rows = Database::getRows($sql, $params, $ass ? PDO::FETCH_KEY_PAIR : PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Ritorna l'array delle Aree con possibilità di filtro per continente
     *
     * @param boolean $ass
     * @param int $id_continente
     * @return array
     */
    public static function getNazioni($ass = true, $lingua = "en_US", $id_continente = null, $id_area = null)
    {
        $params = null;
        $where = null;

        if (! empty($id_continente)) {
            $where .= "AND id_continente=?";
            $params[] = $id_continente;
        }
        if (! empty($id_area)) {
            $where .= "AND id_area=?";
            $params[] = $id_area;
        }

        $sql = "SELECT DISTINCT codice_istat_lungo,denominazione_$lingua FROM istat_nazioni_multilingua WHERE 1=1 $where ORDER BY denominazione_$lingua ASC";
        $rows = Database::getRows($sql, $params, $ass ? PDO::FETCH_KEY_PAIR : PDO::FETCH_ASSOC);
        return $rows;
    }
}