<?php

/**
 * Classe di gestione degli utenti del sito
 */
class User extends OrmObj
{
    
    public $orm_table = "utenti";
    
    public $orm_pk_field = "id_utente";

    private static $servizi = array();

    private static $ip = "";

    private static $url = "";

    private static $pg = "";

    private static $regione = "";

    
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
     * Update utente
     *
     * @param int $idUtente
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
     * Inizializzazione pagina, con controllo della sessione ed eventuale redirect
     */
    static function initPage()
    {

        // Operazione da fare come prima
        User::setConfig();

        $page = Page::getInstance();
        User::$pg = $page->alias;

        if (Config::$config["offline"] && ! User::isSuperUser()) {

            if (User::$pg != "offline")
                Page::redirect("offline");
        } else {
            if (User::$pg == "notfound")
                return;

            // Controllo session scaduta
            if (! User::isUserLogged()) {

                $apage = explode("/", User::$pg);
                $base = $apage[0];
                
                $events = parse_ini_file(Config::$serverRoot. DS . "events.ini");
                foreach ($events as $k => $v) {
                    $url = reset(explode("|", $v));
                    Config::$openPage[] = $url;
                    
                    if($page->alias == $url)
                    {
                        $type = end(explode("|", $v));
                        $page->alias = "event/$type";
                    }
                }
                
                if (! in_array(User::$pg, Config::$openPage) && $base != "public")
                {
                    Page::redirect("notfound");
                    // header("Location: " . Config::$config["web"]);
                    
                }
            }

            // Controllo user simulation - Utente - Gruppo
            if (isset($_POST['userSimSelectGruppo']) && ! empty($_POST['userSimSelectGruppo'])) {
                $simulatedGroup = $_POST['userSimSelectGruppo'];
                User::logUser(User::getLoggedUserId(), $simulatedGroup);
                $_SESSION['user']['simulation']['id'] = User::getLoggedUserId();
                $_SESSION['user']['simulation']['gruppo'] = $simulatedGroup;
                $_SESSION['user']['gruppo'] = $simulatedGroup;
                Page::redirect("user");
            } // Controllo user simulation - Utente - Ente
            elseif (isset($_POST['userSimSelectEnteId']) && ! empty($_POST['userSimSelectEnteId']) && isset($_POST['userSimSelectEnteCodice']) && ! empty($_POST['userSimSelectEnteCodice'])) {
                $simulatedEnteId = $_POST['userSimSelectEnteId'];
                $simulatedEnteCodice = $_POST['userSimSelectEnteCodice'];
                $_SESSION['user']['simulation']['id'] = User::getLoggedUserId();
                $_SESSION['user']['simulation']['ente'] = $simulatedEnteCodice;
                $_SESSION['user']['simulation']['ente_id'] = $simulatedEnteId;
                $_SESSION['user']['ente'] = $simulatedEnteCodice;
                $_SESSION['user']['ente_id'] = $simulatedEnteId;
            } else {
                // Controllo user simulation - SuperUser
                if ((isset($_POST['userSimSelect']) && $_POST['userSimSelect'] > 0) || (isset($_POST['form_changeuser']) && ! empty($_POST['form_changeuser']) && $_POST["form_changeuser"] > 0)) {
                    $simulatedUserId = $_POST['userSimSelect'] > 0 ? $_POST['userSimSelect'] : $_POST["form_changeuser"];
                    User::logUser($simulatedUserId);
                    $sql = "SELECT g.nome FROM utenti u JOIN utenti_has_gruppi ug USING(id_utente) LEFT JOIN utenti_gruppi g USING (id_gruppo_utente) WHERE id_utente = ?";
                    $simulatedUserGroup = Database::getField($sql, array(
                        $simulatedUserId
                    ));
                    $_SESSION['user']['simulation']['id'] = $simulatedUserId;
                    $_SESSION['user']['simulation']['gruppo'] = $simulatedUserGroup;
                    $_SESSION['user']['simulation']['superuser'] = true;
                }
            }

            User::online();

            User::hasPermission();

            if (User::isReadOnly())
                $page->addWarning("Accesso in sola lettura, nessuna modifica è concessa.");
        }
    }

    /**
     * Imposta nella variabile Config::$config, il contenuto della tabella config
     */
    static function setConfig($load = false)
    {
        if ($load || empty($_SESSION["configuration"])) {
            Config::$config = null;

            $config = Database::getRow("SELECT * FROM config LIMIT 1");
            if (count($config) > 0) {
                $_SESSION["configuration"]["config"] = $config;
                Config::$config = $config;
            }
        } else
            Config::$config = $_SESSION["configuration"]["config"];
    }

