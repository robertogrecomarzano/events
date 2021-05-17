<?php

class Config
{

    /**
     * Contiene l'intero record della tabella config
     *
     * @var array
     */
    public static $config = array();

    /**
     * Contiene l'intero record della tabella config_parametri
     *
     * @var array
     */
    public static $parametri = array();

    /**
     * App name
     *
     * @var string
     */
    public static $app = "Events local";

    /**
     * Database name
     *
     * @var string
     */
    public static $db = "events";

    /**
     * Database server
     *
     * @var string
     */
    public static $host = "127.0.0.1";

    /**
     * Database port
     *
     * @var string
     */
    public static $port = "3306";

    /**
     * Database user
     *
     * @var string
     */
    public static $user = "root";

    /**
     * Database password
     *
     * @var string
     */
    public static $pass = "root";

    /**
     * DBMS usato da PDO
     *
     * @var string
     */
    static $pdoDbms = "mysql";

    // ------------------------------------
    // Localization
    // ------------------------------------

    /**
     * Locale di default
     *
     * @var string
     */
    public static $defaultLocale = "en_US";

    // ------------------------------------
    // Compressione script
    // ------------------------------------

    /**
     * Unione e compressione (minify) dei javascript
     * FIXME: ancora non funzionante !!!!
     *
     * @var bool
     */
    public static $uniteAndCompressJS = false;

    /**
     * Unione e compressione (minify) dei CSS
     *
     * @var bool
     */
    public static $uniteAndCompressCSS = true;

    // ------------------------------------
    // Path di installazione
    // ------------------------------------

    /**
     * Installation root (server/local)
     *
     * @var string
     */
    public static $serverRoot = 'C:\wamp\www\events';

    /**
     * Installation root (web/URL)
     *
     * @var string
     */
    public static $urlRoot = "http://events";

    /**
     * Document root (server/local)
     *
     * @var string
     */
    public static $publicRoot = 'C:\wamp\www\events\public';

    // ------------------------------------
    // Security
    // ------------------------------------

    /**
     * Salt per hashing delle password
     *
     * @var string
     */
    public static $passwordSalt = "a2bcc90502334df57e081c9e7d5ac2d33cf31095";

    /**
     * Tempo di expire del token delle form
     *
     * @var int
     */
    public static $formtokenMaxTime = 3600;

    /**
     * Pagine che non hanno necessita di avere SESSION settata
     *
     * @var array string
     */
    public static $openPage = array(
        "login",
        "user/signup",
        "user/confirm",
        "user/passwordrecovery",
        "logout",
        "notauth",
        "offline",
        "notfound",
        "expirated"
        
        
    );
}
