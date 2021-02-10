<?php

/**
 * Classe singleton per la gestione e comunicazione
 * col DB.
 *
 */
class Database
{

    /**
     *
     * @var Database
     */
    private static $instance;

    // L'istanza singleton (obbligatoriamente private e static)

    /**
     *
     * @var PDO
     */
    public static $connection;

    private static $sql = "";

    private static $caller;

    /**
     * Costruttore (obbligatoriamente private)
     */
    private function __construct()
    {
        self::initializeConnection();
    }

    /**
     * Inserito per evitare che il singleton venga clonato
     */
    private function __clone()
    {}

    /**
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * Imposta la lingua locale
     *
     * @param string $locale
     */
    public static function setLocale($locale)
    {
        $db = self::getInstance();
        $st = $db->getDb()->prepare("SET lc_time_names = ?");
        $st->execute(array(
            $locale
        ));
    }

    /**
     * Crea connessione
     */
    public static function initializeConnection()
    {
        try {
            $connString = sprintf("%s:host=%s;port=%s;dbname=%s", Config::$pdoDbms, Config::$host, Config::$port, Config::$db);
            self::$connection = new PDO($connString, Config::$user, Config::$pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
        } catch (Exception $ex) {
            die("Attenzione, errore nella connessione al database.");
        }
    }

    public static function quote($value)
    {
        $db = self::getInstance()->getDb();
        return $db->quote($value);
    }

    /**
     * Ritorna la Connessione
     *
     * @return PDO
     */
    public static function getDb()
    {
        return self::$connection;
    }

    /**
     * Ritorna il messaggio di errore SQL
     * Se non SuperUser ritorna un semplice messaggio senza il dettaglio dell'errore.
     *
     * @param string $st
     */
    static function setSqlError($st, $array = null)
    {
        $db = self::getInstance()->getDb();
        if ($db->inTransaction()) {
            $page = Page::getInstance();
            $page->addError("Transazione annullata");
            $db->rollBack();
        }

        $debug = Config::$config["debug"];
        $errors = $st->errorInfo();
        $trace = self::generateCallTrace();
        $trace_errors = implode("<br />", $trace);
        $page = Page::getInstance();

        $query = str_replace("?", "%s", self::$sql);
        $query = vsprintf($query, $array);

        if ($debug)
            die("ERRORE SQL " . $errors[2] . "<br />" . $trace_errors . "<br />$query");
        else {
            if (User::isSuperUser())
                $page->addError("ERRORE SQL " . $errors[2] . "<br />" . $trace_errors . "<br />$query");
            else
                $page->addError("Si è verificato un errore, l'operazione è stata annullata ed una e-mail di segnalazione è stata inviata al supporto tecnico.");
            $text = date("d/m/Y H:i:s") . "<hr />" . $errors[2] . "<hr />" . self::$sql . "<hr />" . $query . "<hr />" . $trace;
            $utente = User::getLoggedUserName();
            Mail::sendPHPMailer(Config::$config["email_support"], "Errore SQL - [$utente]", $text);
            Page::redirect("notauth", "sql");
        }
    }

    /**
     * Restituisce il numero di righe data una query in ingresso
     *
     * @param string $table
     * @param string $where
     * @param array $parameters
     *
     * @return int
     */
    public static function getCount($table, $where = "", $parameters = null)
    {
        $sql = "SELECT COUNT(*) FROM $table";
        if (! empty($where))
            $sql .= " WHERE $where";
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        return self::getField($sql, $parameters);
    }

    /**
     * Ritorna la lista chiamate che genera l'errore Sql
     *
     * @return array
     */
    private static function generateCallTrace()
    {
        $e = new Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $length = count($trace);
        $result = array();

        for ($i = 0; $i < $length; $i ++) {
            $result[] = ($i + 1) . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
        }

        return $result;
    }

    /**
     * Restituisce una riga data una query in ingresso
     *
     * @param string $sql
     * @param array $parameters
     *            [eventuale array con parametri]
     * @return array
     */
    public static function getRow($sql, array $parameters = null, $mode = PDO::FETCH_ASSOC)
    {
        $db = self::getInstance();
        $st = $db->getDb()->prepare($sql);
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        $res = $st->execute($parameters);
        if ($res) {
            $data = $st->fetchAll($mode);
            if (count($data) > 0)
                return $data[0];
            return null;
        } else {
            self::setSqlError($st, $parameters);
            return null;
        }
    }

    /**
     * Restituisce un campo data una query in ingresso
     *
     * @param string $sql
     * @param
     *            array string $parameters [eventuale array con parametri]
     * @return string
     */
    public static function getField($sql, array $parameters = null)
    {
        $db = self::getInstance();
        $st = $db->getDb()->prepare($sql);
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        $res = $st->execute($parameters);
        if ($res) {
            $data = $st->fetchAll(PDO::FETCH_COLUMN);
            return count($data) > 0 ? $data[0] : "";
        } else {
            $callers = debug_backtrace();
            self::$caller = $callers;
            self::setSqlError($st, $parameters);
            return null;
        }
    }

    /**
     * Esegue una query e restituisce il resultset come array, o false
     * se c'è errore
     *
     * @param string $sql
     * @param array $parameters
     * @param PDO $mode
     * @return array
     */
    static function getRows($sql, array $parameters = null, $mode = PDO::FETCH_ASSOC)
    {
        if (empty($sql))
            return null;
        $data = array();

        $db = self::getInstance();
        $st = $db->getDb()->prepare($sql);
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        $res = $st->execute($parameters);
        if ($res) {
            $data = $st->fetchAll($mode);
            return $data;
        } else {
            $callers = debug_backtrace();
            self::$caller = $callers;
            self::setSqlError($st, $parameters);
            return null;
        }
    }

    /**
     * Esegue una insert
     *
     * @param string $sql
     * @param
     *            array parametri
     * @return bool true|false
     */
    static function insert($sql, array $parameters = null)
    {
        $db = self::getInstance();
        $st = $db->getDb()->prepare($sql);
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        $res = $st->execute($parameters);
        if (! $res) {
            $callers = debug_backtrace();
            self::$caller = $callers;
            self::setSqlError($st, $parameters);
            return null;
        }
        return $res;
    }

    /**
     * Esegue una query
     *
     * @param string $sql
     * @param
     *            array parametri
     * @return bool true|false
     */
    static function query($sql, array $parameters = null)
    {
        $db = self::getInstance();
        $st = $db->getDb()->prepare($sql);
        self::$sql = $sql;
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        $res = $st->execute($parameters);
        if (! $res) {
            $callers = debug_backtrace();
            self::$caller = $callers;
            self::setSqlError($st, $parameters);
            return null;
        }
        return $res;
    }

    /**
     * Ritorna i campi di una tabella
     *
     * @param string $table
     * @param array $except
     */
    static function getFieldsString($table, $except = array())
    {
        $mark = array();
        $parameters = array(
            $table,
            Config::$db
        );

        foreach ($except as $o) {
            $mark[] = "column_name!=?";
            array_push($parameters, $o);
        }

        $mark = ! empty($mark) ? "AND " . implode(" AND ", $mark) : "";

        $sql = "SELECT GROUP_CONCAT(column_name) AS campi FROM information_schema.columns WHERE table_name=? AND table_schema=? $mark";
        // array_walk($parameters, function (&$v, $k) {
        // $v = htmlspecialchars($v);
        // });
        return self::getField($sql, $parameters);
    }

    /**
     * Ritorna i campi di una tabella
     *
     * @param string $table
     * @param array $except
     */
    static function describeTableFields($table, $except = array())
    {
        $fields = [];
        $sql = "SHOW FULL COLUMNS FROM $table";
        $rows = self::getRows($sql);
        foreach ($rows as $r) {
            if (! in_array($r["Field"], $except))
                $fields[] = $r;
        }
        return $fields;
    }

    /**
     * Ritorna i valori di un campo ENUM in Mysql
     * Note: non ordinare l'array dei risultati perchè questo compromette il corretto salvataggio nel caso in cui i valori servano per popolare un select, radios o checkboxes
     *
     * @param string $table
     * @param string $column
     * @return array
     */
    static function getEnumValues($table, $column)
    {
        $values = array();
        $sql = "SHOW COLUMNS FROM $table WHERE field='$column'";
        $row = self::getRow($sql);
        $type = $row['Type'];
        $pos = strpos($type, "'") + 1;
        foreach (explode("','", substr($type, $pos, - 2)) as $option)
            $values["$option"] = $option;
        return $values;
    }

    /**
     * Controlla se la tabella esiste
     *
     * @param string $table
     * @param string $db
     *
     * @return bool
     */
    static function table_exist($table, $db = null)
    {
        if (empty($db))
            $db = Config::$db;
        $tot = self::getCount("information_schema.tables", "table_schema = ? AND table_name = ?", array(
            $db,
            $table
        ));
        return $tot > 0;
    }
}