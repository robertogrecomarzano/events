<?php

/**
 *
 *
 */
class HTML
{

    /**
     * Escaping dei valori valido per gli attributi dei tag HTML
     *
     * @param string $value
     * @return string
     */
    static function HTMLAttributeValue($value)
    {
        if (is_array($value))
            return null;
        return htmlspecialchars((string) $value);
    }

    /**
     * Escaping della coppia attributo/valore attributo per un tag HTML
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    static function HTMLAttribute($key, $value)
    {
        return $key . "=\"" . HTML::HTMLAttributeValue($value) . "\"";
    }

    /**
     * Generazione da funzione di un tag HTML.
     * Gli attributi sono forniti come stringa (ma bisogna fare attenzione perché
     * non verrà fatto nessun escaper di caratteri problematici) o come array
     * chiave/valore dei vari attributi.
     * Se è presente del contenuto, verrà inserito e il tag sarà chiuso con </tag>,
     * in caso contrario sarà chiuso con "/>".
     *
     * @param string $tag
     *            Nome del tag
     * @param mixed $arguments
     *            Attributi in forma di stringa o array
     * @param string $content
     *            Eventuale contenuto
     * @return string
     */
    static function tag($tag, $arguments = "", $content = "", $alwaysClosingTag = false)
    {
        $tagOpener = "<";
        $jargs = "";
        if (is_array($arguments)) {
            $args = array_map(array(
                "HTML",
                "HTMLAttribute"
            ), array_keys($arguments), $arguments);
            $jargs = " " . implode(" ", $args);
        } elseif (! empty($arguments)) {
            $jargs = " " . $arguments;
        }
        
        if (! empty($content) || $alwaysClosingTag) {
            $tagClosed = "</" . $tag . ">";
            $tagCloser = ">";
        } else {
            $tagCloser = " />";
            $tagClosed = "";
        }
        return $tagOpener . $tag . $jargs . $tagCloser . $content . $tagClosed;
    }

    /**
     * Crea una select option da un array
     *
     * @param unknown_type $data
     * @param unknown_type $valueField
     * @param unknown_type $labelField
     * @param unknown_type $selectedValue
     * @param unknown_type $extra
     * @param unknown_type $first
     * @param unknown_type $groups
     */
    static function selectFromArray($data, $valueField, $labelField, $selectedValue = null, $extra = array(), $first = true, $groups = true)
    {
        $in = "";
        if ($first)
            $in .= HTML::tag("option");
        $gr = "";
        foreach ($data as $d) {
            if ($groups) {
                $gruppo = $d['gruppo'];
                if ($gr != $gruppo) {
                    $oArgsg = array(
                        "label" => $gruppo
                    );
                    $in .= HTML::tag("optgroup", $oArgsg);
                    $gr = $gruppo;
                }
            }
            $oArgs = array(
                "value" => $d[$valueField]
            );
            if ($selectedValue == $d[$valueField])
                $oArgs['selected'] = "selected";
            $in .= HTML::tag("option", $oArgs, $d[$labelField]);
        }
        $extra["class"] = ! isset($extra["class"]) ? "form-control" : $extra["class"];
        $out = HTML::tag("select", $extra, $in);
        return $out;
    }
}