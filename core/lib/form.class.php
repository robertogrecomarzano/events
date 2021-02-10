<?php

/**
 * Classe helper per la gestione delle Form
 */
class Form
{

    /**
     * Funzione di help per le traduzioni basate sulla medesima tabella
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     */
    static public function translate($params, Smarty_Internal_Template &$smarty = null)
    {
        return Language::get($params["value"]);
    }

    /**
     * Funzione per creare un calendario
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function calendar($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "textbox";
        $args["style"] = "width:auto;";
        $args["maxlength"] = 10;

        if (isset($_POST[$args['name']]))
            $args["value"] = $_POST[$args['name']];

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        $args['class'] = "form-control";
        $args["onkeydown"] = "return keyCheck(event,this,'data')";
        $input1 = HTML::tag("input", $args);

        return "<div class='form-group'><div class='input-group date' style='max-width:150px;'>$input1<span class='input-group-addon'><i class='glyphicon glyphicon-th'></i></span></div></div>";
    }

    /**
     * Funzione per creare l'oggetto Codice fiscale
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function cf($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "textbox";
        $args["size"] = 22;
        $args["maxlength"] = 16;
        if (isset($_POST[$args['name']]))
            $args["value"] = $_POST[$args['name']];

        $args['class'] = "form-control text-uppercase";
        $args['style'] = "width:auto; float:left;";
        $input1 = HTML::tag("input", $args);
        $prefix = $params['prefix'];

        $parameters = array(
            "cognome",
            "nome",
            "sesso",
            "comune_nascita_cod",
            "cf",
            "data_nascita"
        );
        if (! empty($prefix))
            array_walk($parameters, function (&$v, $k, $prefix) {
                $v = $prefix . "_" . $v;
            }, $prefix);
        $parameters = implode(",", $parameters);
        $args2 = array(
            "value" => "...",
            "onclick" => "doCodiceFiscale($parameters)",
            "class" => "input-group-addon",
            'style' => "width:auto;"
        );

        $input2 = HTML::tag("span", $args2, '<i class="fa fa-ellipsis-h"></i>');
        return "<div class='form-group'>$input1$input2</div>";
    }

    /**
     * Funzione avanzata per la gestione dei menù a tendina in cascata con
     * Nazione > Provincia > Comune
     * Provincia e comune non sono attivati se la nazione non è ITALIA
     *
     * @param array $params
     * @return string
     */
    static public function nazione_provincia_comune($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        $nameNazione = isset($args['name']) ? ($args['name'] . "_nazione") : "";

        $nameProvincia = isset($args['name']) ? ($args['name'] . "_prov") : "";

        $paramsComune['src'] = array();
        $params2['src'] = array();

        $paramsNazione = array(
            "src" => Istat::getNazioni(),
            "first" => true,
            "iname" => $nameNazione,
            "onchange" => "getProvinceList('" . $args['name'] . "');",
            "style" => "width:auto;"
        );

        $params2 = array(
            "first" => true,
            "iname" => $nameProvincia,
            "onchange" => "getComuniList('" . $args['name'] . "');",
            "style" => "width:auto;"
        );

        $catasto = null;

        // Se è settato il comune
        if (isset($_POST[$args['name']]) && ! empty($_POST[$args['name']])) {
            $_POST[$nameNazione] = "100000100"; // ITALIA
            $_POST[$nameProvincia] = substr($_POST[$args['name']], 0, 3);
            $catasto = Istat::getBelfiore($_POST[$args['name']]);
            $_POST[$args['name'] . "_cod"] = $catasto;
        }

        $params3 = array(
            "iname" => $params['iname'] . "_cod",
            "value" => $catasto
        );

        // se è settata la nazione ITALIA
        if (isset($_POST[$nameNazione]) && $_POST[$nameNazione] == "100000100") {
            $province = Istat::getProvince();
            $params2['src'] = $province;
        }

        // se è settata la provincia
        if (isset($_POST[$nameProvincia]))
            $paramsComune['src'] = Istat::getComuni($_POST[$nameProvincia]);

        $paramsComune['first'] = true;
        $paramsComune["onchange"] = "getCodCatasto('" . $args['name'] . "');";
        $paramsComune["iname"] = $args["name"];
        $paramsComune["style"] = "width:auto;";

        if (isset($params['writable']) && ! $params['writable']) {
            $paramsComune['disabled'] = "disabled";
            $params2['disabled'] = "disabled";
        }

        $out .= "<div class='form-group input-group'><span class='input-group-addon'>" . Language::get("NAZIONE") . "</span>" . Form::select($paramsNazione) . "</div>";
        $out .= "<div class='form-group input-group'><span class='input-group-addon'>" . Language::get("PROVINCIA") . "</span>" . Form::select($params2) . "</div>";
        $out .= "<div class='form-group input-group'><span class='input-group-addon'>" . Language::get("COMUNE") . "</span>" . Form::select($paramsComune) . "</div>";
        $out .= Form::hidden($params3);

        return $out;
    }

    /**
     *
     * @param array $params
     * @return string
     */
    static public function pr_comuni($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        $name2 = isset($args['name']) ? ($args['name'] . "_prov") : "";
        // $params['width'] = "auto";
        $params['src'] = array();

        if (isset($_POST[$args['name']])) {
            $_POST[$name2] = substr($_POST[$args['name']], 0, 3);
            $catasto = Istat::getBelfiore($_POST[$args['name']]);
            $_POST[$args['name'] . "_cod"] = $catasto;
        }

        if (isset($_POST[$name2])) // se è settata la provincia
            $params['src'] = Istat::getComuni($_POST[$name2]);

        $params['first'] = true;
        $params["onchange"] = "getCodCatasto('" . $args['name'] . "');";
        $params["iname"] = $args["name"];

        $province = Istat::getProvince(true, $params["data-regione"]);
        $params2 = array(
            "src" => $province,
            "first" => true,
            "iname" => $name2,
            "onchange" => "getComuniList('" . $args['name'] . "');"
            // "style" => "width:auto;"
        );
        $params3 = array(
            "iname" => $params['iname'] . "_cod",
            "value" => $catasto
        );

        if (isset($params['writable']) && ! $params['writable']) {
            $params['disabled'] = "disabled";
            $params2['disabled'] = "disabled";
        }

        $out .= "<div class='form-group input-group'><span class='input-group-addon'>" . Language::get("PROVINCIA") . "</span>" . Form::select($params2) . "</div>";
        $out .= "<div class='form-group input-group'><span class='input-group-addon'>" . Language::get("COMUNE") . "</span>" . Form::select($params) . "</div>";
        $out .= Form::hidden($params3);

        return $out;
    }

