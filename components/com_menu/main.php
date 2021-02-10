<?php

/**
 * Classe per la gestione del menu, basato su xml e sulla creazione
 * dinamica delle altre voci tramite hooks chiamati in altre classi.
 */
class Menu extends Plugin
{

    /**
     * Id del nodo attivo
     *
     * @var unknown_type
     */
    static $activeNodeId;

    /**
     * Albero del menu in XML
     *
     * @var SimpleXMLElement
     */
    static $tree;

    /**
     * Lista delle classi che modificano il menu
     *
     * @var array
     */
    private static $classHooks = array();

    public $scripts = array(
        "menu.js"
    );

    public $css = array();

    /**
     * Carica la versione base del menu (senza le voci dinamiche e hooks) dall'xml
     * contenuto nella stessa cartella del plugin.
     */
    public static function load()
    {
        $m = new Menu(); // crea istanza dummy solo per ottenere il path
        $f = $m->serverFolder(); // ottiene il path
        Menu::$tree = simplexml_load_file($f . DS . "menu.xml");
    }

    /**
     * Aggiunge una classe agli hook del menu.
     * La classe deve implementare l'interfaccia
     * IMenu e deve implementare la funzione addInMenuTree() per creare le voci di menu
     * attinenti alla classe indicata.
     *
     * @see IMenu::addInMenuTree
     * @param string $className
     *            Nome della classe
     */
    public static function addClassHook($className)
    {
        Menu::$classHooks[] = $className;
    }

    /**
     * Chiama tutti gli hook delle classi e genera le voci di menu appropriate.
     */
    static public function callHooks()
    {
        foreach (Menu::$classHooks as $h)
            if (class_exists($h))
                call_user_func($h . '::addInMenuTree');
    }

    /**
     * Crea l'attributo xml "url" su tutti i nodi con i link per le
     * varie pagine
     */
    static public function createURLs()
    {
        $nodes = Menu::$tree->xpath('//node[not(@hide)]');

        foreach ($nodes as $n)
            $n->addAttribute("url", Page::getURLStatic($n["id"]));
    }

    /**
     * Trova un nodo tramite l'attributo xml "id"
     *
     * @param string $id
     * @return SimpleXMLElement
     */
    static public function findNodeById($id)
    {
        $tree = Menu::$tree;
        $nodes = $tree->xpath("//node[@id='$id']");
        $node = count($nodes) > 0 ? $nodes[0] : null;
        return $node;
    }

    /**
     * Trova un nodo tramite l'attributo xml "special" (utile se si vuole trovare
     * un nodo a prescindere da dove venga spostato nell'albero XML)
     *
     * @param string $id
     *            Valore di "special"
     * @return SimpleXMLElement Nodo trovato
     */
    static public function findNodeBySpecial($id)
    {
        $tree = Menu::$tree;
        $nodes = $tree->xpath("//node[@special='$id']");
        $node = count($nodes) > 0 ? $nodes[0] : null;
        return $node;
    }

    /**
     * Aggiunge nodi al menu
     *
     * @param SimpleXMLElement $parentNode
     *            Nodo parent
     * @param string $id
     *            Identificativo stringa del nodo (= percorso)
     * @param string $label
     *            Etichetta da visualizzare
     * @param string $desc
     *            Descrizione da visualizzare nella pagina
     * @param string $special
     *            Attributo "special" per aggiunte di altri nodi tramite special
     * @return SimpleXMLElement Riferimento al nodo creato
     */
    static public function appendToNode(SimpleXMLElement $parentNode = null, $id, $label, $desc, $pagelabel = "", $special = "", $other = null, $icon = "", $html = "")
    {
        if (is_null($parentNode))
            return;

        $new = $parentNode->addChild("node");
        Menu::setNodeProperties($new, $id, $label, $desc, $pagelabel, $special, $other, $icon, $html);
        return $new;
    }

    static public function insertBeforeNode(SimpleXMLElement $parentNode = null, $id, $label, $desc, $pagelabel, $special = "", $other = "", $icon = "")
    {
        $target = dom_import_simplexml($parentNode);
        $new = $parentNode->addChild("node");
        Menu::setNodeProperties($new, $id, $label, $desc, $pagelabel, $special, $other, $icon);

        $new = $target->ownerDocument->importNode(dom_import_simplexml($new), true);
        if ($target->previousSibling) {
            $target->parentNode->insertBefore($new, $target->previousSibling);
        } else {
            $target->parentNode->appendChild($new);
        }
    }

    /**
     * Funzione per assegnare in blocco le proprietà e sottonodi di un nodo menu
     *
     * @param SimpleXMLElement $node
     * @param string $id
     * @param string $label
     * @param string $desc
     * @param string $pagelabel
     * @param string $special
     */
    static public function setNodeProperties($node, $id, $label, $desc, $pagelabel, $special = "", $other = null, $icon = "", $html = "")
    {
        $a = $node->attributes();
        $atts_array = (array) $a;
        $atts_array = isset($atts_array['@attributes']) ? $atts_array['@attributes'] : null;
        if (! in_array("id", array_keys((array) $atts_array)))
            $node->addAttribute("id", $id);

        if ($special != "")
            $node->addAttribute("special", $special);
        if ($other != null) {
            if (is_array($other)) {
                foreach ($other as $k => $v)
                    $node->addAttribute($k, $v);
            } else {
                $node->addAttribute("other", $other);
                $node->addAttribute("bg-color", "label-primary");
            }
        }
        if ($icon != null) {
            if (is_array($icon))
                foreach ($icon as $k => $v)
                    $node->addAttribute($k, $v);
            else
                $node->addAttribute("icon", $icon);
        }

        if ($html != "")
            $node->addAttribute("html", $html);

        Menu::setNodeSubLocal($node, "label", $label);
        Menu::setNodeSubLocal($node, "desc", $desc);
        Menu::setNodeSubLocal($node, "pagelabel", $pagelabel);
    }