    /**
     * Restituisce il nome dello studio
     *
     * @return string
     */
    static function getStudio()
    {
        return $_SESSION["denominazione"];
    }

    /**
     * Verifica se si hanno i permessi per la pagina
     */
    static function hasPermission()
    {
        $events = parse_ini_file(Config::$serverRoot. DS . "events.ini");
        foreach ($events as $k => $v) {
            $url = reset(explode("|", $v));
            Config::$openPage[] = $url;
            
            if($page->alias == $url)
            {
                $type = end(explode("|", $v));
                $page->alias = "event/$type";
            }
        }
        
        if (in_array(User::$pg, Config::$openPage))
            return;

        $apage = explode("/", User::$pg);
        $base = $apage[0];

        if (! User::isUserLogged() && $base != "public") {
            header("Location: " . Config::$config["web"]);
        }

        $has = true;
        $has = Permission::hasPrivileges(User::$pg);
        if ($has === false)
            Page::redirect("notauth", "risorsa");
    }

    /**
     * Restituisce l'HTML che permette al superuser di selezionare
     * l'utente da simulare in modalità User Simulation
     *
     * @return string
     */
    static function userSimulationSuperUserHtml()
    {
        if (! User::isSuperUser() && ! $_SESSION['user']['simulation']['superuser'])
            return "";

        $sql = "SELECT u.*,g.nome AS gruppo,
		CONCAT(u.cognome,' ',u.nome) AS username
		FROM utenti u
		JOIN utenti_has_gruppi ug USING(id_utente)
		JOIN utenti_gruppi g USING(id_gruppo_utente)
        WHERE u.record_attivo=1
		GROUP BY id_utente
		ORDER BY g.nome, username";

        $utenti = Database::getRows($sql);
        if (count($utenti) == 0)
            return;

        $gr = "";
        $out = '<li class="dropdown">
							<a class="dropdown-toggle"	data-toggle="dropdown" href="#">
								<i class="fas fa-users fa-2x"></i>
								<i class="fas fa-caret-down"></i>
							</a>
						   <form id="userSimFormSuper" method="post" style="display:inline;">
				   			<input type="hidden" name="userSimSelect" id="userSimSelect"/>
							</form>
							<ul class="dropdown-menu scrollable-menu" role="menu">';
        foreach ($utenti as $g) {
            if ($gr != $g["gruppo"]) {
                $out .= '<li class=\'active\'><a href="#"><strong>' . strtoupper($g["gruppo"]) . '</strong></a></li>';
                $gr = $g["gruppo"];
            }
            $class = $_SESSION['user']['simulation']['id'] == $g["id_utente"] ? "active" : "";

            $out .= '<li><a class="' . $class . '" href="#" onclick="$(\'#userSimSelect\').val(\'' . $g["id_utente"] . '\'); $(\'#userSimFormSuper\').submit()"><i class="fas fa-user fa"></i> ' . $g["username"] . '</a></li>';
        }
        $out .= "</ul></li>";

        return $out;
    }

    /**
     * Restituisce l'HTML che permette all'utente di cambiare profilo
     *
     * @return string
     */
    static function userSimulationUserProfiloHtml()
    {
        if (! User::isUserLogged())
            return "";
        $gruppi = $_SESSION['user']['gruppi'];
        if (count($gruppi) == 1)
            return "";

        $out = '<li class="dropdown">
							<a class="dropdown-toggle"	data-toggle="dropdown" href="#">
								<i class="fas fa-refresh fa-2x"></i>
								<i class="fas fa-caret-down"></i>
							</a>
						   <form id="userSimForm" method="post" style="display:inline;">
				   			<input type="hidden" name="userSimSelectGruppo" id="userSimSelectGruppo"/>
							</form>
							<ul class="dropdown-menu dropdown-user">';
        foreach ($gruppi as $g) {
            $class = $_SESSION['user']['gruppo'] == $g["gruppo"] ? "active" : "";
            $out .= '<li><a class="' . $class . '" href="#" onclick="$(\'#userSimSelectGruppo\').val(\'' . $g["gruppo"] . '\'); $(\'#userSimForm\').submit()"><i class="fas fa-user fa-2x"></i>' . $g["gruppo_desc"] . '</a></li>';
        }
        $out .= "</ul></li>";

        return $out;
    }

