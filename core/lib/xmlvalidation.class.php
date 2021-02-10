<?php

/**
 * Classe per la gestione della validazione dei file xml
 * @author Roberto
 *
 */
class XmlValidation
{

    /**
     */
    function __construct()
    {
        ;
    }

    /**
     * Valida un file xml secondo uno schema xsd
     * Ritorna true in caso di esito posivito, un arrat con gli errori in caso di esito negativo
     *
     * @param string $xmlfile
     * @param string $xsdfile
     * @return array|boolean
     */
    function valida($xmlfile, $xsdfile)
    {

        // Enable user error handling
        libxml_use_internal_errors(true);

        $xml = new DOMDocument();
        $xml->load($xmlfile);

        $return = $xml->schemaValidate($xsdfile);
        $errori = null;
        if (! $return)
            $errori = $this->libxml_display_errors();

        return [
            "return" => $return,
            "errori" => $errori
        ];
    }

    /**
     * Ritorna l'array con gli eventuali errori
     *
     * @return array
     */
    private function libxml_display_errors()
    {
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return $errors;
    }
}

