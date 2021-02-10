<?php

/**
 * Classe per la gestione delle pagine
 */
class Page
{

    private static $instance;

    public static $read = true;

    public static $write = true;

    public static $add = true;

    public static $delete = true;

    public static $wizard = array();

    public $token;

    /**
     * $sqlError
     */
    public static $sqlError = "";

    /**
     * variabile usata per i template
     */
    public $tpl;

    /**
     *
     * Id stringa (alias) della pagina
     *
     * @var string
     */
    public $alias;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $subTitle;

    /**
     *
     * @var string
     */
    public $pageLabel;

    /**
     * Contenuto principale della pagina (nel template viene assegnato al
     * tag "$mainContent")
     *
     * @var string
     */
    public $content = "";

    /**
     *
     * @var string
     */
    public $template = "";

    /**
     * Array di errori, a loro volta array associativi del tipo
     * array("msg"=>"alias del messaggio di errore",
     * "args"=>array di variabili da passare)
     *
     * @var array
     */
    public $errors = array();

    /**
     * Array di messages, a loro volta array associativi del tipo
     * array("msg"=>"alias del messaggio di warning",
     * "args"=>array di variabili da passare)
     *
     * @var array
     */
    public $messages = array();

    /**
     * Array di info, a loro volta array associativi del tipo
     * array("msg"=>"alias del messaggio di info",
     * "args"=>array di variabili da passare)
     *
     * @var array
     */
    public $info = array();

    /**
     * Array di warnings, a loro volta array associativi del tipo
     * array("msg"=>"alias del messaggio di warning",
     * "args"=>array di variabili da passare)
     *
     * @var array
     */
    public $warnings = array();

    /**
     *
     * @var CSS
     */
    public $css;

    /**
     *
     * @var VARIE
     */
    public $varie;

    /**
     * Assigns (variabili dinamiche da sostituire nel template)
     *
     * @var array
     */
    public $assigns = array();

    /**
     *
     * @return Page
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className();
        }
        return self::$instance;
    }

    public function setCurrentAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Consente di aggiungere un errore in fondo alla pagina.
     * Utile
     * (e utilizzato) anche per errori di sistema, di debug.
     * Se il messaggio contiene stringhe dinamiche, specificate con
     * sintassi "sprintf" (es. %s), è possibile passare un array di
     * variabili da parsare.
     *
     * @see addWarning()
     * @param string $alias
     *            Alias del messaggio di errore
     * @param array $args
     *            Variabili dinamiche da inserire nel messaggio
     */
    public function addError($alias, $args = array())
    {
        $this->errors[] = array(
            "msg" => $alias,
            "args" => $args
        );
    }

    /**
     * Vedi addError(), stessa funzionalità per i message
     *
     * @see addError()
     * @param string $alias
     *            Alias del messaggio di errore
     * @param array $args
     *            Variabili dinamiche da inserire nel messaggio
     */
    public function addMessages($alias, $args = array())
    {
        $this->messages[] = array(
            "msg" => $alias,
            "args" => $args
        );
    }

    /**
     * Vedi addError(), stessa funzionalità per i message
     *
     * @see addError()
     * @param string $alias
     *            Alias del messaggio di errore
     * @param array $args
     *            Variabili dinamiche da inserire nel messaggio
     */
    public function addInfo($alias, $args = array())
    {
        $this->info[] = array(
            "msg" => $alias,
            "args" => $args
        );
    }

    /**
     * Vedi addError(), stessa funzionalità per i warning
     *
     * @see addError()
     * @param string $alias
     *            Alias del messaggio di errore
     * @param array $args
     *            Variabili dinamiche da inserire nel messaggio
     */
    public function addWarning($alias, $args = array())
    {
        $this->warnings[] = array(
            "msg" => $alias,
            "args" => $args
        );
    }

    /**
     * Carica un plugin dal filesystem e lo include nel codice se viene
     * trovato nella cartella apposita
     *
     * @param string $pluginName
     *            Nome del plugin (e della classe)
     */
    private function loadPlugin($pluginName)
    {
        $path = Framework::getPluginFolder($pluginName) . DS . "main.php";
        if (file_exists($path))
            return include ($path);
        else {
            $this->addError(Language::get("ERROR_PLUGIN_FOLDER_MISSING", array(
                $pluginName
            )));
        }
    }