    /**
     * Creazione del menù
     */
    static function createMenu()
    {
        if (User::isUserLogged()) {

            $root = Menu::findRootNode();
            Menu::appendToNode($root, "user", Language::get("PROFILE"), Language::get("PROFILE_TITLE"), Language::get("PROFILE_SUBTITLE"), "", "", [
                "icon" => "user",
                "icon-color" => "purple"
            ]);

            switch (User::getLoggedUserGroup()) {
                case "superuser":


                    $admin = Menu::appendToNode($root, "admin", "Pannello di controllo", "Sezione riservata al superuser", "", "", "super", "cogs");

                    Menu::appendToNode($admin, "admin/configurazione", "Configurazione", "Configurazione parametri di sistema", "Configurazione parametri di sistema", "", "", "cog");
                    
                    Menu::appendToNode($admin, "admin/utenti", "Gestione utenti", "Gestione completa degli utenti del sistema", "", "", "", "user-plus");
                    Menu::appendToNode($admin, "admin/utenti/online", "Utenti online", "Elenco degli utenti on line", "", "", "", "users");

                    $NodePermessi = Menu::appendToNode($admin, "admin/permessi", "Servizi e permessi", "Gestione servizi, permessi ed abilitazione profili.", "", "", "", "puzzle-piece");
                    Menu::appendToNode($NodePermessi, "admin/permessi/servizi", "Servizi", "Gestione servizi disponibili", "", "", "", "bars");
                    Menu::appendToNode($NodePermessi, "admin/permessi/gruppi", "Gruppi", "Gestione gruppi", "", "", "", "users");
                    Menu::appendToNode($NodePermessi, "admin/permessi/associaservizi", "Associa Servizi|Gruppi", "Abilitare o disabilitare i servizi per i gruppi", "", "", "", "angle-double-right ");
                    Menu::appendToNode($NodePermessi, "admin/permessi/pagine", "Pagine", "Gestione permessi singole pagine", "", "", "", "file");

                    $aiuto = Menu::appendToNode($admin, "admin/help", "Help/Faq", "Gestione Help in linea e Faq", "", "", "", "question");
                    Menu::appendToNode($aiuto, "admin/help/pagine", "Help pagine", "Gestione help in linea per singola pagina", "", "", "", "question");
                    Menu::appendToNode($aiuto, "admin/help/faq", "Gestisci Faq", "Gestione delle Faq", "", "", "", "question");

                    Menu::appendToNode($admin, "admin/testmail", "Test email", "Testare l'invio delle email", "Testare l'invio delle email", "", "", "envelope");

                       /**
                     * Sezione privacy
                     */
                    Menu::appendToNode($admin, "privacy", Language::get("PRIVACY_LIST"), Language::get("PRIVACY_LIST_TITLE"), Language::get("PRIVACY_LIST_SUBTITLE"), "", "", [
                        "icon" => "user-secret",
                        "icon-color" => "red"
                    ]);
                    Menu::appendToNode($admin, "privacy/principale", Language::get("PRIVACY_NEW"), Language::get("PRIVACY_NEW_TITLE"), Language::get("PRIVACY_NEW_SUBTITLE"), "", "", "plus");

                   
                    $id = Page::getId();
                    $page = Page::getInstance();
                    $pagina = $page->alias;

                    if ($pagina != "privacy" && $id > 0) {

                        if (Menu::NodeNotInMenu("privacy", $id))
                            return;

                        $nodePrivacy = Menu::appendToNode($admin, "privacy/principale/" . $id, Language::get("PRIVACY_DATA"), Language::get("PRIVACY_DATA_TITLE"), Language::get("PRIVACY_DATA_SUBTITLE"), "privacy_" . $id, null, "play");

                        Menu::appendToNode($nodePrivacy, "privacy/motivi/" . $id, Language::get("PRIVACY_DETAIL"), Language::get("PRIVACY_DETAIL_TITLE"), Language::get("PRIVACY_DETAIL_SUBTITLE"), "privacydetail_$id", "", [
                            "icon" => "user-graduate",
                            "icon-color" => "yellow"
                        ]);
                    }


                    Menu::appendToNode($root, "admin/eventi", "Eventi", "I miei eventi", "", "", "", "calendar-day");
                    Menu::appendToNode($root, "admin/iscritti", "Iscritti", "Gestione completa degli utenti del sistema", "", "", "", "user-plus");
                    Menu::appendToNode($root, "admin/inviomail", "Invio mail", "Invio email agli utenti registrati per l'evento", "", "", "", "envelope");
                    
                    break;
                    
                case "editor":
                    Menu::appendToNode($root, "admin/eventi", "Eventi", "I miei eventi", "", "", "", "calendar-day");
                    Menu::appendToNode($root, "admin/iscritti", "Iscritti", "Gestione completa degli utenti del sistema", "", "", "", "user-plus");
                    Menu::appendToNode($root, "admin/inviomail", "Invio mail", "Invio email agli utenti registrati per l'evento", "", "", "", "envelope");
                    break;
            }
        } else {
            Menu::hideById("user");
        }
    }

