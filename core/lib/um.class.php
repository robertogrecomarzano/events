<?php

/**
 * Classe per gestire le unità di misura
 * con le varie conversioni
 * @author Roberto
 */
class Um
{

    private static $array = array(
        "peso" => array(
            "kg" => 1,
            "qli" => 100,
            "t" => 1000
        ),
        "volume" => array(
            "lt" => 1,
            "hl" => 100,
            "mc" => 1000
        ),
        "superficie" => array(
            "mq" => 1,
            "ha" => 10000
        ),
        "numero" => array(
            "u" => 1
        )
    );

    static function convert($valore, $from, $to)
    {
        if (empty($valore))
            return 0;
        
        $from = trim($from);
        
        if (empty($from)) {
            return $valore;
        }
        
        if (is_numeric($from))
            $from = Um::getSigla($from);
        
        if (is_numeric($to))
            $to = Um::getSigla($to);
        
        $from = strtolower($from);
        $to = strtolower($to);
        $gruppoFrom = strtolower(Um::getGruppo($from));
        $gruppoTo = strtolower(Um::getGruppo($to));
        
        if ($gruppoFrom != $gruppoTo)
            return false;
        
        $check = array_key_exists($from, self::$array[$gruppoFrom]) && array_key_exists($to, self::$array[$gruppoTo]);
        if (! $check)
            return false;
        
        if ($from == $to)
            return $valore;
        
        $from_v = self::$array[$gruppoFrom][$from];
        $to_v = self::$array[$gruppoTo][$to];
        
        $valore = $valore * $from_v; // in kg [ottento il corrispondente nell'unita misura + piccola del gruppo, es Kg, mq, l]
        $valore = $valore / $to_v; // in qli o altro
        
        return $valore;
    }

    /**
     * Ottiene il gruppo relativo alla unità di misura,
     * esempio Peso, Superficie ...
     *
     * @param string $sigla
     * @return string
     */
    private static function getGruppo($sigla)
    {
        return Database::getField("SELECT gruppo FROM unita_misura u WHERE sigla=?", array(
            $sigla
        ));
    }

    
    /**
     * Ottiene la sigla dell'unita di misura
     * @param int $id
     * @return string
     */
    private static function getSigla($id)
    {
        return Database::getField("SELECT sigla FROM unita_misura u WHERE id=?", array(
            $id
        ));
    }

    /**
     * Ottiene il codice dell'unita di misura [id]
     *
     * @param
     *            string sigla
     * @return int
     */
    public static function getIdFromSigla($sigla)
    {
        return Database::getField("SELECT id FROM unita_misura u WHERE sigla=?", array(
            $sigla
        ));
    }

    /**
     * Ottiene la sigla dell'unita di misura
     * 
     * @param
     *            int id
     * @return string
     */
    public static function getSiglaFromId($id)
    {
        return Database::getField("SELECT sigla FROM unita_misura u WHERE id=?", array(
            $id
        ));
    }

    /**
     * Ottiene la riga dell'Unita di Misura, partendo dalla sigla
     *
     * @param string $sigla
     * @return array
     */
    public static function getAllFromSigla($sigla)
    {
        return Database::getRow("SELECT * FROM unita_misura u WHERE sigla=?", array(
            $sigla
        ));
    }

    /**
     * Ottiene la riga dell'Unita di Misura partendo dall'id
     *
     * @param int $id
     * @return array
     */
    public static function getAllFromId($idUnita)
    {
        return Database::getRow("SELECT * FROM unita_misura u WHERE id=?", array(
            $idUnita
        ));
    }
}