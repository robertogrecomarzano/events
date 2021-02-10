<?php

// -----------------------
// Core libraries
// -----------------------
require_once "iprefs.interface.php";
require_once "ipermissions.interface.php";
require_once "imenu.interface.php";

require_once "lib/permission.class.php";
require_once "lib/servizi.class.php";
require_once "lib/ormobj.class.php";
require_once "lib/plugin.class.php";
require_once "lib/page.class.php";
require_once "lib/database.class.php";
require_once "lib/language.class.php";
require_once "lib/css.class.php";
require_once "lib/html.class.php";
require_once "lib/security.class.php";
require_once "lib/privacy.class.php";
require_once "lib/form.class.php";
require_once "lib/mail.class.php";
require_once "lib/phpmailer.class.php";
require_once "lib/phpmailer.pop3.class.php";
require_once "lib/phpmailer.smtp.class.php";
require_once "lib/customdate.class.php";
require_once "lib/upload.class.php";
require_once "lib/curl.class.php";
require_once "lib/regexp.class.php";
require_once "lib/xls.class.php";
require_once "lib/xlsxwriter.class.php";
require_once "lib/excelreader.class.php";
require_once "lib/um.class.php";
require_once "lib/message.class.php";
require_once "lib/simplexmlextended.class.php";
require_once "lib/pdfutility.class.php";
require_once "lib/xmlvalidation.class.php";

// -----------------------
// Librerie di terze parti
// -----------------------
if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

$thirdPartyLibsPath = Config::$serverRoot . DS . "thirdparty";

// Smarty 3.1.11 (templating engine)
require_once $thirdPartyLibsPath . DS . "Smarty-3.1.11/libs/Smarty.class.php";

// mPDF (Generazione PDF)
require_once $thirdPartyLibsPath . DS . 'mpdf-7.0/vendor/autoload.php';

// CSS URI rewriter (Rilocazione URI CSS mantenendo i riferimenti url)
include_once $thirdPartyLibsPath . DS . "minify.urirewriter.class.php";

// JSMIN (JavaScript minifier)
include_once $thirdPartyLibsPath . DS . "jsmin.class.php";


// -----------------------------------------------------------------------
// Autoload delle altre eventuali classi (in particolare quelle specifiche
// al progetto. Utilizzo di SPL per non sovrapporsi all'autoload di altre
// classi third-party del progetto.
// -----------------------------------------------------------------------

spl_autoload_register("customAutoload");

function customAutoload($class)
{
    $file = strtolower($class) . ".class.php";
    $path = Config::$serverRoot . DS . "core" . DS . "classes_specific" . DS . $file;
    if (is_readable($path))
        include_once $path;
}

/**
 */
class Framework
{

    static function getCorePath()
    {
        return Config::$serverRoot . DS . "core";
    }

    static function get3rdPartyPath()
    {
        return Framework::getCorePath() . DS . "thirdparty";
    }

    static function getPluginPath()
    {
        return Config::$serverRoot . DS . "components";
    }

    /**
     *
     * @param string $plugin
     * @return string
     */
    static function getPluginFolder($plugin)
    {
        return Config::$serverRoot . DS . "components" . DS . "com_" . strtolower($plugin);
    }
}
