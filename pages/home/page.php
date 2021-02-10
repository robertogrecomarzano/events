<?php
$utente = User::getUserData(User::getLoggedUserId());
$page->assign("utente", $utente);
$upload = new Upload(User::getLoggedUserId(), "user/allegati", false, "USER_PROFILE_PHOTO", "filename", "filedesc", "dettaglio", array(
    ".jpg"
));
$path = null;
$foto = $upload->getRows("dettaglio='USER_PROFILE_PHOTO'");
if (count($foto) > 0) {
    $profile = $foto[0];
    $path = Config::$urlRoot . DS . $profile["folder"] . DS . $profile["filename"];
}
$page->assign("avatar", $path);