    /**
     * Ottiene l'URL della pagina a partire dal suo Id
     *
     * @param string $id
     * @return string
     */
    static function getURLStatic($alias)
    {
        $p = new Page($alias);
        return $p->getURL();
    }

    /**
     * Ottiene il path della pagina a partire dal suo Id
     *
     * @param string $id
     * @return string
     */
    static function getPathStatic($alias)
    {
        $p = new Page($alias);
        return $p->getPath();
    }

    /**
     * Funzione per il redirect.
     *
     * @param string $alias
     *            Alias della pagina (es. "login", "home", "user/signup")
     * @param string $rest
     *            Resto dell'indirizzo (parametri e querystring), es. "/4", "/34?param=value"
     */
    static function redirect($alias, $rest = "", $post = false, $msg = null)
    {
        $page = Page::getInstance();
        if ($post) {
            $_SESSION["redirect"]["post"] = true;
            $_SESSION["redirect"]["msg"] = $msg;
        }

        $rest = (! empty($rest)) ? "?param=$rest" : "?fp=" . $page->alias;
        $url = Page::getURLStatic($alias) . $rest;
        header("Location: " . $url);
        die();
    }

    /**
     * Ritorna l'id della pagina
     *
     * @return int
     */
    static function getId()
    {
        return isset($_GET['id']) ? $_GET['id'] : 0;
    }

    /**
     * Crea un nuovo plugin e ne restituisce un'istanza.
     *
     * @param string $name
     *            Nome del Plugin da creare
     * @param array $args
     *            Argomenti da passare al costruttore
     * @return Plugin
     */
    private function newPlugin($name, $args)
    {
        if (! $this->loadPlugin($name))
            return false;
        if (! class_exists($name)) {
            $this->addError(Language::get("ERROR_PLUGIN_CLASS_NOT_FOUND", array(
                $name
            )));
            return false;
        }

        $refl = new ReflectionClass($name);
        $plugin = $refl->newInstanceArgs($args);
        if (! ($plugin instanceof Plugin)) {
            $this->addError(Language::get("ERROR_CLASS_NOT_PLUGIN_INSTANCE", array(
                $name
            )));
            return false;
        }

        return $plugin;
    }

    /**
     * Utilizza il plugin di nome $name, con i suoi file JS e CSS,
     * nella pagina
     *
     * @param string $name
     *            Nome del plugin (e della sua classe PHP)
     * @return mixed Oggetto di classe $name (eredita dalla classe Plugin)
     */
    function addPlugin($name)
    {
        $args = func_get_args();

        $plugin = $this->newPlugin($name, $args);
        if (isset($plugin->scripts)) {
            foreach ($plugin->scripts as $s) {
                $serverJS = $plugin->serverFolder() . DS . "js" . DS . $s;
                $webJS = $plugin->webFolder() . "/js/" . $s;
                if (file_exists($serverJS)) {
                    $this->css->addJS($webJS, $serverJS);
                }
            }
        }
        if (isset($plugin->css)) {
            foreach ($plugin->css as $s) {
                $serverCSS = $plugin->serverFolder() . DS . "css" . DS . $s;
                $webCSS = $plugin->webFolder() . "/css/" . $s;
                if (file_exists($serverCSS)) {
                    $this->css->addCSS($webCSS, $serverCSS);
                }
            }
        }
        $plugin->callerPage = $this;
        $plugin->init();
        return $plugin;
    }

    /**
     * Cartella della pagina
     *
     * @return string
     */
    function serverFolder()
    {
        return Config::$serverRoot . DS . "pages" . DS . $this->alias;
    }

    /**
     * URL della pagina
     *
     * @return string
     */
    function webFolder()
    {
        return Config::$urlRoot . "/pages/" . $this->alias;
    }

