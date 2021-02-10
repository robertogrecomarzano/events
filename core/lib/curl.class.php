<?php

class Curl
{

    public static function get($url, $debug = FALSE)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if ($debug)
            var_dump(curl_getinfo($ch, CURLINFO_HEADER_OUT));
        curl_close($ch);
        return $data;
    }
}