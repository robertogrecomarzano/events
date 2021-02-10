<?php
$page->css->addJS(Config::$urlRoot . DS . "core" . DS . "templates" . DS . "vendor" . DS . "intl-tel" . DS . "js" . DS . "intlTelInput.js", config::$serverRoot . DS . "core" . DS . "templates" . DS . "vendor" . DS . "intl-tel" . DS . "js" . DS . "intlTelInput.js");
$page->css->addCSS(Config::$urlRoot . DS . "core" . DS . "templates" . DS . "vendor" . DS . "intl-tel" . DS . "css" . DS . "intlTelInput.css", config::$serverRoot . DS . "core" . DS . "templates" . DS . "vendor" . DS . "intl-tel" . DS . "css" . DS . "intlTelInput.css");

$page->addPlugin("Calendar");
$userId = User::getLoggedUserId();


$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";
if (! empty($action)) {
    if ($action == "confirm") {

        $pwd = trim($_POST['password']);
        $pwd2 = trim($_POST['password2']);
        if (! empty($pwd) && ! empty($pwd2)) {
            if ($pwd != $pwd2)
                $page->addError(Language::get("ERROR_SIGNUP_2"));

            if (! RegExp::checkPassword($pwd))
                $page->addError(Language::get("PASSWORD_NOT_VALID"));
        }

        if (! RegExp::checkEmail($_POST['email']))
            $page->addError(Language::get("EMAIL_NOT_VALID"));

        if (count(array_filter($_POST["nazionalita"])) > 2)
            $page->addError(Language::get("NATIONALITY_MAX_TWO"));

        if (empty($page->errors)) {

            $comuneResidenza = $_POST['comune_residenza'];
            $nazioneResidenza = $_POST["comune_residenza_nazione"];
            $nazionalita = implode(",", array_filter($_POST["nazionalita"]));
            $comuneNascita = $_POST['comune_nascita'];
            $nazioneNascita = $_POST["comune_nascita_nazione"];
            $dataNascita = $_POST['data_nascita'];
            $cognome = trim($_POST['cognome']);
            $nome = trim($_POST['nome']);
            $email = $_POST['email'];
            $indirizzo = $_POST['indirizzo'];
            $cap = $_POST['cap'];
            $tel = "+" . $_POST['prefisso'] . " " . $_POST['telefono'];
            $skype = $_POST['skype'];
            $facebook = $_POST['facebook'];
            $linkedin = $_POST['linkedin'];
            $twitter = $_POST['twitter'];

            $parameters = array(
                $email,
                $cognome,
                $nome,
                $email,
                $indirizzo,
                $cap,
                $tel,
                $skype,
                $facebook,
                $linkedin,
                $twitter,
                $comuneResidenza,
                $nazioneResidenza,
                $nazionalita,
                $comuneNascita,
                $nazioneNascita,
                $dataNascita
            );

            $sql = "UPDATE utenti SET
                            username=?,
                            cognome=?,
                            nome=?,
                            email=?,
                            indirizzo=?,
                            cap=?,
                            telefono=?,
                            skype=?,
                            facebook=?,
                            linkedin=?,
                            twitter=?,
                            citta=?,
                            nazione=?,
                            nazionalita=?,
                            citta_nascita=?,
                            nazione_nascita=?,
                            data_nascita=STR_TO_DATE(?,'%d/%m/%Y')";
            if (! empty($pwd)) {
                $sql .= ", password=? ";
                $parameters[] = User::saltPassword($pwd);
            }

            $sql .= " WHERE id_utente=?";
            $parameters[] = $userId;
            $res = Database::query($sql, $parameters);
        }

        if ($res == null)
            $page->addError(Language::get("ERROR"));
        else {
            if (! empty($pwd)) {
                $msg = new Message("profile", null, Language::get("PROFILE_UPDATE"), "$cognome $nome", $email, array(
                    "password" => $pwd
                ));
                $msg->render();
            } else
                $page->addMessages(Language::get("PROFILE_UPDATE"));
        }
    }
}

$row = Database::getRow("SELECT *,DATE_FORMAT(data_nascita,'%d/%m/%Y') AS data_nascita_f FROM utenti u WHERE id_utente=?", array(
    User::getLoggedUserId()
));
$_POST['username'] = $row['username'];
$_POST['cognome'] = $row['cognome'];
$_POST['nome'] = $row['nome'];
$_POST['email'] = $row['email'];
$_POST['telefono'] = $row['telefono'];
$_POST['indirizzo'] = $row['indirizzo'];
$_POST['comune_residenza'] = $row['citta'];
$_POST['comune_nascita'] = $row['citta_nascita'];
$_POST['comune_residenza_nazione'] = $row['nazione'];
$_POST['comune_nascita_nazione'] = $row['nazione_nascita'];
$_POST['cap'] = $row['cap'];
$_POST['data_nascita'] = $row['data_nascita_f'];
$_POST['nazionalita[]'] = explode(",", $row["nazionalita"]);

unset($_POST["password"]);
$profili = Database::getRows("SELECT g.* FROM utenti_has_gruppi ug JOIN utenti_gruppi g USING(id_gruppo_utente) WHERE id_utente=?", array(
    User::getLoggedUserId()
));
foreach ($profili as $p)
    $prof[$p['id_gruppo_utente']] = $p['nome'];
$page->assign("profili", $prof);

$page->assign("nazioni", Istat::getNazioni(true));

            
            