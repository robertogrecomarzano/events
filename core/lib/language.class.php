<?php

/**
 * Classe per la gestione della Lingua, traduzioni e localizzazione per il Db
 * @author Roberto
 *
 */
class Language
{

    /**
     * Ritorna la lingua corrente
     *
     * @return string
     */
    static function getCurrentLocale()
    {
        return (isset($_SESSION['locale']) && $_SESSION['locale'] != "") ? $_SESSION['locale'] : Config::$defaultLocale;
    }

    /**
     * Imposta la lingua corrente
     *
     * @param string $locale
     */
    static function setCurrentLocale($locale)
    {
        $_SESSION['locale'] = ! empty($_SESSION["user"]["lingua"]) ? $_SESSION["user"]["lingua"] : $locale;
        Database::setLocale($_SESSION['locale']);
        setlocale(LC_TIME, null, $_SESSION['locale'].".UTF-8");
    }

    /**
     * Ritorna la descrizione di un messaggio in base alla lingua corrente
     *
     * @param string $translationAlias
     * @param array $arguments
     * @return string
     */
    static function get($translationAlias, $arguments = array())
    {
        if (empty($translationAlias))
            return null;
        
        $traduzioni = isset($_SESSION['user']['traduzioni']) ? $_SESSION['user']['traduzioni'] : null;
        
        foreach ($traduzioni as $row)
            if ($row["alias"] == $translationAlias) {
                $translation = $row["translation"];
                break;
            }
        
        if (empty($translation)) {
            $translation_row = Database::getRow("SELECT * FROM traduzioni WHERE lang = ? AND alias = ?", array(
                Language::getCurrentLocale(),
                $translationAlias
            ));
            
            /**
             * Se il record non è presente, viene inserito automaticamente (senza traduzione)
             */
            if (empty($translation_row)) {
                
                if (strtoupper($translationAlias) == $translationAlias && ! empty($translationAlias)) {
                    $languages = Database::getEnumValues("traduzioni", "lang");
                    
                    foreach ($languages as $lang) {
                        Database::query("INSERT INTO traduzioni SET alias=?, lang=?, translation=?", array(
                            $translationAlias,
                            $lang,
                            ucfirst(str_replace("_", " ", strtolower($translationAlias)))
                        ));
                }
                }
            } else {
                if (! User::isUserLogged()) {
                    if (empty($translation_row["translation"]))
                        return $translationAlias;
                    
                    $translation = vsprintf($translation_row["translation"], $arguments);
                    return $translation;
                }
            }
            
            return "[" . str_replace("_", " ", $translationAlias) . implode(", ", $arguments) . "]";
        }
        
        $translation = vsprintf($translation, $arguments);
        return $translation;
    }

    /**
     * Ritorna le traduzioni in base alla lingua corrente
     *
     * @return array
     */
    static function getTraduzioni()
    {
        $traduzioni = Database::getRows("SELECT *
				FROM 	traduzioni
				WHERE 	lang = ?", array(
            Language::getCurrentLocale()
        ));
        return $traduzioni;
    }
}
