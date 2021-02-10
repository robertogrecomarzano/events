<?php
$page->assign("recoveryLink", Page::getURLStatic("user/passwordrecovery"));
$page->assign("signupLink", Page::getURLStatic("user/signup"));
if (User::isUserLogged())
    Page::redirect("user");

$obj = new Evento();
$eventi = $obj->getList(true);

foreach ($eventi as &$e) {
    $e["data_dmy"] = CustomDate::format($e["data"], "Y-m-d", "d/m/Y");
    $e["data_day"] = CustomDate::format($e["data"], "Y-m-d", "d");
    $e["data_month"] = CustomDate::format($e["data"], "Y-m-d", "M");
    if (! file_exists(Config::$serverRoot . "/public/" . $e["id_evento"] . "/" . $e["logo"]))
        $e["logo"] = null;
}
$page->assign("eventi", $eventi);