<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
include "../config.php";
include "../core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

User::setConfig();


$i = 0;
$perc = 0;
$oldperc = 0;

$n=1000;
for($j=0; $j<$n; $j++)
{
    $i ++;
    $perc = round(($i / $n) * 100, 2);
    if ((floor($perc * 10) / 10) != $oldperc) {
        $oldperc = floor($perc * 10) / 10;
        flush();
    }
    
    Database::query("UPDATE exec_progress SET progress=?, timestamp=NOW()", array(
        $perc
    ));

    sleep(1);
}