<?php

/**
 * Classe base per la gestione dei 
 */
abstract class Plugin implements IPrefs
{

    /**
     * Pagina che richiama il plugin, utile come riferimento
     * all'interno della classe derivata
     *
     * @var Page
     */
    public $callerPage;

    /**
     * TODO: non implementato
     *
     * @var unknown_type
     */
    public $preferences;

    /**
     * Constructor generico
     */
    public function Plugin()
    {
        ;
    }

    // abstract function getMenu();
    
    /**
     * (non-PHPdoc)
     *
     * @see IPrefs::getPrefs()
     */
    function getPrefs()
    {
        return $preferences;
    }

    /**
     * (non-PHPdoc)
     *
     * @see IPrefs::setPrefs()
     */
    function setPrefs()
    {}

    /**
     * Nome della [sotto]cartella del plugin
     *
     * @return string
     */
    function folder()
    {
        return "com_" . strtolower(get_class($this));
    }

    /**
     * Cartella web del plugin, percorso completo
     *
     * @return string
     */
    function webFolder()
    {
        return Config::$urlRoot . "/components/" . $this->folder();
    }

    /**
     * Cartella locale del plugin
     *
     * @return string
     */
    function serverFolder()
    {
        return Config::$serverRoot . DS . "components" . DS . $this->folder();
    }

    /**
     * Funzione di inizializzazione.
     * Bisogna farne l'override nelle classi derivate
     * per eventuali funzionalità di inizializzazione al caricamento del plugin (ad es.
     * assegnare delle variabili al template)
     */
    function init()
    {
        ;
    }

    /**
     * Funzione di assegnazione variabili template nella pagina che chiama il
     * plugin.
     * Serve da wrapper per la funzione "assign" di callerPage
     *
     * @see $callerPage
     * @param string/array $assign1
     * @param string $assign2
     */
    function assign($assign1, $assign2 = null)
    {
        $this->callerPage->assign($assign1, $assign2);
    }
}