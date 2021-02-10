<?php
error_reporting(E_ALL && ! E_DEPRECATED);
include "../config.php";
include "../core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

Database::initializeConnection(); // inizializza db

$progress = Database::getField("SELECT progress FROM exec_progress");
if ($progress == 100)
    Database::query("UPDATE exec_progress SET is_occupato=0");
echo $progress;