    /**
     * Dato un nodo di menu, inserisce un sottonodo XML completo di attributo lang per
     * la localizzazione
     *
     * @param SimpleXMLElement $node
     * @param string $id
     */
    static public function setNodeSubLocal($node, $id, $value)
    {
        $safe_value = preg_replace('/&(?!\w+;)/', '&amp;', $value);
        $subitem = $node->addChild($id, $safe_value);
        $subitem->addAttribute("lang", Language::getCurrentLocale());
    }

    /**
     * Trasforma l'XML nel menu in HTML o altro, applicando uno stylesheet XSL
     *
     * @param string $xsl
     *            Nome dell'XSL, senza estensione, pescato nell'apposita cartella
     * @return string Risultato della trasformazione
     */
    static public function styleMenu($xsl, $folder = null)
    {
        $m = new Menu();
        $f = $m->serverFolder();
        $xsl = simplexml_load_file($f . DS . "xsl" . DS . $xsl . '.xsl');
        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xsl);

        if (is_null($folder) || empty($folder)) {
            $pagina = explode("/", Menu::$activeNodeId);
            $folder = Menu::$activeNodeId;
            $folder2 = null;
            $id = end($pagina);
            if ($id > 0 && count($pagina) >= 1)
                $folder2 = $folder . "/" . $id;

            $trovato = Menu::findNodeById($folder2);
            if (! empty($trovato))
                $folder = $folder2;
        }
        if (! empty($pagina)) {
            array_pop($pagina);
            $subfolder = implode("/", $pagina);
        }

        $proc->setParameter('', array(
            "id" => Menu::$activeNodeId,
            "siteUrl" => Config::$urlRoot,
            "folder" => $folder,
            "subfolder" => $subfolder,
            "language" => Language::getCurrentLocale()
        ));

        return $proc->transformToXML(Menu::$tree);
    }

    private static function sqlEscXslt($s)
    {
        return addslashes($s);

        return mysql_real_escape_string($s);
    }

    /**
     * Imposta il nodo correntemente attivo
     *
     * @param string $id
     */
    static public function setActive($id)
    {
        Menu::$activeNodeId = $id;
    }

    /**
     * Dato un nodo <node> del menu, trova il contenuto testuale del tag figlio
     * specificato (utile ad esempio per cercare <label>, <desc>...)
     *
     * @see Page::setTitles()
     * @param string $node
     *            Nome del tag XML del nodo figlio da ricercare
     * @param string $id
     *            Id del nodo
     * @param string $lang
     *            Lingua da ricercare
     * @param string $default
     *            Eventuale valore di default se nodo non trovato
     * @return string Contenuto testuale
     */
    static public function getNodeSub($node, $id, $lang, $default = "")
    {
        $node1 = Menu::$tree->xpath("//node[@id='$id']/{$node}[@lang='$lang']");
        $label = (count($node1) > 0) ? (string) $node1[0] : $default;
        return $label;
    }

    /**
     * Nasconde un nodo del menu
     * Setta l'attributo hide="true"
     *
     * @param string $id
     */
    static public function hideById($id)
    {
        $node = Menu::findNodeById($id);
        if (! $node)
            return;

        $a = $node->attributes();
        $atts_array = (array) $a;
        $atts_array = $atts_array['@attributes'];
        if (! in_array("hide", array_keys($atts_array)))
            $node->addAttribute("hide", "true");
    }

    /**
     * Nasconde un nodo
     *
     * @param SimpleXMLElement $node
     */
    static public function hide($node)
    {
        $a = $node->attributes();
        $atts_array = (array) $a;
        $atts_array = $atts_array['@attributes'];
        if (! in_array("hide", array_keys((array) $atts_array)))
            $node->addAttribute("hide", true);
    }

    /**
     * Controlla se un nodo, e quindi la relativa pagina è visibile per un certo utente|gruppo
     *
     * @param SimpleXMLElement $node
     * @return bool true|false
     */
    static public function is_hide($id)
    {
        if (! empty($_GET["search_azi"]))
            $id .= "?search_azi=" . $_GET["search_azi"];

        $node = Menu::findNodeById($id);

        if (empty($node))
            return false;
        
        $a = $node->attributes();
        $atts_array = (array) $a;
        $atts_array = $atts_array['@attributes'];
        return in_array("hide", array_keys($atts_array));
    }

    static function NodeNotInMenu($sezione, $idSezione)
    {
        $page = Page::getInstance();
        $id = Page::getId();
        $alias = $page->alias;
        $root = explode("/", $alias);
        return ($id != $idSezione || ($id == $idSezione && ($root[0] != $sezione || empty($root[1]))));
    }

    /**
     * Restituisce true se il nodo corrente ha dei nodi figli "node"
     *
     * @param string $id
     *            del nodo padre
     * @return boolean
     */
    static function hasChildren($id)
    {
        $node = Menu::findNodeById($id);
        $child = $node->xpath("node");
        return ! empty($child);
    }

    /**
     * Trova un nodo tramite l'attributo xml "id"
     *
     * @param string $id
     * @return SimpleXMLElement
     */
    static public function findRootNode()
    {
        $tree = Menu::$tree;
        $nodes = $tree->xpath("//menu");
        $node = count($nodes) > 0 ? $nodes[0] : null;
        return $node;
    }
}