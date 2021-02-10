<?php

class ColorBox extends Plugin
{

    public $css = array(
        "colorbox.css"
    );

    public $scripts = array(
        "jquery.colorbox-min.js"
    );

    public $template = array();

    public function getMenu()
    {}

    public function test()
    {
        echo "OK";
    }
}