    static public function nazioni($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        if (isset($_POST[$args['name']])) // se è settata la nazione
            $_POST[$name] = $_POST[$args['name']];

        $params['first'] = true;

        if (isset($params['writable']) && ! $params['writable']) {
            $params['disabled'] = "disabled";
            $params['data-readonly'] = "true";
        }

        $province = Istat::getNazioni(true);
        $params = array(
            "src" => $province,
            "first" => true,
            "name" => $args['name']
        );
        $out .= Form::select($params);
        return $out;
    }

    static public function regioni($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        if (isset($_POST[$args['name']])) // se è settata la nazione
            $_POST[$name] = $_POST[$args['name']];

        $params['first'] = true;

        if (isset($params['writable']) && ! $params['writable']) {
            $params['disabled'] = "disabled";
            $params['data-readonly'] = "true";
        }

        $province = Istat::getRegioni(true);
        $params = array(
            "src" => $province,
            "first" => true,
            "name" => $args['name']
        );
        $out .= Form::select($params);
        return $out;
    }

    /**
     * Controllo SelectOption per le province
     *
     * @param array $params
     * @return string
     */
    static public function province($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        if (isset($_POST[$args['name']])) // se è settata la provincia
            $_POST[$name] = $_POST[$args['name']];

        $params['first'] = true;

        if (isset($params['writable']) && ! $params['writable'])
            $params['disabled'] = "disabled";

        $province = Istat::getProvince();
        $params = array(
            "src" => $province,
            "first" => true,
            "name" => $args['name']
        );
        $out .= Form::select($params);
        return $out;
    }

    /**
     * Controllo SelectOption con le unità di misura prendendo i dati dalla tabella unita_misura
     *
     * @param array $params
     * @return string
     */
    static public function unita_misura($params)
    {
        $args = Form::processStandardParams($params);
        $out = "";

        $field = isset($params['mini']) && ! empty($params['mini']) ? "sigla" : "CONCAT(sigla,' - ',descrizione)";
        $params['src'] = array();

        $where = "";
        if (! empty($params['gruppo'])) {
            $groups = explode(",", $params['gruppo']);
            array_walk($groups, function (&$v, $k) {
                $v = "'$v'";
            });
            $where = "AND gruppo IN (" . implode(",", $groups) . ")";
        }

        $where2 = "";
        if (! empty($params['sigla'])) {
            $groups = explode(",", $params['sigla']);
            array_walk($groups, function (&$v, $k) {
                $v = "'$v'";
            });
            $where2 = "AND sigla IN (" . implode(",", $groups) . ")";
        }

        $params['src'] = Database::getRows("SELECT id,  $field AS unita_misura, gruppo FROM unita_misura WHERE 1=1 $where $where2 ORDER BY gruppo,sigla ASC");

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        if (! empty($args["data-basename"]) && ! empty($args["data-key"])) {
            if (isset($_POST[$args["data-basename"]][$args["data-key"]]))
                $args["value"] = $_POST[$args["data-basename"]][$args["data-key"]];
        } elseif (isset($_POST[$args['name']]))
            $args["value"] = $_POST[$args['name']];

        $out .= HTML::selectFromArray($params['src'], "id", "unita_misura", $args["value"], $args, true, empty($params['gruppo']));

        return $out;
    }

