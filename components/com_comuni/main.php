<?php

class Comuni extends Plugin
{

    public $scripts = array(
        "comuni.js"
    );

    public $template = array();

    public function init()
    {
        ;
        // ancora non faccio nulla
    }

    /**
     * Ritorna la lista delle province di una nazione (ITALIA) in formato jSON
     *
     * @param string $nazione
     */
    public function listaProvince($nazione)
    {

        // NOTE: In quesa procedura, è stato usato un array di array per poter mantenere l'ordine corretto delle province
        // essendo queste composte dal codice_prov con zeri iniziali e alcune voci senza zeri iniziali
        // la funzione json_encode altrimenti andrebbe a cambiare l'ordine impostato nella query sql
        $json = array();
        if ($nazione == "100000100") {
            $province = Istat::getProvince();
            foreach ($province as $key => $value)
                $json[] = array(
                    $key => $value
                );
        }
        echo json_encode($json);
    }

    /**
     * Ritorna la lista dei comuni di una provincia in formato jSON
     *
     * @param string $provincia
     */
    public function listaComuni($provincia)
    {
        $comuni = Istat::getComuni($provincia);
        echo json_encode($comuni);
    }

    public function catasto($istat)
    {
        $cod_catasto = Istat::getBelfiore($istat);
        echo json_encode($cod_catasto);
    }
}