    /**
     * Fornisce l'URL da utilizzare per puntare alla pagina.
     * Utile per link menu, e tutti gli altro link interni del sito.
     * Di default corrisponde a webFolder() perché è parsato
     * da .htaccess, se cambiano le regole di .htaccess o esso
     * viene eliminato, si può adattare la funzione di conseguenza,
     * adattando anche la funzione webFolder()
     *
     * @return string
     */
    function getURL()
    {
        return Config::$urlRoot . "/p/" . $this->alias;
    }

    function getPath()
    {
        return Config::$serverRoot . DS . "pages" . DS . $this->alias;
    }

    /**
     *
     * @return string
     */
    function getTemplateServerPath($tplfile = "main")
    {
        $tplPath = $this->serverFolder() . DS . "templates" . DS . $tplfile . ".tpl";
        return $tplPath;
    }

    /**
     * Recupera il template della pagina in oggetto
     *
     * @return Smarty Template
     */
    function fetchTemplate()
    {
        $tplPath = $this->getTemplateServerPath();
        if (file_exists($tplPath)) {
            return $tplPath;
        } else {
            $args = array(
                $this->alias,
                $tplPath
            );
            $this->addError(Language::get("ERROR_PAGE_TEMPLATE_NOT_FOUND", $args));
            return false;
        }
    }

