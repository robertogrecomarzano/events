<?php

class Calendar extends Plugin
{

    public $css = array(
        "bootstrap-datepicker3.css"
    );

    public $scripts = array(
        "calendar.js",
        "bootstrap-datepicker.js",
        "bootstrap-datepicker.it.min.js"
    );

    function init()
    {
        /*
         * FIXME: CAPIRE come fare per evitare di inserirlo nel file calendar.js
         *
         * Per le pagine caricate tramite ajax, va inserito questo codice alla fine del file .tpl
         *
         * $js = <<<JS
         * <script type='text/javascript'>
         * $(document).ready(function() {
         * $('.input-group.date').datepicker({
         * calendarWeeks : true,
         * format: 'dd/mm/yyyy',
         * autoclose : true,
         * todayHighlight : true,
         * language: "it"
         * });
         * });
         * </script>
         *
         * JS;
         * echo $js;
         */
    }
}