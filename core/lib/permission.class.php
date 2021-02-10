<?php

class Permission implements IPermissions
{

    function isReadable()
    {
        ;
    }

    function isUserOwner()
    {
        ;
    }

    function isWritable($groups)
    {
        ;
    }

    static function getAll($userId)
    {
        ;
    }

    /**
     * Ottiene tutti i privilegi associati ad un utente in base al gruppo di appartenenza
     *
     * @return array associativo $privileges[risorsa]=>array[read,add,delete,update]
     */
    public static function getPrivileges($id_risorsa = null)
    {
        $privileges = array();
        $sql2 = "";
        if ($id_risorsa > 0)
            $sql2 = "AND r.id_risorsa=?";
        
        $sql = "SELECT * FROM utenti_permessi p JOIN utenti_permessi_risorse r USING (id_risorsa) JOIN utenti_gruppi g ON id_gruppo_utente=p.id_gruppo WHERE g.nome=? $sql2";
        $rs = Database::getRows($sql, ($id_risorsa > 0) ? array(
            User::getLoggedUserGroup(),
            $id_risorsa
        ) : array(
            User::getLoggedUserGroup()
        ));
        
        if (count($rs) == 0)
            return $privileges;
        foreach ($rs as $row)
            $privileges[$row["id_risorsa"]] = array(
                "read" => $row['read'],
                "add" => $row['add'],
                "delete" => $row['delete'],
                "update" => $row['update']
            );
        return $privileges;
    }

    /**
     * Ottine l'accesso per una determinata risorsa e per una certa azione
     *
     * @param
     *            $risorsa
     * @param
     *            $action
     * @return boolean
     */
    public static function hasPrivileges()
    {
        $p = Page::getInstance();
        $alias = $p->alias;
        
        $apage = explode("/", $alias);
        $base = $apage[0];
        
        if ($base == "public")
            return true;
        
        if (! User::isUserLogged())
            return false;
        
        if (User::isSuperUser())
            return true;
        
        $id_risorsa = Permission::getRisorsaIdFromName($alias);
        $arr = $_SESSION['user']['permessi'];
        
        if (! in_array($id_risorsa, array_keys($arr)) || empty($arr))
            return true;
        
        $has = array_sum($arr[$id_risorsa]);
        
        if ($has == 0) {
            $return = false;
            $p::$read = true;
            $p::$write = false;
            $p::$add = false;
            $p::$delete = false;
        } else {
            $return = true;
            // imposto i permessi dettagliati per Read e Write per la specifica pagina
            $p = Page::getInstance();
            $p::$read = ($arr[$id_risorsa]['read'] == 1);
            $p::$write = ($arr[$id_risorsa]['update'] == 1);
            $p::$add = ($arr[$id_risorsa]['add'] == 1);
            $p::$delete = ($arr[$id_risorsa]['delete'] == 1);
        }
        
        return $return;
    }

    private static function getRisorsaIdFromName($name)
    {
        return Database::getField("SELECT id_risorsa FROM utenti_permessi_risorse WHERE name=?", array(
            $name
        ));
    }

    /**
     * Controlla se l'utente è abilitato per un certo servizio
     *
     * @param string $servizio
     * @return boolean
     */
    public static function isAbilitato($servizio)
    {
        $servizi = Servizi::getServizi();
        foreach ($servizi as $s)
            if ($s['servizio'] == $servizio)
                return true;
        
        return false;
    }
}