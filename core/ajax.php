<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
include "../config.php";
include "framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

$page = Page::getInstance();

Database::initializeConnection();
date_default_timezone_set("Europe/Rome");

User::setConfig();

$callPage = substr($_SERVER['HTTP_REFERER'], strlen(Config::$urlRoot . "/p/"));

$alias = null;
$pagina = explode("/", $_GET["alias"]);
if (! empty($pagina)) {
    array_pop($pagina);
    $alias = implode("/", $pagina);
}

$events = parse_ini_file(Config::$serverRoot. DS . "events.ini");
foreach ($events as $k => $v) {
    $url = reset(explode("|", $v));
    Config::$openPage[] = $url;
    
    if($page->alias == $url)
    {
        $type = end(explode("|", $v));
        $page->alias = "event/$type";
    }
}

if (! empty($callPage) && ! isset($_SESSION['user']) && ! in_array($callPage, Config::$openPage) && ! in_array($alias, Config::$openPage))
    exit();

if (isset($_GET['plugin']) && $_GET['plugin'] != "") {
    $action = $_GET['action'];
    $plugin = $_GET['plugin'];
    $parametro_get = $_GET['p'];
    $page = new Page();
    $parametri_post = $_POST;
    $plug = $page->addPlugin($plugin);

    if (! empty($action)) {
        if (! empty($parametri_post))
            $plug->$action($parametri_post);
        else
            $plug->$action($parametro_get);
    } else
        $plug->init($parametro_get);
} elseif (isset($_GET['alias']) && $_GET['alias'] != "") {
    $file = $_GET['alias'];
    $pagina = new Page(dirname($file));
    $path = "../pages/$file.php";
    if (file_exists($path))
        include $path;
}