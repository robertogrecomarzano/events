<?php

class CustomDate
{

    /**
     * Formatta una data
     *
     * @param string $data
     * @param string $format_in
     * @param string $format_out
     * @return string
     */
    static function format($data, $format_in = "d/m/Y", $format_out = "Y-m-d")
    {
        if (empty($data) || $data == "" || $data == null || $data == "0000-00-00")
            return "";
        $d = date_create_from_format($format_in, $data);
        $value = date_format($d, $format_out);
        return $value;
    }

    /**
     * Calcola la differenza tra 2 date, ritorna 1|0 se data1>data2
     *
     * @param string $data1
     * @param string $format1
     * @param string $data2
     * @param string $format2
     * @return number
     */
    static function diff($datetime1, $format1, $datetime2, $format2)
    {
        if (empty($datetime1) || empty($datetime2) || $datetime1 == "0000-00-00" || $datetime2 == "0000-00-00")
            return 0;
        $data1 = date_create_from_format($format1, $datetime1);
        $data2 = date_create_from_format($format2, $datetime2);
        $interval = date_diff($data1, $data2);
        return count(array_filter((array) $interval)) > 0 ? 1 : 0;
    }

    /**
     * Calcola la differenza tra 2 date, ritorna la differenza in anni (oppure mesi, giorni ...)
     *
     * @param string $datetime1
     * @param string $format1
     * @param string $datetime2
     * @param string $format2
     * @param string $unitamisura
     * @return number
     */
    static function differenza($datetime1, $format1, $datetime2, $format2, $unitamisura = "y")
    {
        if (empty($datetime1) || empty($datetime2) || $datetime1 == "0000-00-00" || $datetime2 == "0000-00-00")
            return 0;
        $data1 = date_create_from_format($format1, $datetime1);
        $data2 = date_create_from_format($format2, $datetime2);
        $diff = date_diff($data1, $data2);
        $total = 0;

        switch ($unitamisura) {
            case "y":
                $total = $diff->y;
                break;
            case "m":
                $total = $diff->y * 12 + $diff->m;
                break;
            case "d":
                $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d;
                break;
            case "h":
                $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i / 60;
                break;
            case "i":
                $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s / 60;
                break;
            case "s":
                $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i) * 60 + $diff->s;
                break;
        }
        return $total;
    }

    /**
     * Aggiunge un certo numero di giorni ad una data e ritorna la data trovata
     *
     * @param string $datetime
     * @param int $days
     * @param string $format_out
     * @return data
     */
    static function add($datetime, $days, $format_out = "Y-m-d")
    {
        $data = date_create_from_format("Y-m-d H:i:s", $datetime);
        date_add($data, date_interval_create_from_date_string("$days hour"));
        return date_format($data, $format_out);
    }

    /**
     * Sottrae un certo numero di giorni da una data e ritorna la data trovata
     *
     * @param string $datetime
     * @param int $days
     * @param string $format_out
     * @return data
     */
    static function sub($datetime, $days, $format_out = "Y-m-d")
    {
        $data = date_create_from_format("Y-m-d H:i:s", $datetime);
        date_sub($data, date_interval_create_from_date_string("$days days"));
        return date_format($data, $format_out);
    }

    /**
     * Ritorna true se Data1 <= Data2
     *
     * @param string $data1
     * @param string $format1
     * @param string $data2
     * @param string $format2
     * @return boolean
     */
    static function isPrecedente($datetime1, $format1, $datetime2, $format2)
    {
        if (empty($datetime1) || empty($datetime2) || $datetime1 == "0000-00-00" || $datetime2 == "0000-00-00")
            return 0;
        $data1 = date_create_from_format($format1, $datetime1);
        $data2 = date_create_from_format($format2, $datetime2);
        
        return $data1 <= $data2;
    }

    /**
     * Ritorna true se data è compresa tra data1 e data2
     *
     * @param string $data
     * @param string $format
     * @param string $data1
     * @param string $format1
     * @param string $data2
     * @param string $format2
     *
     * @return boolean
     */
    static function isInIntervallo($data, $format, $datetime1, $format1, $datetime2, $format2)
    {
        if (empty($data) || empty($datetime1) || empty($datetime2) || $data == "0000-00-00" || $datetime1 == "0000-00-00" || $datetime2 == "0000-00-00")
            return false;
        
        $check1 = self::isPrecedente($data, $format, $datetime2, $format2);
        $check2 = self::isPrecedente($datetime1, $format1, $data, $format);
        
        return $check1 && $check2;
    }

    /**
     * Ritorna la data inferiore
     *
     * @param string $data1
     * @param string $format1
     * @param string $data2
     * @param string $format2
     * @return boolean
     */
    static function min($datetime1, $format1, $datetime2, $format2)
    {
        $data1 = date_create_from_format($format1, $datetime1);
        $data2 = date_create_from_format($format2, $datetime2);
        return self::isPrecedente($datetime1, $format1, $datetime2, $format2) ? $data1 : $data2;
    }

    /**
     * Ritorna la data superiore
     *
     * @param string $data1
     * @param string $format1
     * @param string $data2
     * @param string $format2
     * @return boolean
     */
    static function max($datetime1, $format1, $datetime2, $format2)
    {
        $data1 = date_create_from_format($format1, $datetime1);
        $data2 = date_create_from_format($format2, $datetime2);
        return self::isPrecedente($datetime1, $format1, $datetime2, $format2) ? $data2 : $data1;
    }
}