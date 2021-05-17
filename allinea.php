<?php
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
include "config.php";
include "core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

Config::$db = "h632659_events";
User::setConfig();
Config::$config["debug"] = true;

Database::initializeConnection(); // inizializza db
Language::setCurrentLocale(Config::$defaultLocale); // da togliere se prevista i18n e l10n
date_default_timezone_set("Europe/Rome");

Database::query("CREATE TABLE eventi_sessioni (
  id_sessione INT(11) NOT NULL AUTO_INCREMENT,
  id_evento INT(11) DEFAULT NULL,
  titolo VARCHAR(100) DEFAULT NULL,
  data DATE DEFAULT NULL,
  ora_inizio CHAR(5) DEFAULT NULL,
  ora_fine CHAR(5) DEFAULT NULL,
  zoom_link VARCHAR(100) DEFAULT NULL,
  zoom_id VARCHAR(20) DEFAULT NULL,
  zoom_pwd VARCHAR(20) DEFAULT NULL,
  zoom_send_link_on_register TINYINT(1) DEFAULT 0,
  inviare TINYINT(1) DEFAULT 0,
  inviare_template VARCHAR(45) DEFAULT NULL,
  record_attivo TINYINT(1) DEFAULT 1,
  PRIMARY KEY (id_sessione),
  INDEX eventi_sessioni_ibfk_1 USING BTREE (id_evento)
  )
  ENGINE = INNODB
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  ROW_FORMAT = DYNAMIC");

Database::query("CREATE TABLE eventi_sessioni_utenti (
  id INT(11) NOT NULL AUTO_INCREMENT,
  id_evento INT(11) DEFAULT NULL,
  id_sessione INT(11) DEFAULT NULL,
  id_utente INT(11) DEFAULT NULL,
  is_reminder_inviato TINYINT(1) DEFAULT 0,
  ts_reminder_inviato TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  is_link_inviato TINYINT(1) DEFAULT 0,
  ts_link_inviato TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id)
  )
  ENGINE = INNODB
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  ROW_FORMAT = DYNAMIC");

$eventi = Database::getRows("SELECT * FROM eventi");
foreach ($eventi as $evento) {
    Database::query("INSERT INTO eventi_sessioni SET
    id_evento=?,
    titolo=?,
    data=?,
    ora_inizio=?,
    ora_fine=?,
    zoom_link=?,
    zoom_id=?,
    zoom_pwd=?,
    zoom_send_link_on_register=?,
    inviare=?,
    inviare_template=?", [
        $evento["id_evento"],
        $evento["titolo"],
        $evento["data"],
        $evento["ora_inizio"],
        $evento["ora_fine"],
        $evento["zoom_link"],
        $evento["zoom_id"],
        $evento["zoom_pwd"],
        $evento["send_zoom_link_on_register"],
        $evento["inviare"],
        $evento["inviare_template"]
    ]);
}

$utenti = Database::getRows("SELECT * FROM utenti WHERE id_evento IS NOT NULL");
foreach ($utenti as $utente) {
    $idSessione = Database::getField("SELECT id_sessione FROM eventi_sessioni WHERE id_evento=?", [
        $utente["id_evento"]
    ]);

    Database::query("INSERT INTO eventi_sessioni_utenti SET 
        id_evento=?,
        id_sessione=?,
        id_utente=?,
        is_reminder_inviato=?,
        ts_reminder_inviato=?,
        is_link_inviato=?,
        ts_link_inviato=?", [
        $utente["id_evento"],
        $idSessione,
        $utente["id_utente"],
        $utente["is_reminder_inviato"],
        $utente["ts_reminder_inviato"],
        $utente["is_link_inviato"],
        $utente["ts_link_inviato"]
    ]);
}

Database::query("
ALTER TABLE eventi
  DROP COLUMN `data`,
  DROP COLUMN ora_inizio,
  DROP COLUMN ora_fine,
  CHANGE COLUMN template template ENUM ('basicit', 'basic', 'intermediate', 'advanced', 'international', 'call', 'callfull', 'expert', 'experttwo', 'baseinnovazioneit', 'preadvanced') DEFAULT NULL,
  ADD COLUMN modalita ENUM ('singola', 'multipla') DEFAULT NULL AFTER template,
  CHANGE COLUMN lingua lingua ENUM ('en_US', 'it_IT') DEFAULT 'en_US' AFTER modalita,
  ADD COLUMN data_inizio DATE DEFAULT NULL AFTER descrizione,
  ADD COLUMN data_fine DATE DEFAULT NULL AFTER data_inizio,
  CHANGE COLUMN contact contact VARCHAR (45) DEFAULT NULL,
  CHANGE COLUMN email email VARCHAR (45) DEFAULT NULL,
  CHANGE COLUMN subject subject VARCHAR (100) DEFAULT NULL,
  CHANGE COLUMN message message TEXT DEFAULT NULL,
  CHANGE COLUMN greeting_message greeting_message TEXT DEFAULT NULL,
  CHANGE COLUMN signature signature VARCHAR (100) DEFAULT NULL,
  CHANGE COLUMN website website VARCHAR (45) DEFAULT NULL,
  CHANGE COLUMN show_website_mail show_website_mail TINYINT (1) DEFAULT 1,
  CHANGE COLUMN zoom_link zoom_link VARCHAR (100) DEFAULT NULL,
  CHANGE COLUMN zoom_id zoom_id VARCHAR (20) DEFAULT NULL,
  CHANGE COLUMN zoom_pwd zoom_pwd VARCHAR (20) DEFAULT NULL,
  CHANGE COLUMN show_logo show_logo TINYINT (1) DEFAULT 1,
  CHANGE COLUMN show_logo_ciheam show_logo_ciheam TINYINT (1) DEFAULT NULL,
  CHANGE COLUMN show_logo_mail show_logo_mail TINYINT (1) DEFAULT 1,
  CHANGE COLUMN show_logo_ciheam_mail show_logo_ciheam_mail TINYINT (1) DEFAULT 1,
  CHANGE COLUMN logo logo VARCHAR (100) DEFAULT NULL,
  CHANGE COLUMN pdf pdf VARCHAR (100) DEFAULT NULL,
  CHANGE COLUMN privacy_registrazione_video privacy_registrazione_video TEXT DEFAULT NULL,
  CHANGE COLUMN send_zoom_link_on_register send_zoom_link_on_register TINYINT (1) DEFAULT 0 COMMENT 'Attiva l''invio del link in fase di registrazione',
  CHANGE COLUMN inviare inviare TINYINT (1) DEFAULT 0,
  CHANGE COLUMN inviare_template inviare_template VARCHAR (45) DEFAULT NULL,
  CHANGE COLUMN record_attivo record_attivo TINYINT (1) DEFAULT 1;");

Database::query("
ALTER TABLE utenti
  DROP COLUMN is_reminder_inviato,
  DROP COLUMN ts_reminder_inviato,
  DROP COLUMN is_link_inviato,
  DROP COLUMN ts_link_inviato;");


echo "fine";