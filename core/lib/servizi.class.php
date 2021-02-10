<?php

class Servizi
{

    static function getClassIMenu()
    {
        $array = array();
        foreach (get_declared_classes() as $className) {
            if (in_array('IMenu', class_implements($className))) {
                $array[strtolower($className)] = $className;
            }
        }
        return $array;
    }

    /**
     * Ritorna un servizio
     *
     * @param string $whereField,
     *            il campo su cui fare il controllo
     * @param string $value,
     *            il valore da cercare
     * @return row
     */
    static function get($whereField = "id_servizio", $value)
    {
        return Database::getRow("SELECT DISTINCT s.* FROM servizi s JOIN servizi_config_gruppo USING(id_servizio)
					WHERE $whereField=?", array(
            $value
        ));
    }

    /**
     * Ritorna i servizi associati al gruppo di cui fa parte l'utente
     *
     * @param string $field
     */
    static function getServizi($field = "servizio")
    {
        $id_utente = User::getLoggedUserId();
        $id_gruppo = User::getIdGruppo(User::getLoggedUserGroup());
        
        $sql = "SELECT DISTINCT $field as servizio FROM 
			servizi_utenti u JOIN 
			servizi s USING(id_servizio) JOIN 
			servizi_config_gruppo USING(id_servizio) 
			WHERE id_utente=? AND u.id_gruppo=? ORDER BY posizione ASC";
        
        $rows = Database::getRows($sql, array(
            $id_utente,
            $id_gruppo
        ));
        if (count($rows) > 0)
            return $rows;
        
        $servizi = Servizi::getServiziDefault($field);
        if (count($servizi) > 0) {
            foreach ($servizi as $s)
                $rows[]['servizio'] = $s;
        }
        return $rows;
    }

    /**
     * Prende i servizi di default per un utente, controllando prima che esistano delle associazioni
     * per l'utente x, in caso contrario prende quelli del gruppo
     *
     * @return unknown
     */
    static function getServiziDefault($field = "servizio", $forza = false)
    {
        $gruppo = User::getLoggedUserGroup();
        $id_gruppo = User::getIdGruppo($gruppo);
        
        if (User::isSuperUser() && ! $forza) {
            $sql = "SELECT DISTINCT $field as servizio FROM servizi s JOIN
			servizi_config_gruppo USING(id_servizio)
			WHERE is_attivo=1 ORDER BY posizione ASC";
            $rows = Database::getRows($sql);
        } else {
            $sql = "SELECT s.$field as servizio
			FROM servizi s JOIN servizi_config_gruppo USING(id_servizio)
			JOIN utenti_gruppi g USING(id_gruppo_utente)
			WHERE id_gruppo_utente=?
			AND is_attivo=1
			ORDER BY nome, posizione ASC;";
            $rows = Database::getRows($sql, array(
                $id_gruppo
            ));
            
            if (empty($rows)) {
                // prendo i servizi di default
                $sql = "SELECT s.$field as servizio FROM servizi s JOIN servizi_default d USING(id_servizio)";
                $rows = Database::getRows($sql);
            }
        }
        $servizi = array();
        foreach ($rows as $r)
            $servizi[] = $r['servizio'];
        
        return $servizi;
    }

    static function addServizioGruppoRegione($idGruppo, $idServizio)
    {
        Database::query("INSERT INTO servizi_config_gruppo SET id_gruppo_utente=?, id_servizio=? ", array(
            $idGruppo,
            $idServizio
        ));
    }

    static function addServizioUtente($idUtente, $idServizio, $idGruppo = null)
    {
        $tot = Database::getCount("servizi_utenti", "id_utente=? AND id_servizio=? AND id_gruppo=?", array(
            $idUtente,
            $idServizio,
            $idGruppo
        ));
        if ($tot > 0)
            return;
        return Database::query("INSERT IGNORE INTO servizi_utenti SET id_utente=?, id_servizio=?, id_gruppo=?", array(
            $idUtente,
            $idServizio,
            $idGruppo
        ));
    }

    static function addServizioDefault($idServizio)
    {
        Database::query("INSERT INTO servizi_default  SET id_servizio=?", array(
            $idServizio
        ));
    }

    /**
     * Disabilita i servizi per un utente per una certa azienda
     *
     * @param int $idUtente
     * @return Ambigous <boolean, NULL>
     */
    static function disableServizi($idUtente)
    {
        $servizi = Servizi::getServiziDefault("servizio");
        foreach ($servizi as $s) {
            if ($s != "azienda") {
                $serv = Servizi::get("servizio", $s);
                $idServizio = $serv['id_servizio'];
                Database::query("DELETE FROM servizi_utenti WHERE id_utente=? AND id_servizio=?", array(
                    $idUtente,
                    $idServizio
                ));
            }
        }
    }

    /**
     * Abilita i servizi per un utente per una certa azienda
     *
     * @param int $idUtente
     * @return Ambigous <boolean, NULL>
     */
    static function enableServizi($idUtente)
    {
        $servizi = Servizi::getServiziDefault("servizio");
        $id_gruppo = User::getIdGruppo(User::getLoggedUserGroup());
        foreach ($servizi as $s) {
            $serv = Servizi::get("servizio", $s);
            $idServizio = $serv['id_servizio'];
            Servizi::addServizioUtente($idUtente, $idServizio,  $id_gruppo);
         
        }
    }

    /**
     * Ritorna l'elenco delle pagina presenti, le inserisce in tabella utenti_permessi_risorse se non presenti
     * 
     * @return array
     */
    static function getPagine()
    {
        $path = Config::$serverRoot . DS . "pages";
        
        $results = Servizi::directoryToArray($path, true, true, false, "/templates/");
        foreach ($results as $r) {
            $pagina = substr($r, strpos($r, "pages") + 6);
            $pagina = str_replace("\\", "/", $pagina);
            if (Database::getCount("utenti_permessi_risorse", "type='PAGE' AND name=?", array(
                $pagina
            )) == 0)
                Database::query("INSERT INTO utenti_permessi_risorse SET type='PAGE', name=?", array(
                    $pagina
                ));
        }
        return $results;
    }

    /**
     * Restituisce tutte le cartelle di una directory
     *
     * @param unknown_type $directory
     * @param unknown_type $recursive
     * @param unknown_type $listDirs
     * @param unknown_type $listFiles
     * @param unknown_type $exclude
     * @return Ambigous <multitype:, multitype:string >
     */
    private static function directoryToArray($directory, $recursive = true, $listDirs = true, $listFiles = false, $exclude = '')
    {
        $arrayItems = array();
        $skipByExclude = false;
        $handle = opendir($directory);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
                if ($exclude) {
                    preg_match($exclude, $file, $skipByExclude);
                }
                if (! $skip && ! $skipByExclude) {
                    if (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
                        if ($recursive) {
                            $arrayItems = array_merge($arrayItems, Servizi::directoryToArray($directory . DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
                        }
                        if ($listDirs) {
                            $file = $directory . DIRECTORY_SEPARATOR . $file;
                            $arrayItems[] = $file;
                        }
                    } else {
                        if ($listFiles) {
                            $file = $directory . DIRECTORY_SEPARATOR . $file;
                            $arrayItems[] = $file;
                        }
                    }
                }
            }
            closedir($handle);
        }
        return $arrayItems;
    }

    /**
     * Ritorna un array con tutti i gruppi abilitati per un certo servizio
     *
     * @param string $servizio
     * @param bool $returnArray
     *            [se true ritorna un array]
     * @return string | array
     */
    static function getGruppiAbilitati($servizio, $returnArray = false)
    {
        $ServizioRow = Servizi::get("servizio", $servizio);
        $idServizio = $ServizioRow["id_servizio"];
        
        $sql = "SELECT g.nome
				FROM servizi_config_gruppo c JOIN utenti_gruppi g USING(id_gruppo_utente)
				WHERE id_servizio=?
				AND is_attivo=1";
        
        $rows = Database::getRows($sql, array(
            $idServizio
        ));
        $gruppi = array();
        foreach ($rows as $g)
            $gruppi[] = $g["nome"];
        
        return $returnArray ? $gruppi : implode(",", $gruppi);
    }

    static function isEnable($servizio)
    {
        $servizi = Servizi::getServizi();
        foreach ($servizi as $s) {
            if ($s["servizio"] == $servizio)
                return true;
        }
        return false;
    }
}