    /**
     * Controllo SelectOption
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function select($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);

        $args["class"] = ! isset($args["class"]) ? "form-control" : $args["class"];

        $options = "";

        if (isset($params["src"]) && empty($params["src"]) && $params["data-lockup"]) {
            $warning = Language::get("NO_VALUES");
            $out = "<span class='text-warning'><i class='fas fa-exclamation-triangle'> </i> $warning</span>";
            return $out;
        }

        if ((isset($params['first']) && $params["first"]) || empty($params["src"]))
            $options .= "<option />";

        $out = HTML::tag("select", $args, $options);

        if (isset($params["tabsrc"])) {
            $order = (isset($params["order"])) ? $params["order"] : $params[label];
            $where = (isset($params["where"])) ? $params["where"] : "1=1";
            $sql = "SELECT $params[key], $params[label] FROM $params[tabsrc] WHERE $where ORDER BY $order";
            $params['src'] = Database::getRows($sql);
        }

        if (isset($params["src"])) {

            if ($params["src"] == "")
                $out = HTML::tag("select", $args, $options);
            else {

                foreach ($params["src"] as $k => $v) {
                    $targs = array();
                    if (is_array($v)) {

                        $k = $v[$params['key']];
                        $targs["value"] = (string) $k;

                        if (isset($_POST[$args["name"]]) && ($k == $_POST[$args["name"]] || in_array($k, $_POST[$args["name"]])))
                            $targs["selected"] = "selected";
                        elseif (isset($params["value"]) && $k == $params["value"])
                            $targs["selected"] = "selected";

                        foreach (array_keys($params) as $param) {
                            $exp_key = explode('-', $param);
                            if ($exp_key[0] == 'data')
                                if (isset($params[$param]))
                                    $targs[$param] = $v[$params[$param]];
                        }

                        $v = $v['label'];
                    } else {

                        if (isset($params['key']))
                            $k = $v[$params['key']];

                        $targs["value"] = (string) $k;
                        if (! empty($params["data-basename"]) && ! empty($params["data-key"])) {
                            if (isset($_POST[$params["data-basename"]][$params["data-key"]])) {
                                if ($k == $_POST[$params["data-basename"]][$params["data-key"]])
                                    $targs["selected"] = "selected";
                                $params["value"] = $_POST[$params["data-basename"]][$params["data-key"]];
                            }
                        } elseif (isset($_POST[$args["name"]]) && ($k == $_POST[$args["name"]] || in_array($k, $_POST[$args["name"]])))
                            $targs["selected"] = "selected";
                        elseif (isset($params["value"]) && $k == $params["value"])
                            $targs["selected"] = "selected";
                        if (isset($params['label']))
                            $v = $v[$params['label']];
                    }
                    $options .= HTML::tag("option", $targs, $v);
                }

                if (isset($params['writable']) && ! $params['writable'])
                    $args['disabled'] = "disabled";

                // $args["style"] = "width:auto;";
                $out = HTML::tag("select", $args, $options);
            }
        }
        return $out;
    }

    /**
     * Controllo SelectOptionGroup
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function selectGroup($params, $smarty = null)
    {
        $out = "";
        $args = Form::processStandardParams($params);
        $out = HTML::selectFromArray($params["src"], $params['key'], $params['label'], $_POST[$args["name"]], $args);
        return $out;
    }

    /**
     * Controllo singolo checkbox
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function check($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "checkbox";
        $args["value"] = isset($params["value"]) ? $params["value"] : 1;

        if (isset($_POST[$args['name']]) && $_POST[$args['name']] == 1)
            $args["checked"] = "checked";

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        $tag = HTML::tag("input", $args);

        if (empty($params['label']))
            $params['label'] = "&nbsp;";

        $tag = HTML::tag("label", array(), $tag . "<span class='label-text'>" . $params['label'] . "</span>");

        return HTML::tag("div", array(
            "class" => "form-check"
        ), $tag);
    }

    /**
     * Lista di checkbox
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function checks($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $eventHandlers = Form::extractHandlers($params);
        $entries = array();

        if (isset($params["src"]) && empty($params["src"]) && $params["data-lockup"]) {
            $warning = Language::get("NO_VALUES");
            $out = "<span class='text-warning'><i class='fas fa-exclamation-triangle'> </i> $warning</span>";
            return $out;
        }

        if (isset($params["src"])) {
            $c = 0;

            foreach ($params["src"] as $k => $v) {

                $targs = array();

                if (is_array($v)) {
                    $k = $v[$params['key']];
                    foreach (array_keys($params) as $param) {
                        $exp_key = explode('-', $param);
                        if ($exp_key[0] == 'data')
                            if (isset($params[$param]))
                                $targs[$param] = $v[$params[$param]];
                    }
                    $v = $v['label'];
                }

                $id = $args['name'] . "_" . $c ++;

                $targs = array_merge($targs, array(
                    "type" => "checkbox",
                    "id" => $id,
                    "value" => $k,
                    "name" => $args['name'] . "[$id]",
                    "data-value" => strtolower($v)
                ));

                if (isset($args["required"]))
                    $targs["required"] = $args["required"];

                if (isset($params['writable']) && ! $params['writable'])
                    $targs['disabled'] = "disabled";

                $targs = array_merge($targs, $eventHandlers);
                if (isset($_POST[$args["name"]]) && in_array($k, $_POST[$args["name"]]))
                    $targs["checked"] = "checked";

                $tag = HTML::tag("input", $targs);

                $tag = HTML::tag("label", array(), $tag . "<span class='label-text'>" . $v . "</span>");

                $tag = HTML::tag("div", array(
                    "class" => "form-check"
                ), $tag);

                $cols = $params["cols"];
                switch ($cols) {
                    case 1:
                        $col = 12;
                        break;
                    case 2:
                        $col = 6;
                        break;
                    case 3:
                        $col = 4;
                        break;
                    case 4:
                        $col = 3;
                        break;
                    case 6:
                        $col = 2;
                        break;
                    default:
                        $col = 4;
                        break;
                }
                $entries[] = HTML::tag("div", array(
                    "class" => "col-md-$col col-sm-$col col-xs-$col"
                ), $tag);
            }
        }
        return implode("", $entries);
    }

    /**
     * Controllo singolo radiobutton
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function radio($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "radio";

        if (isset($_POST[$args["name"]]) && $args["value"] == $_POST[$args["name"]])
            $args["checked"] = "checked";

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        $tag = HTML::tag("input", $args);

        if (isset($params['label']))
            $tag = HTML::tag("label", array(), $tag . "<span class='label-text'>" . $params['label'] . "</span>");

        return HTML::tag("div", array(
            "class" => "form-check"
        ), $tag);
    }

    /**
     * Lista di radiobutton
     * Parametri accettati:
     * - standard (id, name, class, width, event handlers, iname [=id+name])
     * - src (array contenente i dati)
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function radios($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);

        $eventHandlers = Form::extractHandlers($args);

        $entries = array();

        if (isset($params["src"])) {
            $c = empty($params['from']) ? 0 : $params['from'];
            foreach ($params["src"] as $k => $v) {

                $targs = [];

                if (is_array($v)) {
                    $k = $v[$params['key']];
                    foreach (array_keys($params) as $param) {
                        $exp_key = explode('-', $param);
                        if ($exp_key[0] == 'data')
                            if (isset($params[$param]))
                                $targs[$param] = $v[$params[$param]];
                    }
                    $v = $v['label'];
                }

                $id = $args['name'] . "_" . $c ++;

                $targs = array_merge($targs, array(
                    "type" => "radio",
                    "id" => $id,
                    "name" => $args['name'],
                    "value" => $k
                ));

                $targs = array_merge($targs, $eventHandlers);

                if (isset($params['writable']) && ! $params['writable'])
                    $targs['disabled'] = "disabled";

                if (isset($_POST[$args["name"]]) && $k == $_POST[$args["name"]])
                    $targs["checked"] = "checked";
                elseif ($args["data-value"] == $k)
                    $targs["checked"] = "checked";

                $tag = HTML::tag("input", $targs);

                $entries[] = HTML::tag("div", array(
                    "class" => $args["inline"] ? "col-md-4 col-sm-4 col-xs-4" : ""
                ), HTML::tag("div", array(
                    "class" => $args["inline"] ? "radio-inline" : "form-check"
                ), HTML::tag("label", array(
                    "for" => $id
                ), $tag . "<span class='label-text'>$v</span>")));
            }
        }
        return implode("", $entries);
    }

    /**
     * Controllo textbox.
     * Parametri accettati:
     * - standard (id, name, class, width, event handlers, iname [=id+name])
     * - size
     * - max [=maxlength]
     *
     * @param array $params
     * @param array $smarty
     * @return string
     */
    static public function textbox($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = isset($params["type"]) ? $params["type"] : "textbox";
        $args["class"] = ! isset($args["class"]) ? "form-control" : $args["class"];
        if (isset($params["type"]))
            $args["type"] = $params["type"];

        if (! empty($args["data-basename"]) && ! empty($args["data-key"])) {
            if (isset($_POST[$args["data-basename"]][$args["data-key"]]))
                $args["value"] = $_POST[$args["data-basename"]][$args["data-key"]];
        } elseif (isset($_POST[$args['name']]))
            $args["value"] = $_POST[$args['name']];

        if (isset($params["size"])) {
            $args["size"] = $params["size"];
        }
        // FIXME: rgm, capire come gestire $args["style"] = "width:auto;";

        if (isset($params["style"]))
            $args["style"] = $params["style"];

        if (isset($params["max"]))
            $args["maxlength"] = $params["max"];

        if (isset($_POST[$args['name']]))
            $args["value"] = $_POST[$args['name']];

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        $tag = HTML::tag("input", $args);
        return $tag;
    }

