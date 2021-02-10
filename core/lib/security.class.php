<?php

/**
 * Interfaccia per metodi utility rivolti alla sicurezza.
 * Metodi implementati:
 * 1- Gestione Cross Site Request Forgery tramite token nei form
 */
class Security
{

    /**
     * Integer obfuscation, lavora fino a 24bit.
     * Variante dell'algoritmo
     * moltiplicativo di Knuth basato su un numero primo.
     *
     * @param int $id
     *            Intero da offuscare
     * @param bool $from
     *            Criptazione (true) o decriptazione (false)
     * @return string
     */
    static function maskId($id, $from = true, $padding = true)
    {
        if (empty($id))
            return "";
        
        $prime = 1580030173;
        $prime_inv = 59260789;
        $maxid = pow(2, 24) - 1;
        
        $value = $from ? sprintf("%u", ($id * $prime) & $maxid) : sprintf("%u", ($id * $prime_inv) & $maxid);
        return $padding ? str_pad($value, 10, "0", STR_PAD_LEFT) : $value;
    }

    /**
     * Genera il token anti-CSRF random
     *
     * @return string
     */
    static function getAndStoreCSRFToken()
    {
        $token = md5(uniqid(rand(), true));
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
        return $token;
    }

    /**
     * Genera l'HTML che contiene il token anti-CSRF
     *
     * @param string $token
     * @return string
     */
    static function htmlCSRFToken($token)
    {
        $args = array(
            "type" => "hidden",
            "name" => "formtoken",
            "value" => $token
        );
        return HTML::tag("input", $args);
    }

    /**
     * Controlla che il token anti-CSRF sia presente e corretto
     *
     * @param string $formToken
     * @return boolean
     */
    static function checkCSRFToken($formToken = null)
    {
        if (! $formToken)
            $formToken = isset($_POST['formtoken']) ? $_POST['formtoken'] : null;
       
        if (empty($formToken))
            return true;
        
        if (isset($_SESSION["token"]) && isset($formToken) && ! empty($_SESSION["token"]) && ! empty($formToken) && ($_SESSION["token"] == $formToken) && (time() - $_SESSION["token_time"]) <= Config::$formtokenMaxTime) {
            return true;
        } else {
            $page = Page::getInstance();
            $page->addError(Language::get("CSRF_ERROR"));
            unset($_POST);
            return false;
        }
    }
}
