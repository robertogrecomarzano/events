<?php

class JsScript
{

    /**
     *
     * @var string
     */
    public $webPath;

    /**
     *
     * @var string
     */
    public $serverPath;

    /**
     *
     * @param unknown_type $webPath
     * @param unknown_type $serverPath
     */
    public function JsScript($webPath, $serverPath)
    {
        $this->webPath = $webPath;
        $this->serverPath = $serverPath;
    }

    /**
     *
     * @return string
     */
    public function getHeadLink()
    {
        return empty($this->webPath) ? "" : '<script src="' . $this->webPath . '" type="text/javascript"></script>' . "\n";
    }
}