    /**
     * Generazione textarea
     *
     * @param array $params
     * @param array $smarty
     *
     * @return string
     */
    static public function textarea($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "textbox";
        $args["class"] = ! isset($args["class"]) ? "form-control" : "";
        if (isset($params["cols"]))
            $args["cols"] = $params["cols"];
        if (isset($params["rows"]))
            $args["rows"] = $params["rows"];
        if (isset($params["max"]))
            $args["maxlength"] = $params["max"];
        $value = isset($_POST[$args['name']]) ? $_POST[$args['name']] : "";

        if (isset($params['writable']) && ! $params['writable'])
            $args['disabled'] = "disabled";

        $tag = HTML::tag("textarea", $args, htmlspecialchars($value), true);
        return $tag;
    }

    /**
     * Estrae tutti gli event handler da un set di parametri.
     * La funzione
     * è stata estrapolata dall'elaborazione dei parametri perché può essere
     * utile sia per i singoli tag (e quindi usata come inizio di
     * Form::processStandardParams()), sia per i campi con tag multipli
     * (checks, radios) in modo che essi ereditino gli handler specificati
     *
     * @param array $p
     *            Parametri
     * @return array
     */
    static private function extractHandlers($p)
    {
        $args = array();
        if (isset($p["onclick"]))
            $args["onclick"] = $p["onclick"];
        if (isset($p["onfocus"]))
            $args["onfocus"] = $p["onfocus"];
        if (isset($p["onblur"]))
            $args["onblur"] = $p["onblur"];
        if (isset($p["onchange"]))
            $args["onchange"] = $p["onchange"];
        if (isset($p["onkeypress"]))
            $args["onkeypress"] = $p["onkeypress"];
        if (isset($p["onkeydown"]))
            $args["onkeydown"] = $p["onkeydown"];
        if (isset($p["onkeyup"]))
            $args["onkeyup"] = $p["onkeyup"];
        if (isset($p["onload"]))
            $args["onload"] = $p["onload"];
        return $args;
    }

