<?php

/**
 * Cache file-based con gestione dell'expire time
 */
class Cache
{

    /**
     * Cancella (libera) la chiave di cache
     *
     * @param string $context
     *            Nome del contesto (chiave cache)
     * @param boolean $perUser
     *            Cache globale (false) o per utente (true)
     * @return boolean True se cancellazione avvenuta
     */
    static function clear($context, $perUser = false)
    {
        $cache_path = Cache::getPath($context);
        if (file_exists($cache_path)) {
            unlink($cache_path);
            return true;
        }
        return false;
    }

    /**
     * Metti un oggetto serializzato nella cache
     *
     * @param string $context
     *            Nome del contesto (chiave cache)
     * @param mixed $object
     *            Oggetto da cachare
     * @param boolean $perUser
     *            Cache globale (false) o per utente (true)
     */
    static function put($context, $object, $perUser = false)
    {
        $cache_path = Cache::getPath($context, $perUser);
        if (! $fp = fopen($cache_path, 'wb'))
            return false;
        
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, serialize($object));
            flock($fp, LOCK_UN);
        } else {
            return false;
        }
        fclose($fp);
        @chmod($cache_path, 0777);
        return false;
    }

    /**
     * Recupera oggetto dalla cache
     *
     * @param string $context
     *            Nome del contesto (chiave cache)
     * @param int $expireTime
     *            Tempo di expire (in secondi)
     * @param boolean $perUser
     *            Cache globale (false) o per utente (true)
     */
    static function get($context, $expireTime, $perUser = false)
    {
        $cache_path = Cache::getPath($context, $perUser);
        if (! @file_exists($cache_path))
            return false;
        if (filemtime($cache_path) < (time() - $expiration)) {
            $this->clear($context);
            return false;
        }
        if (! $fp = @fopen($cache_path, 'rb')) {
            return false;
        }
        flock($fp, LOCK_SH);
        $cache = '';
        if (filesize($cache_path) > 0) {
            $cache = unserialize(fread($fp, filesize($cache_path)));
        } else {
            $cache = NULL;
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        return $cache;
    }

    /**
     * Ottiene cartella della cache
     *
     * @param string $context
     *            Nome del contesto (chiave cache)
     * @param boolean $perUser
     *            Cache globale (false) o per utente (true)
     */
    private static function getPath($context, $perUser = false)
    {
        $cacheBase = Config::$serverRoot . DS . "cache" . DS;
        if ($perUser) {
            $cacheBase .= "user_cache" . DS . User::getCurrentUserId() . DS;
        }
        $cacheBase .= $context . DS . "cache";
        return $cacheBase;
    }
}