<?php

class ListFiles extends Plugin
{

    public $css = array();

    public $scripts = array();

    public $template = array();

    private $parameters = [];

    private $title = "";

    private $subtitle = "";

    private $directory;

    private $extension;

    private $start = - 18;

    private $length = 14;

    private $downloadType = null;

    private $files = [];

    function __construct()
    {
        ;
    }

    function init()
    {}

    private function getListFiles()
    {
        $files = [];
        foreach (glob(Config::$publicRoot . DS . $this->directory . "/*" . $this->extension) as $filename) {

            $len = strrpos(basename($filename), "_");
            if ($len > 0)
                $data = substr(basename($filename), $this->start, $this->length);
            else
                $data = substr(basename($filename), 0, $this->length);

            $format = "Ymd";
            switch ($this->length) {
                case 12:
                    $format = "YmdHi";
                    break;
                case 14:
                    $format = "YmdHis";
            }
            $files[] = [
                "filename" => basename($filename),
                "data" => CustomDate::format($data, $format, "d/m/Y H:i:s")
            ];
        }

        return $files;
    }

    function show()
    {
        $this->parameters = func_get_args();

        list ($this->directory, $this->extension, $this->start, $this->length, $this->title, $this->subtitle, $this->downloadType) = $this->parameters[0];

        $this->files = $this->getListFiles();

        if (empty($this->files))
            return null;

        if (empty($this->downloadType))
            $this->downloadType = "b";

        $out = "<h4>" . $this->title . "</h4>";
        $out .= "<div class='list-group'>";
        $i = 1;
        foreach ($this->files as $file) {
            $out .= "<a target='_blank' href=" . Config::$urlRoot . "/core/download.php?doc=" . $this->directory . "/" . $file["filename"] . "&t=$this->downloadType class='list-group-item'>";
            $out .= "<i class='fa fa-file-pdf fa-fw'></i> ";
            $out .= $this->subtitle . " ( " . $file["filename"] . " )";
            $out .= "<span class='pull-right text-muted small'><em>{$file["data"]}</em></span></a>";

            $i ++;
        }
        $out .= "</div>";
        return $out;
    }
}