    /**
     * Processa i parametri standard dei controlli della form:
     * - event handlers (onclick, onblur...)
     * - width
     * - class
     * - id
     * - name
     * - iname [id+name]
     *
     * @param array $p
     *            Array associativo coi parametri
     * @return array Array associativo con gli attributi html corrispondenti e valorizzati
     */
    static private function processStandardParams($p)
    {
        $args = Form::extractHandlers($p);

        // -----------------
        // Common attributes
        // -----------------

        if (isset($p['width']))
            $args["style"] = "width:" . $p['width'];
        if (isset($p["class"]))
            $args["class"] = $p["class"];
        if (isset($p["id"]))
            $args["id"] = $p["id"];
        if (isset($p["name"]))
            $args["name"] = $p["name"];
        if (isset($p["disabled"]))
            $args["disabled"] = $p["disabled"];
        if (isset($p["value"]))
            $args["value"] = $p["value"];
        if (isset($p["title"]))
            $args["title"] = $p["title"];
        if (isset($p["style"]))
            $args["style"] = $p["style"];
        if (isset($p["tabindex"]))
            $args["tabindex"] = $p["tabindex"];
        if (isset($p["img"]))
            $args["img"] = $p["img"];

        if (isset($p["validation"]))
            $args["validation"] = $p["validation"];
        if (isset($p["writable"]))
            $args["writable"] = $p["writable"];
        if (isset($p["read-allowed"]))
            $args["read-allowed"] = $p["read-allowed"];
        if (isset($p["mini"]))
            $args["mini"] = $p["mini"];
        if (isset($p["parent"]))
            $args["parent"] = $p["parent"];

        if (isset($p["required"]))
            $args["required"] = $p["required"];
        if (isset($p["autofocus"]))
            $args["autofocus"] = $p["autofocus"];
        if (isset($p["placeholder"]))
            $args["placeholder"] = $p["placeholder"];
        if (isset($p["inline"]))
            $args["inline"] = $p["inline"];

        $keys = array_keys($p);
        foreach ($keys as $k)
            if (preg_match("/[^data-]/", $k))

                $args[$k] = $p[$k];

        if (isset($p["iname"])) {
            $args["id"] = $p["iname"];
            $args["name"] = $p["iname"];
        }
        return $args;
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function edit($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        $id = $params['id'];
        $js = "form_mod";
        $img = "pencil";
        $class = "btn btn-warning btn-xs";

        $params["type"] = "button";

        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("EDIT");
        $title = $txt;

        if (isset($params['inline']) && $params['inline']) {
            $js = "form_mod2";
            $img = "save";
            $txt = Language::get("SAVE");
            $class = "btn btn-primary";
            $params["text"] = Language::get("SAVE");
            $params["type"] = "submit";
        }
        if (isset($params['save']) && $params['save'])
            $img = "save";

        if (! $params["text"])
            $txt = null;

        $class = isset($params["class"]) ? $params["class"] : $class;

        $img_style = (isset($params['data-img_style']) && ! empty($params['data-img_style'])) ? $params['data-img_style'] : "fa";

        $js = (isset($params['onclick']) && ! empty($params['onclick'])) ? $params['onclick'] : "$js(this,$id);";

        return HTML::tag("button", array(
            "type" => $params["type"],
            "title" => $title,
            "onclick" => $js,
            "class" => $class
        ), "<i class='$img_style fa-$img'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function undo($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$delete === false)
            return;

        $id = $params['id'];
        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("UNDO");
        $title = $txt;
        if (! $params["text"])
            $txt = null;

        return HTML::tag("button", array(
            "type" => "button",
            "title" => $title,
            "onclick" => "form_annulla(this,'$id');",
            "class" => "btn btn-default"
        ), "<i class='fas fa-undo'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function delete($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$delete === false)
            return;

        $id = $params['id'];
        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("DELETE");
        $title = (isset($args['title']) && ! empty($args['title'])) ? $args['title'] : $txt;
        if (! $params["text"])
            $txt = null;

        $class = isset($params["class"]) ? $params["class"] : "btn btn-danger btn-xs";

        return HTML::tag("button", array(
            "type" => "button",
            "title" => $title,
            "onclick" => "form_del(this,$id);",
            "class" => $class
        ), "<i class='fas fa-trash'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function add($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$add === false)
            return;

        $js = (isset($params['onclick']) && ! empty($params['onclick'])) ? $params['onclick'] : "form_add(this);";

        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("SAVE");

        $class = isset($params["class"]) ? $params["class"] : "btn btn-default";

        return HTML::tag("button", array(
            "type" => "button",
            "title" => $txt,
            "onclick" => $js,
            "class" => $class
        ), "<i class='fas fa-plus'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function add2($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$add === false)
            return;

        $js = (isset($params['onclick']) && ! empty($params['onclick'])) ? $params['onclick'] : "return form_add2(this);";

        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("SAVE");

        $class = isset($params["class"]) ? $params["class"] : "btn btn-primary";

        $type = (isset($params['type']) && ! empty($params['type'])) ? $params['type'] : "submit";

        return HTML::tag("button", array(
            "type" => $type,
            "title" => $txt,
            "onclick" => $js,
            "class" => $class
        ), "<i class='fas fa-plus'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function rilascia($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        $class = isset($params["class"]) ? $params["class"] : "btn btn-info";

        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("RELEASE");

        return HTML::tag("button", array(
            "type" => "button",
            "title" => $txt,
            "onclick" => "form_rilascia(this);",
            "class" => $class
        ), "<i class='fas fa-repeat'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function integra($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        return HTML::tag("button", array(
            "type" => "button",
            "title" => Language::get("INTEGRA"),
            "onclick" => "form_integra(this);",
            "class" => "btn btn-primary"
        ), "<i class='fas fa-repeat'></i> " . Language::get("INTEGRA"));
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function rettifica($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        $params["writable"] = true;

        if ($params["value"] == "start") {
            return HTML::tag("button", array(
                "type" => "button",
                "title" => Language::get("INTEGRA_START"),
                "onclick" => "form_rettifica(this);",
                "class" => "btn btn-primary"
            ), "<i class='fas fa-indent'></i> " . Language::get("INTEGRA_START"));
        } elseif ($params["value"] == "end") {

            return HTML::tag("button", array(
                "type" => "button",
                "title" => Language::get("INTEGRA_END"),
                "onclick" => "form_rilasciarettifica(this);",
                "class" => "btn btn-primary"
            ), "<i class='fas fa-check-square'></i> " . Language::get("INTEGRA_END"));
        }
    }

    /**
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static function confirm($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        $params = Form::processStandardParams($params);
        $confirm = (isset($params['onclick']) && ! empty($params['onclick'])) ? $params['onclick'] : "form_confirm(this);";
        $txt = (isset($params['value']) && ! empty($params['value'])) ? $params['value'] : Language::get("CONFIRM");
        $img = (isset($params['img']) && ! empty($params['img'])) ? $params['img'] : "check";
        $img_style = (isset($params['data-img_style']) && ! empty($params['data-img_style'])) ? $params['data-img_style'] : "fas";

        return HTML::tag("button", array_merge($params, array(
            "type" => "button",
            "title" => $txt,
            "onclick" => $confirm,
            "class" => "btn btn-primary"
        )), "<i class='$img_style fa-$img'></i> " . $txt);
    }

    /**
     * Controllo button.
     * Parametri accettati:
     * - standard (id, name, class, width, event handlers, iname [=id+name])
     * - size
     * - max [=maxlength]
     *
     * @param array $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     */
    static public function button($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $p = Page::getInstance();
        if ($p::$write === false)
            return;

        $args = Form::processStandardParams($params);
        $txt = (isset($args['value']) && ! empty($args['value'])) ? $args['value'] : Language::get("CONFIRM");

        $title = (isset($args['title']) && ! empty($args['title'])) ? $args['title'] : $txt;
        $img = (isset($args['img']) && ! empty($args['img'])) ? $args['img'] : "check";
        $confirm = (isset($params['onclick']) && ! empty($params['onclick'])) ? $params['onclick'] : "form_confirm(this);";

        $class = isset($args["class"]) ? $args["class"] : "btn btn-default";

        if ($params["text"] == false)
            $txt = null;

        $img_style = (isset($params['data-img_style']) && ! empty($params['data-img_style'])) ? $params['data-img_style'] : "fas";

        return HTML::tag("button", array_merge($args, array(
            "type" => "button",
            "title" => $title,
            "onclick" => $confirm,
            "class" => $class
        )), "<i class='$img_style fa-$img'></i> " . $txt);
    }

    /**
     * Controllo link.
     */
    static public function link($params, $smarty = null)
    {
        if (isset($params['writable']) && ! $params['writable'])
            return;

        if (User::isReadOnly() && ! $params["read-allowed"])
            return;

        $args = Form::processStandardParams($params);
        $txt = (isset($args['value']) && ! empty($args['value'])) ? $args['value'] : Language::get("CONFIRM");
        $title = (isset($args['title']) && ! empty($args['title'])) ? $args['title'] : $txt;
        $target = (isset($args['target']) && ! empty($args['target'])) ? $args['target'] : "";

        $href = $args['href'];
        $url = '';

        $url .= strpos($href, 'http://') !== false || strpos($href, 'https://') !== false ? '' : 'http://';

        $url .= $href;

        $img = (isset($args['img']) && ! empty($args['img'])) ? $args['img'] : null;
        $img_style = (isset($params['data-img_style']) && ! empty($params['data-img_style'])) ? $params['data-img_style'] : "fa";
        if (! empty($target))
            $jsAction = "window.open('" . $url . "','$target')";
        else
            $jsAction = "window.location.href='" . $url . "'";

        if (isset($params['onclick']) && ! empty($params['onclick']))
            $js = $params['onclick'] . $jsAction;
        else
            $js = $jsAction;

        $txt = $params["text"] ? $txt : "";

        $class = isset($args["class"]) ? $args["class"] : "btn btn-default";

        return HTML::tag("button", array(
            "type" => "button",
            "title" => trim(preg_replace('/\s\s+/', ' ', $title)),
            "onclick" => $js,
            "class" => $class
        ), "<i class='$img_style fa-$img'></i> " . $txt);
    }

    /**
     *
     * @param array $params
     * @param Smarty $smarty
     * @return string
     */
    static function hidden($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["type"] = "hidden";
        return HTML::tag("input", $args);
    }

    /**
     *
     * @param array $mappings
     * @param array $other
     * @return string
     */
    static function mappingsSQL($mappings, $other = array())
    {
        if (! empty($other))
            $all = array_merge($mappings, $other);
        else
            $all = $mappings;
        $fields = array_keys($all);
        array_walk($fields, function (&$v, $k) {
            $v .= " = ?";
        });
        return implode(", ", $fields);
    }

    /**
     *
     * @param array $mappings
     * @param array $other
     * @return multitype:
     */
    static function mappingsPost($mappings, $other = array())
    {
        $fields = array_values($mappings);
        array_walk($fields, function (&$v, $k) {
            $v = (isset($_POST[$v]) && $_POST[$v] != "") ? $_POST[$v] : null;
        });
        return ! empty($other) ? array_merge($fields, array_values($other)) : $fields;
    }

    /**
     *
     * @param string $action
     * @param int $actionId
     * @param string $table
     * @param string $tablePk
     * @param array $mappings
     * @param array $other
     */
    static function processAction(&$action, &$actionId, $table, $tablePk, $mappings, $other = array())
    {
        try {

            $page = Page::getInstance();
            $return = null;

            switch ($action) {
                case "del":
                    $fields = Database::getFieldsString($table);
                    $fields = explode(",", $fields);
                    if (in_array("record_attivo", $fields)) {
                        $sql = "UPDATE $table SET record_attivo=0 ";
                        if (in_array("ts_delete", $fields))
                            $sql .= ", ts_delete=NOW()";
                        $sql .= " WHERE $tablePk = ?";
                    } else
                        $sql = "DELETE FROM $table WHERE $tablePk = ?";
                    $res = Database::query($sql, array(
                        $actionId
                    ));
                    unset($action);
                    if ($res)
                        $page->addMessages(Language::get("DELETE_MSG"));
                    break;

                case "add2":
                    $sql = "INSERT INTO $table SET " . Form::mappingsSql($mappings, $other);
                    $params = Form::mappingsPost($mappings, $other);
                    $res = Database::query($sql, $params);
                    $db = Database::getDb();
                    $actionId = $db->lastInsertId();
                    if ($res) {
                        $page->addMessages(Language::get("INSERT_MSG"));
                        $return = $actionId;
                    }
                    break;

                case "mod2":
                    $fields = Database::getFieldsString($table);
                    $fields = explode(",", $fields);

                    $sql = "UPDATE $table SET " . Form::mappingsSql($mappings, $other);
                    if (in_array("ts_update", $fields))
                        $sql .= " , ts_update=NOW() ";
                    $sql .= " WHERE `$tablePk` = ?";

                    $params = Form::mappingsPost($mappings, $other);
                    $params[] = $actionId;
                    $res = Database::query($sql, $params);

                    if ($res)
                        $page->addMessages(Language::get("UPDATE_MSG"));
                    $return = $actionId;

                    break;
                default:
                    $return = $actionId;
            }
            return $return;
        } catch (Exception $e) {
            $page->addError(Language::get("ERROR") . $e->getMessage());
            return null;
        }
    }

    /**
     *
     * @param array $righe
     * @param string $action
     * @param int $actionId
     * @param string $tablePk
     * @param array $mappings
     * @param Page $page
     */
    static function mappingsAssignPost($righe, $action, $actionId, $tablePk, $mappings, &$page)
    {
        $p = Page::getInstance();
        $errors = count($p->errors);
        $warnings = count($p->warnings);

        if (($actionId > 0 && $action == "mod") || (($errors + $warnings) > 0 && ($action == "mod2" || $action == "add2"))) {
            foreach ($righe as $k => $r) {
                if ($r[$tablePk] == $actionId) {
                    $riga = $righe[$k];
                    foreach ($mappings as $sql => $html)
                        $_POST[$html] = $riga[$sql];
                    break;
                }
            }
        } else if ((empty($p->errors) && ($action == "mod2" || $action == "add2")) || (! empty($p->errors) && $action == "mod2"))
            unset($_POST);

        $page->assign("pk", $tablePk);
        $page->assign("pkValue", $actionId);
        $page->assign("action", $action);
    }

    /**
     * Controllo la presenza di righe duplicate
     *
     * @param string $table
     * @param array $mappings
     * @param array $dupeFields
     * @param array $other
     * @param string $key
     * @param mixed $keyValue
     * @return boolean
     */
    static function checkDupes($table, $mappings, $dupeFields, $other = array(), $key = null, $keyValue = null)
    {
        $wheres = null;
        $parameters = null;

        foreach ($dupeFields as $d) {
            $wheres[] = $d . " = ?";
            $parameters[] = $_POST[$mappings[$d]];
        }

        foreach ($other as $k => $v) {
            $wheres[] = $k . " = ?";
            $parameters[] = $v;
        }

        if (! empty($key) && ! empty($keyValue)) {
            $wheres[] = $key . " != ?";
            $parameters[] = $keyValue;
        }

        $c = Database::getCount($table, implode(" AND ", $wheres), $parameters);
        return $c > 0;
    }

    /**
     * Apre un Form
     *
     * @param array $params
     * @param array $smarty
     * @return string
     */
    static function form_open($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);
        $args["method"] = "post";

        $args["data-toggle"] = "validator";

        return HTML::tag("form", $args);
    }

    /**
     * Chiude un Form aggiungendo i campi hidden action, action_id e token
     *
     * @param array $params
     * @param array $smarty
     * @return string
     */
    static function form_close($params, $smarty = null)
    {
        $page = Page::getInstance();
        $alias = $page->alias;
        $form_token = $page->token;
        $action = $page->assigns["action"];
        $action_id = $page->assigns["pkValue"];

        $form_alias = Form::hidden(array(
            "id" => "form_alias",
            "name" => "form_alias",
            "value" => $alias
        ));

        $form_action = Form::hidden(array(
            "id" => "form_action",
            "name" => "form_action",
            "value" => $action
        ));
        $form_id = Form::hidden(array(
            "id" => "form_id",
            "name" => "form_id",
            "value" => $action_id
        ));

        return $form_alias . $form_action . $form_id . $form_token . "</form>";
    }

    /**
     * Crea un Form da usare per le pagine con tabelle per inserire/modificare/eliminare record
     * Include dinamicamente il file table.tpl o add.tpl a seconda se si è in visualizzazione o inserimento/modifica di un record
     *
     * @param array $params
     * @param array $smarty
     * @return string
     */
    static function form_table($params, $smarty = null)
    {
        $args = Form::processStandardParams($params);

        $src = $params["src"];

        $custom_template = $src["custom-template"];

        $fields = $src["fields"];
        $pk = $src["pk"];
        $title = isset($src["title"]) ? $src["title"] : "Registra una nuova riga";
        $inline = isset($src["inline"]) ? $src["inline"] : false;
        $writable = isset($src["writable"]) ? $src["writable"] : true;
        $add = isset($src["add"]) ? $src["add"] : true;
        $delete = isset($src["delete"]) ? $src["delete"] : true;
        $rows = $src["rows"];

        $args["method"] = "post";
        $args["class"] = "form-horizontal";

        $page = Page::getInstance();
        $alias = $page->alias;
        $action = $page->assigns["action"];
        $action_id = $page->assigns["pkValue"];
        $errors = count($page->errors);
        $warnings = count($page->warnings);

        if ($action == "annulla")
            unset($_POST);

        if (! $inline && ($action == 'mod' || $action == "add" || (($errors + $warnings) > 0 && ($action == "mod2" || $action == "add2")))) {
            /**
             * Edit non in linea
             */
            if ($custom_template && ! $inline && $writable) {

                $template = $page->getTemplateServerPath("add");
                $content = $page->tpl->fetch($template);
            } else {
                $content = "";
                $edit = "";
                $btn_add_edit = $writable ? self::add_edit(null) : null;
                foreach ($fields as $field => $value) {
                    if ($value["read"])
                        continue;
                    $others = $value["others"];
                    $others["iname"] = $field;
                    $rowObj = self::form_table_obj($value, $others);
                    $edit .= "<div class='form-group'><label class='control-label col-md-3 col-sm-3 col-xs-12'>" . $value["label"] . "</label><div class='col-md-9 col-sm-9 col-xs-12'>$rowObj</div></div>";
                    $content = $edit . "<div class='btn btn-group'>" . $btn_add_edit . "</div>";
                }
            }
        } else {
            /**
             * Visualizzazione tabella
             */
            $btn = null;
            if (! $inline && ($writable && $add))
                $btn = "<div class='btn btn-group'>" . self::add(array(
                    "value" => $title,
                    "text" => true,
                    "title" => $title,
                    "class" => "btn btn-primary",
                    "writable" => $writable
                )) . "</div>";

            if ($custom_template && ! $inline) {
                $template = $page->getTemplateServerPath("table");
                $table = $page->tpl->fetch($template);
            } else {
                $table = "";
                $rowsOut = "";

                $header = HTML::tag("th", array(), "&nbsp;");
                foreach ($fields as $field => $value)
                    $header .= HTML::tag("th", array(), $value["label"]);

                foreach ($rows as $row) {
                    $rowOut = "";
                    $btn_edit = self::edit(array(
                        "text" => false,
                        "id" => $row[$pk],
                        "writable" => $writable
                    ));
                    $btn_delete = null;
                    if ($delete)
                        $btn_delete = self::delete(array(
                            "text" => false,
                            "id" => $row[$pk],
                            "writable" => $writable || $delete
                        ));

                    if ($writable && $inline && ($row[$pk] == $action_id && $action == 'mod')) {
                        /**
                         * Riga per edit inline
                         */
                        $btn_edit = self::edit(array(
                            "id" => $row[$pk],
                            "inline" => true,
                            "writable" => $writable
                        ));
                        $btn_annulla = self::undo(array(
                            "text" => true,
                            "writable" => $writable
                        ));
                        $rowEdit = HTML::tag("td", array(), $btn_edit . $btn_annulla);
                        foreach ($fields as $field => $value) {
                            if ($value["read"])
                                continue;
                            $others = $value["others"];
                            $others["iname"] = $field;
                            $rowObj = self::form_table_obj($value, $others);
                            $rowEdit .= HTML::tag("td", array(), HTML::tag("div", array(
                                "class" => "form-group"
                            ), Html::tag("label", array(
                                "class" => "control-label"
                            ), $value["label"]) . $rowObj));
                        }

                        $tableEdit = HTML::tag("div", array(
                            "class" => "table-responsive"
                        ), HTML::tag("table", array(
                            "class" => "table table-striped no-footer dtr-inline",
                            "id" => $src["id"]
                        ), $rowEdit));
                    } else {
                        $rowOut .= HTML::tag("td", array(), $btn_edit . $btn_delete);
                        foreach ($fields as $field => $value) {

                            switch ($value["type"]) {
                                case "checkbox":
                                case "radio":
                                    $valore = $row[$field] ? "<i class='fas fa-check'></i>" : null;
                                    break;
                                case "link":
                                    $valore = null;
                                    if (! empty($row[$field])) {
                                        $href = isset($value["value"]) ? $row[$value["value"]] : $row[$field];
                                        $target = isset($value["others"]["target"]) ? $value["others"]["target"] : "";
                                        $valore = self::link([
                                            "href" => $href,
                                            "target" => $target,
                                            "class" => 'btn btn-link',
                                            "img" => "download",
                                            "text" => false,
                                            "title" => $row[$field]
                                        ]);
                                    }
                                    break;
                                default:
                                    $valore = isset($value["value"]) ? $row[$value["value"]] : $row[$field];
                                    break;
                            }

                            $rowOut .= HTML::tag("td", array(), $valore);
                        }

                        $rowOut = HTML::tag("tr", array(), $rowOut);
                    }
                    $rowsOut .= $rowOut;
                }

                if ($inline && $writable && ($action_id == 0 || $action == "add2" || $action == "mod2" || $action == "del")) {
                    /**
                     * Riga per inserimento in modalità inline (riga sopra la tabella)
                     */
                    if ($add)
                        $btn_add = self::add2(array(
                            "id" => $row[$pk],
                            "title" => $title
                        ));
                    $rowAdd = HTML::tag("td", array(), $btn_add);
                    foreach ($fields as $field => $value) {
                        if ($value["read"])
                            continue;
                        $others = $value["others"];
                        $others["iname"] = $field;
                        $rowObj = self::form_table_obj($value, $others);
                        $rowAdd .= HTML::tag("td", array(), HTML::tag("div", array(
                            "class" => "form-group"
                        ), Html::tag("label", array(
                            "class" => "control-label"
                        ), $value["label"]) . $rowObj));
                    }

                    $tableAdd = HTML::tag("div", array(
                        "class" => "table-responsive"
                    ), HTML::tag("table", array(
                        "class" => "table table-striped no-footer dtr-inline"
                    ), $rowAdd));
                }

                $header = HTML::tag("tr", array(), $header);
                $header = HTML::tag("thead", array(), $header);
                $table = HTML::tag("table", array(
                    "class" => "table table-striped table-hover dataTable no-footer dtr-inline",
                    "id" => $src["id"]
                ), $header . $rowsOut);
            }
            $content = $btn . $tableEdit . $tableAdd . $table;
        }

        $form_alias = Form::hidden(array(
            "id" => "form_alias",
            "name" => "form_alias",
            "value" => $alias
        ));

        $form_action = Form::hidden(array(
            "id" => "form_action",
            "name" => "form_action",
            "value" => $action
        ));
        $form_id = Form::hidden(array(
            "id" => "form_id",
            "name" => "form_id",
            "value" => $action_id
        ));

        $form_token = $page->token;

        return HTML::tag("form", $args, $content . $form_alias . $form_action . $form_id . $form_token, true);
    }

    /**
     * Ritorna l'oggetto html in base al tipo passato come parametro
     *
     * @param string $type
     * @param array $others
     * @return string
     */
    private static function form_table_obj($value, $others)
    {
        $obj = null;

        if ($value["writable"] === false)
            $others["disabled"] = "disabled";

        if (isset($value["name"]) && ! empty($value["name"]))
            $others["iname"] = $value["name"];

        $type = $value["type"];

        switch ($type) {
            case "label":
                $obj = Html::tag("label", null, $value["value"]);
                break;
            case "text":
                $obj = self::textbox($others);
                break;
            case "checkbox":
                $obj = self::check($others);
                break;
            case "textarea":
                $obj = self::textarea($others);
                break;
            case "calendar":
                $obj = self::calendar($others);
                break;
            case "radio":
                $obj = self::radio($others);
                break;
            case "select":
                $obj = self::select($others);
                break;
            case "pr_comuni":
                $obj = self::pr_comuni($others);
                break;
            case "um":
                $obj = self::unita_misura($others);
                break;
            default:
                $others["type"] = $type;
                $obj = self::textbox($others);
                break;
        }
        return $obj;
    }

    /**
     * Genera il bottone per inserire o modificare un record in una tabella
     * quando si decide di usare l'inserimento con template separato e non inline
     */
    static function add_edit($params, $smarty = null)
    {
        $page = Page::getInstance();
        $actionId = $page->assigns["pkValue"];
        $action = $page->assigns["action"];
        $annulla = self::undo(array(
            "text" => true
        ));
        if ($actionId > 0 && ($action == 'mod' || $action == "mod2"))
            $btn = self::edit(array(
                "inline" => isset($params["onclick"]) ? false : true, // FIXME: questa variabile a true fa si che edit() imposti type="submit" e quindi i controlli JS non funzionano. Verificare bene
                "text" => true,
                "class" => "btn btn-primary",
                "onclick" => $params["onclick"],
                "id" => $actionId,
                "value" => Language::get("SAVE")
            ));

        if ($action == 'add' || $action == "add2")
            $btn = self::add2(array(
                "text" => true,
                "class" => "btn btn-primary",
                "onclick" => $params["onclick"],
                "type" => $params["type"]
            ));

        return $btn . $annulla;
    }

    /**
     * Crea un wizard per gli elementi inseriti dalla classe
     * all'interno della variabile Page::wizard
     *
     * @return void|string
     */
    static function wizard()
    {
        if (empty(Page::$wizard))
            return;

        $page = Page::getInstance();
        if (in_array($page->assigns["action"], array(
            "mod",
            "add"
        )))
            return;

        $wizard = Page::$wizard;
        $id = Page::getId();

        $out = "";
        $i = 1;
        $out .= '<ol class="progress-track">';

        foreach ($wizard as $k => $v) {
            $class = $page->alias == $k ? "progress-current" : "";
            $link = Config::$urlRoot . "/p/" . $k . "/" . $id;

            $out .= '<li class="progress-done ' . $class . '">
    <center>
<a href="' . $link . '">
      <div class="icon-wrap">
        <svg class="icon-state icon-check-mark">
          <use xlink:href="#icon-check-mark"></use>
        </svg>
    
        <svg class="icon-state icon-down-arrow">
          <use xlink:href="#icon-down-arrow"></use>
        </svg>
      </div>
      <span class="progress-text">' . $v . '</span>
</a>
    </center>
  </li>';

            $i ++;
        }
        $out .= "</ol>";

        return $out;
    }
}