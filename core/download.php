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
User::setConfig();

$type = $_GET["t"];
$doc = isset($_GET["doc"]) ? $_GET["doc"] : null;
$ctype = "Content-Type: application";
$download = false;

switch ($type) {
    case "a":
        // Documenti caricati tramite il modulo upload

        $row = Database::getRow("SELECT * FROM uploads WHERE id_upload=?", array(
            $doc
        ));

        if (! $row["is_public"] && ! User::isUserLogged() && $row["tipo"] != "pubblicazioni")
            Page::redirect("notauth", "download");

        $filename = $row["filename"];
        $folder = $row["folder"];
        $percorso_assoluto = Config::$publicRoot . DS . $folder . DS . $filename;
        $extension = strtolower(strrchr($filename, '.'));
        if ($extension == ".pdf")
            $ctype = "Content-Type: application/pdf";
        $download = true;
        break;
    case "b":
        // Documenti vari, guide ecc in formato pdf caricati manualmente dal superuser
        if (! User::isUserLogged())
            Page::redirect("notauth", "download");

        $filename = $doc;
        $percorso_assoluto = Config::$publicRoot . DS . $filename;
        $extension = strtolower(strrchr($filename, '.'));
        if ($extension == ".pdf")
            $ctype = "Content-Type: application/pdf";
        break;
    case "h":
        // Documenti html
        if (! User::isUserLogged())
            Page::redirect("notauth", "download");
        $ctype = "Content-Type: text/html";
        $filename = $doc;
        $percorso_assoluto = Config::$publicRoot . DS . $filename;
        break;
    case "x":
        // File xls
        $filename = $_GET["file"];
        if (! User::isUserInGroups("superuser", "editor"))
            Page::redirect("notauth", "download");

        $percorso_assoluto = Config::$publicRoot . DS . $filename;
        $ctype = "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
        break;
    case "img":
        // Documenti caricati tramite il modulo upload

        $row = Database::getRow("SELECT * FROM uploads WHERE id_upload=?", array(
            $doc
        ));

        if (! $row["is_public"] && ! User::isUserLogged() && $row["tipo"] != "pubblicazioni")
            Page::redirect("notauth", "download");

        $filename = $row["filename"];
        $folder = $row["folder"];
        $percorso_assoluto = Config::$publicRoot . DS . $folder . DS . $filename;
        $extension = strtolower(strrchr($filename, '.'));
        if ($extension == ".pdf")
            $ctype = "Content-Type: application/pdf";
        $download = false;
        break;
    default:
        // File di vario tipo
        if (! User::isUserLogged())
            Page::redirect("notauth", "download");
        $filename = $_GET["file"];
        $percorso_assoluto = Config::$publicRoot . DS . $filename;
        $download = true;
        break;
}


if (! file_exists($percorso_assoluto)) {
    Page::redirect("notfound", "download");
    die();
}

if ($download) {
    header("$ctype; name=" . $filename);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($percorso_assoluto));
    readfile($percorso_assoluto);
    exit();
} else {
    header("$ctype; name=" . $filename);
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: inline; filename=" . $filename);
    header("Expires: 0");
    header("Cache-Control: no-cache, must-revalidate");
    header("Cache-Control: private");
    header("Pragma: public");
    readfile($percorso_assoluto);
    exit();
}