    /**
     * Setta i titoli della pagina
     *
     * @param string $title
     * @param string $subTitle
     * @param string $preTitle
     *            da implementare
     */
    function setTitle($title, $subTitle = "", $preTitle = "")
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->preTitle = $preTitle;
    }

    /**
     * Cartella in cui Smarty crea le versioni già compilate dei template
     *
     * @return string
     */
    public function getTemplateCompileDir()
    {
        return Config::$serverRoot . DS . "cache" . DS . "templates_c";
    }

    /**
     * Crea un oggetto Page
     *
     * @param string $alias
     *            Alias della pagina
     */
    function __construct($alias = "")
    {
        if (! isset($alias) || empty($alias))
            $alias = "user";
        $this->alias = $alias;
        $this->css = new CSS();
        $this->registerPlugin();
    }

    /**
     * Imposta i titoli e le etichette della pagina.
     * Cerca nei seguenti
     * tag XML:
     * <label> etichetta da usare nel menu
     * <desc> descrizione ("sottotitolo") della pagina
     * <pagelabel> titolo della pagina, se assente usa <label>
     *
     * @param string $alias
     *            Alias della pagina
     */
    function setTitles($alias)
    {
        $lang = Language::getCurrentLocale();

        $label = Menu::getNodeSub("label", $alias, $lang);
        $desc = Menu::getNodeSub("desc", $alias, $lang);
        $pagelabel = Menu::getNodeSub("pagelabel", $alias, $lang);

        $this->title = $label;
        $this->subTitle = $desc;
        $this->pageLabel = $pagelabel;
    }

    /**
     * TODO: finire doc
     *
     * @return string
     */
    private function serverCSS()
    {
        return $this->serverFolder() . DS . "templates" . DS . "main.css";
    }

    /**
     *
     * @return string
     */
    private function webCSS()
    {
        return $this->webFolder() . "/templates/main.css";
    }

    /**
     *
     * @return string
     */
    private function serverJS()
    {
        return $this->serverFolder() . DS . "page.js";
    }

    /**
     *
     * @return string
     */
    private function webJS()
    {
        return $this->webFolder() . "/page.js";
    }

    /**
     * Renderizza gli alerts comunicati alla pagina con
     * addError() e addWarning().
     * Funzione generica, genera
     * un alert di tipo diverso a seconda della classe CSS
     * comunicata.
     *
     * @param unknown_type $alerts
     * @param string $class
     * @return string
     */
    private function renderAlerts($alerts, $class = "alert alert-danger")
    {
        $out = "";

        $testi = array();
        if (count($alerts) > 0) {
            foreach ($alerts as $t) {
                $trimmed = trim($t["msg"]);
                if (! empty($trimmed))
                    $testi[] = $trimmed;
            }
        }
        if (empty($testi))
            return $out;

        switch ($class) {
            case "alert alert-danger":
                $type = "danger";
                $delay = "15000"; // 15 secondi
                $title = Language::get("ALERT_DANGER_TITLE");
                break;
            case "alert alert-warning":
                $type = "warning";
                $delay = "15000"; // 15 secondi
                $title = Language::get("ALERT_WARNING_TITLE");
                break;
            case "alert alert-success":
                $type = "success";
                $delay = "15000"; // 15 secondi
                $title = Language::get("ALERT_SUCCESS_TITLE");
                break;
            case "alert alert-info":
                $type = "info";
                $delay = "15000"; // 15 secondi
                $title = Language::get("ALERT_INFO_TITLE");
                break;
        }
        $title = HTML::tag("h4", null, $title, true);

        $testi = array_unique($testi);

        if (count($testi) == 1) {

            $testo = $testi[0];
            $testoTrimmed = trim($testo);
            if (! empty($testoTrimmed))
                $out = $testo;
        } elseif (count($testi) > 0) {
            $out = "<ul>";
            foreach ($testi as $testo) {
                $testoTrimmed = trim($testo);
                if (! empty($testoTrimmed))
                    $out .= "<li>$testo</li>";
            }
            $out .= "</ul>";
        }

        return '<!-- start messages, warnings, errors, info alert -->
                 <script>$.notify(
                    {
                        // options
                        title : "' . $title . '",
                        message: "' . addslashes($out) . '"
                    },
                    {
                        // settings
                        type: "' . $type . '",
                        delay: "' . $delay . '",
                        offset: 5,
	                    spacing: 5,
                        animate: {
                                enter: "animated fadeInRight",
		                        exit: "animated fadeOutRight"
	                              },
                        placement: {
			                     align: "right"
		                          }
                    }

);
                 </script>
                <!-- end messages, warnings, errors, info alert -->';
    }

    /**
     * Assigns per il template (usato specialmente nel codice delle
     * pagine per dinamicizzare le variabili dei template Smarty).
     * Accetta assign stringa (chiave/valore), o un array con una
     * serie di chiavi/valori
     *
     * @param string/array $assign1
     * @param string $assign2
     */
    function assign($assign1, $assign2 = NULL)
    {
        $this->assigns[$assign1] = $assign2;
    }

    /**
     * Renderizza la pagina, riempiendo i vari moduli del layout con i valori
     * presi da $modules, e restituendo la stringa del layout già riempito.
     * I valore assegnabili a $modules sono liberi, per permettere l'utilizzo
     * futuro di layout differenti, solo il modulo "mainContent" deve rimanere
     * fisso.
     *
     * @param array $modules
     *            Array key/value dei moduli del layout da riempire
     * @return Ambigous <string, void, string> Stringa della pagina renderizzata
     */
    function render(array $modules = NULL)
    {
        $this->token = Security::htmlCSRFToken(Security::getAndStoreCSRFToken());

        if (! empty(Page::$sqlError))
            $this->errors[] = array(
                "msg" => Page::$sqlError,
                "args" => array()
            );

        $content = $this->fetchTemplate();
        $errors = $this->renderAlerts($this->errors, "alert alert-danger");
        $warnings = $this->renderAlerts($this->warnings, "alert alert-warning");
        $messages = $this->renderAlerts($this->messages, "alert alert-success");
        $info = $this->renderAlerts($this->info, "alert alert-info");

        $js = $this->css->getScripts();
        $css = $this->css->getCSS();

        $userSimulationSuper = User::userSimulationSuperUserHtml();
        $userSimulationProfilo = User::userSimulationUserProfiloHtml();
        $welcome = isset($_SESSION['user']);

        $this->tpl->setCompileDir($this->getTemplateCompileDir());
        $this->tpl->assign($modules);
        $this->tpl->assign(array(
            "siteUrl" => Config::$urlRoot,
            "siteRoot" => Config::$serverRoot,
            "mainTemplates" => Config::$serverRoot . DS . "core" . DS . "templates",
            "templateCSSUrl" => Config::$urlRoot . "/core/templates/css",
            "templateJSUrl" => Config::$urlRoot . "/core/templates/js",
            "welcome" => $welcome,
            "regione" => Config::$config["regione"],
            "login" => Page::getURLStatic("login"),
            "logout" => Page::getURLStatic("logout"),
            "css" => $css,
            "js" => $js,
            "mainContent" => $content,
            "mainErrors" => $errors,
            "mainWarnings" => $warnings,
            "mainMessages" => $messages,
            "mainInfo" => $info,
            "userSimulationSuper" => $userSimulationSuper,
            "userSimulationProfilo" => $userSimulationProfilo,
            "userProfilo" => User::getLoggedUserGroup(),
            "userNominativo" => User::getLoggedUserNominativo(),
            "formToken" => $this->token,
            "alias" => $this->alias,
            "logo" => "logo"
        ));
        $this->tpl->assign($this->assigns);
        
        return $this->tpl->fetch($this->template);
    }

    /**
     * Registrazione plugin
     */
    function registerPlugin()
    {
        $this->tpl = new Smarty();

        // Funzioni estensione smarty per forms
        $this->tpl->registerPlugin("modifier", "comune", "Istat::getNomeComune");
        $this->tpl->registerPlugin("modifier", "nazione", "Istat::getDenominazioneNazioneFromCode");

        $this->tpl->registerPlugin("modifier", "customFormat", "RegExp::formatNumber");
        $this->tpl->registerPlugin("modifier", "valutaFormat", "RegExp::valuta");

        $this->tpl->registerPlugin("function", "form_tbox", "Form::textbox");
        $this->tpl->registerPlugin("function", "form_area", "Form::textarea");
        $this->tpl->registerPlugin("function", "form_checks", "Form::checks");
        $this->tpl->registerPlugin("function", "form_check", "Form::check");
        $this->tpl->registerPlugin("function", "form_radios", "Form::radios");
        $this->tpl->registerPlugin("function", "form_radio", "Form::radio");
        $this->tpl->registerPlugin("function", "form_select", "Form::select");
        $this->tpl->registerPlugin("function", "form_hidden", "Form::hidden");
        $this->tpl->registerPlugin("function", "form_calendar", "Form::calendar");
        $this->tpl->registerPlugin("function", "form_cf", "Form::cf");

        $this->tpl->registerPlugin("function", "form_edit", "Form::edit"); // form_mod / form_mod2
        $this->tpl->registerPlugin("function", "form_delete", "Form::delete");
        $this->tpl->registerPlugin("function", "form_add", "Form::add");
        $this->tpl->registerPlugin("function", "form_add2", "Form::add2");
        $this->tpl->registerPlugin("function", "form_confirm", "Form::confirm");
        $this->tpl->registerPlugin("function", "form_rilascia", "Form::rilascia");
        $this->tpl->registerPlugin("function", "form_integra", "Form::integra");
        $this->tpl->registerPlugin("function", "form_rettifica", "Form::rettifica");
        $this->tpl->registerPlugin("function", "form_pr_comuni", "Form::pr_comuni");
        $this->tpl->registerPlugin("function", "form_nazione_pr_comuni", "Form::nazione_provincia_comune");
        $this->tpl->registerPlugin("function", "form_province", "Form::province");
        $this->tpl->registerPlugin("function", "form_nazioni", "Form::nazioni");
        $this->tpl->registerPlugin("function", "form_regioni", "Form::regioni");
        $this->tpl->registerPlugin("function", "form_um", "Form::unita_misura");
        $this->tpl->registerPlugin("function", "form_button", "Form::button");
        $this->tpl->registerPlugin("function", "form_link", "Form::link");
        $this->tpl->registerPlugin("function", "form_select_group", "Form::selectGroup");
        $this->tpl->registerPlugin("function", "form_add_edit", "Form::add_edit");
        $this->tpl->registerPlugin("function", "form_undo", "Form::undo");
        $this->tpl->registerPlugin("function", "form_wizard", "Form::wizard");

        $this->tpl->registerPlugin("function", "form_closing", "Form::form_close");
        $this->tpl->registerPlugin("function", "form_opening", "Form::form_open");
        $this->tpl->registerPlugin("function", "form_table", "Form::form_table");
        $this->tpl->registerPlugin("function", "form_lang", "Form::translate");
    }
}
