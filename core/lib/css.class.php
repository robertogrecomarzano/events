<?php

class CSS
{

    /**
     * Lista degli stylesheet della pagina
     *
     * @var array
     */
    private $css = array();

    /**
     * Lista degli script della pagina
     *
     * @var array
     */
    private $js = array();

    /**
     * Codice JavaScript della pagina
     *
     * @var unknown_type
     */
    private $jsCode = array();

    /**
     *
     * @param unknown_type $webPath
     * @param unknown_type $serverPath
     */
    function addCSS($webPath, $serverPath)
    {
        $this->css[] = array(
            $webPath,
            $serverPath
        );
    }

    /**
     *
     * @param string $code
     */
    public function addJSCode($code)
    {
        $this->jsCode[] = Config::$uniteAndCompressJS ? JSMin::minify($code) : $code;
    }

    /**
     *
     * @param unknown_type $webPath
     * @param unknown_type $serverPath
     * @param bool $before
     *            Se true, inserisce script all'inizio
     */
    function addJS($webPath, $serverPath, $before = false)
    {
        $jsObj = array(
            $webPath,
            $serverPath
        );
        if ($before)
            array_unshift($this->js, $jsObj);
        else
            $this->js[] = $jsObj;
    }

    /**
     * Ottiene l'hash che identifica la signature.
     * La signature
     * è una lista di file (css, js) unita alla loro data di modifica, utile
     * per generare un nuovo hash se i file sono stati modificati.
     *
     * @param array $files
     * @return string
     */
    function getSignatureHash($files)
    {
        $signature = "";
        foreach ($files as $file)
            $signature .= filemtime($file[1]) . "|" . $file[1] . "\n";
        // return unsigned crc32 hash
        return sprintf("%u", crc32($signature));
    }

    /**
     * Genera il link per lo script nell'head della pagina
     *
     * @param unknown_type $src
     * @return string
     */
    private function linkJS($src)
    {
        $s = is_array($src) ? $src[0] : $src;
        $info = pathinfo($s);
        if ($info["extension"] == "js") {
            $timestamp = filemtime($src[1]);
            $path = $info["dirname"] . "/" . $info["filename"] . "." . $timestamp . ".js";
        } else
            $path = $s;
        return empty($s) ? "" : '<script src="' . $path . '" type="text/javascript"></script>' . "\n";
    }

    /**
     * Genera il link per il CSS nell'head della pagina
     *
     * @param resource $src
     * @return string
     */
    private function linkCSS($src)
    {
        $s = is_array($src) ? $src[0] : $src;
        return empty($s) ? "" : "<link rel=\"stylesheet\" href=\"" . $s . "\" type=\"text/css\" media=\"screen\"></link>\n";
    }

    /**
     * Funzione per gestire il caricamento di JS e CSS, con minificazione e caching.
     * Carica una serie di file, opera una funzione custom per comprimere il codice,
     * e unisce il tutto in un singolo file di unione
     *
     * @param array $files
     *            Array di path per JS o CSS
     * @param callable $callback
     *            Callback o closure per la funzione di minificazione
     * @param string $cacheServerPath
     *            Cartella server su cui leggere/scrivere il file di unione
     * @param string $webPath
     *            Cartella web da cui prelevare il file di unione
     * @param string $extension
     *            Estensione da usare nel file di unione
     * @return string Indirizzo da linkare nella pagina web
     */
    private function loadFiles(array $files, $callback, $cacheServerPath, $webPath, $extension)
    {
        $signatureHash = CSS::getSignatureHash($files);
        $svrSrc = Config::$serverRoot . DS . "cache" . DS . $cacheServerPath . DS . $signatureHash . "." . $extension;
        $webSrc = Config::$urlRoot . "/$webPath/$signatureHash.$extension";
        if (! file_exists($svrSrc)) {
            $code = "";
            foreach ($files as $file) {
                $original = file_get_contents($file[1]);
                $originalPath = dirname($file[1]);
                $code .= $callback($original, $originalPath);
            }
            file_put_contents($svrSrc, $code);
        }
        return $webSrc;
    }

    /**
     * Genera istruzioni HTML per incorporare gli script JavaScript inclusi
     * nell'array $this->scripts nell'HEAD della pagina
     *
     * @return string
     */
    public function getScripts()
    {
        $o = "";
        if (Config::$uniteAndCompressJS) {
            $src = $this->loadFiles($this->js, function ($file, $path) {
                return JSMin::minify($file);
            }, "page_scripts", "js", "js");
            $o = $this->linkJS($src);
        } else
            $o = implode("", array_map(array(
                $this,
                "linkJS"
            ), $this->js));
        // render explicit JS code
        if (count($this->jsCode > 0)) {
            $o .= "<script type=\"text/javascript\">\n<!--\n" . implode("\n", $this->jsCode) . "\n-->\n</script>";
        }
        return $o;
    }

    /**
     * Genera istruzioni HTML per incorporare i CSS inclusi nell'array
     * $this->css nell'HEAD della pagina
     *
     * @return string
     */
    public function getCSS()
    {
        $o = "";
        if (Config::$uniteAndCompressCSS) {
            $src = $this->loadFiles($this->css, function ($file, $path) {
                return CSS::minifyCSS(Minify_CSS_UriRewriter::rewrite($file, $path, ""));
            }, "page_css", "css", "css");
            $o = $this->linkCSS($src);
        } else
            $o = implode("", array_map(array(
                $this,
                "linkCSS"
            ), $this->css));
        return $o;
    }

    /**
     * Funzione di minify per codice CSS via regexp
     *
     * @param string $code
     * @return string
     */
    static function minifyCSS($code)
    {
        $bf = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
        $bf = str_replace(array(
            "\r\n",
            "\r",
            "\n",
            "\t",
            '  ',
            '    ',
            '    '
        ), '', $code);
        return $bf;
    }
}