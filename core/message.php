<?php

/**
 * 
 *
 */
class Message
{

    public $alias;

    public $type;

    public $args;

    public $class;

    function render()
    {
        $t = Language::get($this->alias, $this->args);
        return "<div class='" . $this->class . "'>" . $t . "</div>";
    }
}