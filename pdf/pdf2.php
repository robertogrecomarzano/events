<?php
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_DEPRECATED & ~ E_WARNING);
include "../config.php";
include "../core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

Database::initializeConnection();
Language::setCurrentLocale(Config::$defaultLocale); // da togliere se prevista i18n e l10n
User::setConfig();

if (! isset($_SESSION['user']))
    Page::redirect("login");
$gruppo = User::getLoggedUserGroup();
$idUtente = User::getLoggedUserId();

if (isset($_GET['alias']) && $_GET['alias'] != "") {
    $alias = $_GET['alias'];
    $id = $_GET['id'];

    $file = end(explode("/", $alias)); // prendo il secondo [ultimo] valore dell'alias per determinare il file da richiamare
    $folderPath = __DIR__ . DS . $class;

    if (preg_match("/Win/i", PHP_OS))
        header("Location: " . Config::$urlRoot . "/pdf/$alias/$id");

    // prendo il primo valore dell'alias per individuare la cartella e la classe
    $class = reset(explode("/", $alias));

    // non cambiare l'ordine delle variabili
    $out = shell_exec("php stampa.php $alias $file $id $class $gruppo $idUtente");

    header('Content-type: application/pdf');
    echo $out;
}