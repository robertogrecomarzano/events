<?php

class RegExp
{

    /**
     * Controlla se la password è valida
     *
     * @param string $password
     * @return boolean
     */
    static function checkPassword($password)
    {
        if (empty($password))
            return false;
        $allowed = ".:_|!£$%&/()=?^#*";
        return preg_match('((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*['.$allowed.']).{8,20})', $password);
    }

    /**
     * Controlla le coordinate GEO
     *
     * @param string $codice
     * @return boolean
     */
    static function checkGeo($codice)
    {
        if (empty($codice))
            return false;
        return preg_match('/^[-]{0,1}[1-9][0-9]*\.\d{4,6}$/', $codice);
    }

    /**
     * Controlla il codice Stalla
     *
     * @param string $codice
     * @return boolean
     */
    static function checkStalla($codice)
    {
        if (empty($codice))
            return false;
        return preg_match('/\d{3}[a-zA-Z]{2}\d{3}$/', $codice);
    }

    /**
     * Formatta un numero con le cifre decimali ed i giusti separatori
     *
     * @param float $number
     * @param int $decimal
     * @param string $dec_point
     * @param string $thousands_sep
     * @return string
     */
    static function formatNumber($number, $decimal = 2, $dec_point = ',', $thousands_sep = '.')
    {
        if (empty($number))
            $number = 0;
        return number_format($number, $decimal, $dec_point, $thousands_sep);
    }

    /**
     * Permette di "pulire" i caratteri speciali all'interno dell'xml
     *
     * @param string $value
     * @return string $value (pulito)
     */
    static function safe_value($value)
    {
        return trim(preg_replace('/&(?!\w+;)/', '&amp;', $value));
    }

    /**
     * Controlla il CAP
     *
     * @param string $codice
     * @return boolean
     */
    static function checkCap($codice)
    {
        if (empty($codice))
            return false;
        return preg_match('/\d{5}$/', $codice);
    }

    /**
     * Controlla una partita Iva
     *
     * @param string $codice
     * @return boolean
     */
    static function checkIva($codice)
    {
        if (empty($codice))
            return false;
        return preg_match('/\d{11}$/', $codice);
    }

    /**
     * Controlla indirizzo email
     *
     * @param string $email
     * @return boolean
     */
    static function checkEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Controlla il codice Fiscale
     *
     * @param string $codice_fiscale
     * @return boolean
     */
    static function checkCodiceFiscale($codice_fiscale)
    {
        if (empty($codice_fiscale))
            return false;
        $codice_fiscale = strtoupper($codice_fiscale);
        $match = preg_match('/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z0-9]{5}$/', $codice_fiscale);

        if (! $match)
            return false;

        $s = 0;
        for ($i = 1; $i <= 13; $i += 2) {
            $c = $codice_fiscale[$i];
            if (strcmp($c, "0") >= 0 and strcmp($c, "9") <= 0)
                $s += ord($c) - ord('0');
            else
                $s += ord($c) - ord('A');
        }
        for ($i = 0; $i <= 14; $i += 2) {
            $c = $codice_fiscale[$i];
            switch ($c) {
                case '0':
                    $s += 1;
                    break;
                case '1':
                    $s += 0;
                    break;
                case '2':
                    $s += 5;
                    break;
                case '3':
                    $s += 7;
                    break;
                case '4':
                    $s += 9;
                    break;
                case '5':
                    $s += 13;
                    break;
                case '6':
                    $s += 15;
                    break;
                case '7':
                    $s += 17;
                    break;
                case '8':
                    $s += 19;
                    break;
                case '9':
                    $s += 21;
                    break;
                case 'A':
                    $s += 1;
                    break;
                case 'B':
                    $s += 0;
                    break;
                case 'C':
                    $s += 5;
                    break;
                case 'D':
                    $s += 7;
                    break;
                case 'E':
                    $s += 9;
                    break;
                case 'F':
                    $s += 13;
                    break;
                case 'G':
                    $s += 15;
                    break;
                case 'H':
                    $s += 17;
                    break;
                case 'I':
                    $s += 19;
                    break;
                case 'J':
                    $s += 21;
                    break;
                case 'K':
                    $s += 2;
                    break;
                case 'L':
                    $s += 4;
                    break;
                case 'M':
                    $s += 18;
                    break;
                case 'N':
                    $s += 20;
                    break;
                case 'O':
                    $s += 11;
                    break;
                case 'P':
                    $s += 3;
                    break;
                case 'Q':
                    $s += 6;
                    break;
                case 'R':
                    $s += 8;
                    break;
                case 'S':
                    $s += 12;
                    break;
                case 'T':
                    $s += 14;
                    break;
                case 'U':
                    $s += 16;
                    break;
                case 'V':
                    $s += 10;
                    break;
                case 'W':
                    $s += 22;
                    break;
                case 'X':
                    $s += 25;
                    break;
                case 'Y':
                    $s += 24;
                    break;
                case 'Z':
                    $s += 23;
                    break;
                /* . missing_default: . */
            }
        }
        if (chr($s % 26 + ord('A')) != $codice_fiscale[15])
            return false;

        return true;
    }

    /**
     * Formatta un numero con le cifre decimali ed i giusti separatori
     *
     * @param float $number
     * @param int $decimal
     * @param string $dec_point
     * @param string $thousands_sep
     * @return string
     */
    static function valuta($number, $decimal = 2, $dec_point = ',', $thousands_sep = '.')
    {
        if (empty($number))
            $number = 0;

        return "&euro;" . " " . number_format($number, $decimal, $dec_point, $thousands_sep);
    }
}