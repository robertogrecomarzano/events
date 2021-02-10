<?php

class Avvisi extends Plugin
{

    public $css = array(
        "avvisi.css"
    );

    public $scripts = array(
        "avvisi.js"
    );

    public $template = array(
        "avvisi.tpl"
    );

    private $rows = null;

    function init()
    {
        $sql = "SELECT *,DATE_FORMAT(dal,'%d/%m/%Y') AS dal_dmy,DATE_FORMAT(al,'%d/%m/%Y') AS al_dmy  FROM avvisi WHERE record_attivo=1 AND DATE(NOW()) BETWEEN dal AND al ORDER BY dal DESC";
        $this->rows = Database::getRows($sql);
    }

    function draw()
    {
        $out = "";
        $i = 0;
        $tot = count($this->rows);
        if ($tot > 0) {
            $out = "";
            foreach ($this->rows as $r) {
                $out .= "<div class='col-xs-12 col-sm-4 col-md-4 spacer-sm-bottom-20 border-xs-bottom border-sm-bottom-not'>";
                $out .= "<div id='lead' class='feature clearfloat'>";
                $out .= "<b class='title'>" . $r["titolo"] . "</b>";
                $out .= "<p>" . $r["descrizione_lunga"] . "</p>";
                $out .= "</div>";
                $out .= "</div>";
            }
        }
        return $out;
    }

    /**
     * Popola div con il testo tramite ajax
     *
     * @param string $alias
     */
    function show($avvisi)
    {
        echo json_encode($avvisi);
    }

    function getScrollNews()
    {
        if (count($this->rows) == 0)
            return "";

        $url = Config::$urlRoot;
        $out = "<div id='newsPanel'>
				  <div class=\"panel panel-default\">
				  <div class=\"panel-heading\">
				  <span class=\"fa fa-newspaper\"></span> <strong class='text text-muted'>Avvisi e News</strong>
				  </div>
				  <div class=\"panel-body\">
				  <div class=\"row\">
				  <div class=\"col-xs-12\">
				  <ul id=\"newsScroll\">";
        foreach ($this->rows as $r)
            $out .= "<li class='news-item'><strong class='font-bold'>" . $r["titolo"] . "</strong><p>" . $r["descrizione"] . " <a href='$url/p/public/aiuto/news'>Leggi tutto ...</a></p></li>";
        $out .= "</ul>";
        $out .= "</div></div></div></div></div>";

        return $out;
    }

    function getPageRows()
    {
        return $this->rows;
    }
}