    /**
     * Ritorna true se c'è un utente loggato
     *
     * @return string
     */
    public static function isUserLogged()
    {
        return isset($_SESSION['user']['id']);
    }

    /**
     * Ottiene l'id dell'utente loggato
     */
    public static function getLoggedUserId()
    {
        if (! User::isUserLogged())
            return 0;
        elseif (isset($_SESSION['user']['simulation']['id']))
            return $_SESSION['user']['simulation']['id'];
        else
            return $_SESSION['user']['id'];
    }

    /**
     * Ritorna lo username dell'utente
     */
    public static function getLoggedUserName()
    {
        return Database::getField("SELECT username FROM utenti WHERE id_utente = ?", array(
            User::getLoggedUserId()
        ));
    }

    /**
     * Ritorna il nome e cognome o il CF se nome e cognome sono vuoti
     */
    public static function getLoggedUserNominativo()
    {
        return Database::getField("SELECT IF(TRIM(CONCAT(IFNULL(cognome,''), ' ',IFNULL(nome,'')))='', username, CONCAT(cognome, ' ',nome)) AS nome FROM utenti WHERE id_utente = ?", array(
            User::getLoggedUserId()
        ));
    }

    /**
     * Logout
     */
    public static function logout()
    {
        User::online("logout");
        session_unset();
    }

    /**
     * Ottiene il gruppo dell'utente loggato, o false se
     * non lo è.
     *
     * @return mixed Stringa col gruppo utente dell'utente o false se utente
     *         non loggato
     */
    public static function getLoggedUserGroup($bypassSimulation = false)
    {
        if (! User::isUserLogged())
            return false;
        elseif (! $bypassSimulation && isset($_SESSION['user']['simulation']['gruppo']))
            return $_SESSION['user']['simulation']['gruppo'];
        else
            return $_SESSION['user']['gruppo'];
    }

    /**
     * Ottiene l'ente dell'utente loggato, o false se
     * non lo è.
     *
     * @return mixed Stringa con l'ente dell'utente o false se utente
     *         non loggato
     */
    public static function getLoggedUserEnte($bypassSimulation = false)
    {
        if (! User::isUserLogged())
            return false;
        elseif (! $bypassSimulation && isset($_SESSION['user']['simulation']['ente']))
            return isset($_SESSION['user']['simulation']['ente_id']) ? $_SESSION['user']['simulation']['ente_id'] : null;
        else
            return isset($_SESSION['user']['ente_id']) ? $_SESSION['user']['ente_id'] : null;
    }

    /**
     * Ottiene l'ente dell'utente loggato, o false se
     * non lo è.
     *
     * @return mixed Stringa con l'ente dell'utente o false se utente
     *         non loggato
     */
    public static function getLoggedUserEnteDesc()
    {
        if (! User::isUserLogged())
            return false;
        else
            return isset($_SESSION['user']['ente_desc']) ? $_SESSION['user']['ente_desc'] : null;
    }

    /**
     * Registra in sessione le info utente
     *
     * @param int $userId
     * @param string $gruppo
     */
    public static function logUser($userId, $gruppo = "")
    {
        $rs_gruppi = Database::getRows("SELECT DISTINCT g.nome AS gruppo, ug.id_gruppo_utente AS id_gruppo, g.descrizione AS gruppo_descrizione
				FROM utenti u
				LEFT JOIN utenti_has_gruppi ug USING (id_utente)
				JOIN utenti_gruppi g USING(id_gruppo_utente)
				WHERE u.id_utente = ?
				AND	u.record_attivo=1 ORDER BY id_gruppo_utente ASC", array(
            $userId
        ));

        $leftJoin = $rs_gruppi[0]["gruppo"] == "superuser" ? "LEFT" : "";

        $res = Database::getRows("SELECT *
                FROM utenti u
				WHERE u.id_utente = ?
				AND	u.record_attivo=1", array(
            $userId
        ));
        $tot = count($res);
        if ($tot > 0) {
            $gruppi = array();
            foreach ($rs_gruppi as $row_gruppo) {
                $gruppi[] = array(
                    "id_gruppo" => $row_gruppo['id_gruppo'],
                    "gruppo" => $row_gruppo['gruppo'],
                    "gruppo_desc" => $row_gruppo['gruppo_descrizione']
                );
            }

            if (! empty($gruppo))
                $g = $gruppo;
            else
                $g = $gruppi[0]['gruppo'];

            $_SESSION['user'] = array(
                'id' => $res[0]['id_utente'],
                'username' => $res[0]['username'],
                'nome' => $res[0]['nome'],
                'cognome' => $res[0]['cognome'],
                'gruppo' => $g,
                'gruppi' => $gruppi,
                'readonly' => $res[0]['readonly'],
                'nazione' => $res[0]['nazione'],
                'email' => $res[0]['email'],
                'lingua' => $res[0]['lingua']
            );
            Language::setCurrentLocale($res[0]['lingua']);

            $_SESSION['denominazione'] = $res[0]['denominazione'];
            $_SESSION['user']['permessi'] = Permission::getPrivileges();
            $_SESSION['user']['traduzioni'] = Language::getTraduzioni();

            User::online("login");
        }
    }

    /**
     * Ritorna tutti i dati dell'utente
     *
     * @return array
     */
    public static function getUserData($idUtente)
    {
        return Database::getRow("SELECT *,
                                IF(CONCAT(cognome,nome)='' OR CONCAT(cognome,nome) IS NULL,username,CONCAT(cognome,' ', nome)) AS utente,
                                DATE_FORMAT(data_nascita,'%d/%m/%Y') AS data_nascita_dmy
                                FROM utenti
                                WHERE id_utente=?", array(
            $idUtente
        ));
    }

    /**
     * Login dell'utente con verifica credenziali
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public static function login($username, $password, $cf = "", $is_superuser = false)
    {
        $sqlSuper = null;
        if ($is_superuser) {
            $idGruppoSuper = User::getIdGruppo("superuser");
            $sqlSuper = " AND ug.id_gruppo_utente = $idGruppoSuper";
        }

        $sql = "SELECT id_utente
					FROM	utenti u JOIN utenti_has_gruppi ug USING(id_utente)
					WHERE	BINARY u.username = ?
					AND		BINARY u.password = ?
					AND		record_attivo = 1
					$sqlSuper";

        $password = trim($password);
        $passCrypt = User::saltPassword($password);

        $userId = Database::getField($sql, array(
            trim($username),
            $passCrypt
        ));

        if ($userId && ! isset($_SESSION['user']['simulation'])) {
            User::logUser($userId, $_SESSION['user']['gruppo']);
            return true;
        } else
            return false;
    }

    /**
     * Setta i servizi di default
     *
     * @param array $servizi
     */
    static function setServiziDefault($servizi = array())
    {
        User::$servizi = $servizi;
    }

    /**
     * Carica per l'utente i servizi di default
     *
     * @param int $idUtente
     * @param int $idAnagrafica
     *            [optional]
     */
    static function associaServiziDefault($idUtente, $idAnagrafica = null)
    {
        $default = ! empty(User::$servizi) ? User::$servizi : Servizi::getServiziDefault();
        $res = true;
        // TOTO: capire come mai arriva default vuoto
        foreach ($default as $d) {
            $Servizio = Servizi::get("servizio", $d);
            $idServizio = $Servizio['id_servizio'];
            $res = $res && Servizi::addServizioUtente($idUtente, $idServizio, $idAnagrafica);
        }
        return $res;
    }

    static function createRandomPassword()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i ++;
        }
        return $pass;
    }

    /**
     * Hashing della password con salt
     *
     * @param string $clearPassword
     *            Password in chiaro
     * @return string Password hashata
     */
    static function saltPassword($clearPassword)
    {
        return sha1(Config::$passwordSalt . $clearPassword);
    }

    /**
     * Ritorna true se l'utente è superuser
     *
     * @param bool $by
     * @return boolean
     */
    static function isSuperUser($bypassSimulation = false)
    {
        return User::getLoggedUserGroup($bypassSimulation) == "superuser";
    }

    /**
     * Accetta una lista di gruppi utente e ritorna true se l'utente è
     * classificato in uno di questi
     *
     * @param array $argomenti
     *            [opzionale, può essere usata una lista di parametri separati da virgola invece di questo array]
     * @return boolean
     */
    static function isUserInGroups($argomenti = null)
    {
        if (is_array($argomenti))
            return in_array(User::getLoggedUserGroup(), $argomenti);
        else
            return in_array(User::getLoggedUserGroup(), func_get_args());
    }

    /**
     * Ritorna true se l'utente è in sola ettura
     *
     * @param bool $by
     * @return boolean
     */
    static function isReadOnly()
    {
        return $_SESSION['user']['readonly'] == 1;
    }

    /**
     * Ritoran un'array con le tipologie di utenti
     * Tecnico, Titolare, Altro ...
     *
     * @return array
     */
    static function getTipologia()
    {
        $sql = "SELECT id_tipologia_utente, nome FROM utenti_tipologia";
        $data = Database::getRows($sql, null, PDO::FETCH_KEY_PAIR);
        return $data;
    }

    /**
     * Ritoran l'id_gruppo a partire dal nome del gruppo
     *
     * @return int
     */
    static function getIdGruppo($gruppo)
    {
        $sql = "SELECT id_gruppo_utente FROM utenti_gruppi WHERE nome=?";
        return Database::getField($sql, array(
            $gruppo
        ));
    }

    /**
     * Ritorna il nome del gruppo utente partendo dall'id_utente
     *
     * @param int $id_utente
     * @return string
     */
    static function getGruppoUtente($idUtente)
    {
        $sql = "SELECT descrizione FROM
				utenti_gruppi ug JOIN utenti_has_gruppi has USING(id_gruppo_utente)
				WHERE id_utente=?
				LIMIT 1";
        return Database::getField($sql, array(
            $idUtente
        ));
    }

    /**
     * Aggiorna la tabella utenti_online
     *
     * @param string $stato
     *            [login|logout]
     */
    public static function online($stato = "")
    {
        User::$ip = $_SERVER['REMOTE_ADDR'];

        switch ($stato) {
            case "login":
                $tm = date("Y-m-d H:i:s");
                Database::query("DELETE FROM utenti_online WHERE id_utente=? AND ip=?", array(
                    User::getLoggedUserId(),
                    User::$ip
                ));
                Database::query("INSERT INTO utenti_online (id,id_utente,ip,tm,page,url) VALUES(?,?,?,?,?,?)", array(
                    session_id(),
                    User::getLoggedUserId(),
                    User::$ip,
                    $tm,
                    User::$pg,
                    User::$url
                ));

                break;
            case "logout":
                Database::query("UPDATE utenti_online SET status=0 WHERE id_utente=? AND ip=?", array(
                    User::getLoggedUserId(),
                    User::$ip
                ));
                break;
            default:
                // Aggiorno tabella Utenti on line
                User::$url = Config::$urlRoot . "/index.php";
                if ($_SERVER["QUERY_STRING"] != "")
                    User::$url .= "?" . $_SERVER["QUERY_STRING"];
                if (isset($_SESSION['user']))
                    Database::query("UPDATE utenti_online SET tm=NOW(), status=1, page=?, url=? WHERE id_utente=? AND ip=?", array(
                        User::$pg,
                        User::$url,
                        User::getLoggedUserId(),
                        User::$ip
                    ));
                // Ad ogni caricamento di una pagina aggiorno la tabella degli utenti online
                // Eliminando quelli per cui si è verificato un timeout [ad esempio che abbiano chiuso senza fare logout]
                // Attivo solo per gli amministratori, per non sovraccaricare il server di query
                $page = Page::getInstance();
                if (User::isSuperUser() && $page->alias == "admin/utenti/online") {
                    $gap = 5; // tempo di attesa in minuti
                    Database::query("UPDATE utenti_online SET status=0 WHERE tm < DATE_SUB(NOW(), INTERVAL $gap MINUTE);");
                }

                break;
        }
    }


   
    /**
     * Creo il menù relativo alle pagine aperte, senza login
     * Le voci sono registrate in una tabella "pubblicazioni"
     */
    static function pubblicazioni()
    {
        $pubb = Database::getRows("SELECT * FROM pubblicazioni");

        if (count($pubb) > 0) {
            $pubbnode = Menu::findNodeById("public");
            foreach ($pubb as $purl)
                Menu::appendToNode($pubbnode, "public/" . $purl["url"], $purl["titolo"], $purl["descrizione"], "", "", "", "file");
        }
    }
}
