<?php

/**
 * index.php
 */
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_WARNING & ~ E_NOTICE);
include "config.php";
include "core/framework.php";
$tmp_dir = Config::$serverRoot . DS . "tmp";
if (! file_exists($tmp_dir))
    mkdir($tmp_dir, 077, true);
session_save_path($tmp_dir);
session_start();

if ($_POST)
    Security::checkCSRFToken();

Database::initializeConnection(); // inizializza db
Language::setCurrentLocale(Config::$defaultLocale); // da togliere se prevista i18n e l10n
date_default_timezone_set("Europe/Rome");

$pg = isset($_GET['page']) ? $_GET['page'] : "login";
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if (! empty($_GET["ac"]))
    $pg .= "/" . $_GET["ac"];

// $pg2 = $pg . ($id > 0 ? ("/" . $id) : "");
$pg2 = $pg;
if ($id > 0)
    $pg2 .= "/" . $id;

// Creazione oggetto pagina
$page = Page::getInstance();
$page->setCurrentAlias($pg);

/**
 * Inizializza la pagina e i parametri della singola installazione
 */

User::initPage();

$events = parse_ini_file("events.ini");
foreach ($events as $k => $v) {
    $url = reset(explode("|", $v));
    Config::$openPage[] = $url;

    if ($page->alias == $url) {
        $type = end(explode("|", $v));
        $page->alias = "event/$type";
    }
}

// Esecuzione script principale del template
$mainTemplateDir = Config::$serverRoot . DS . "core" . DS . "templates";
$templateScript = $mainTemplateDir . DS . "main.php";
$preFile = $page->serverFolder() . DS . "pre.php";
$pageFile = $page->serverFolder() . DS . "page.php";
$jsFile = $page->serverFolder() . DS . "page.js";
$cssFile = $page->serverFolder() . DS . "templates" . DS . "main.css";
$templateFile = $mainTemplateDir . DS . "main.tpl";

if (! file_exists($page->serverFolder()))
    Page::redirect("notfound");

if (file_exists($preFile))
    include $preFile;

// inclusione del file js della pagina
if (file_exists($jsFile))
    $page->css->addJS($page->webFolder() . "/page.js", $jsFile);

// inclusione del file css della pagina
if (file_exists($cssFile))
    $page->css->addCSS($page->webFolder() . "/templates/main.css", $cssFile);

// Codice JS comune a tutti, fornisce URL codebase
$page->css->addJSCode("var codebase=" . json_encode(Config::$urlRoot) . ";");

$page->css->addJSCode("var lang='" . Language::getCurrentLocale() . "';");

if (file_exists($templateScript))
    include $templateScript;
elseif (User::isSuperUser())
    $page->addError(Language::get("ERROR_PAGE_TEMPLATE_MAIN_SCRIPT_NOT_FOUND", array(
        $pg
    )));

$page->addPlugin("Menu");
$page->addPlugin("Comuni");
$page->addPlugin("Errorbox");
$page->addPlugin("Help");
$page->addPlugin("Forms");
$news = $page->addPlugin("Avvisi");

// Carica parte statica del menu
Menu::load();

// Carica parte relativa ad eventuali pubblicazioni
User::pubblicazioni();

// Carico le voci di menù, relative ai soli servizi per cui è abilitato l'utente
$servizi = Servizi::getServizi();
if (count($servizi) > 0)
    foreach ($servizi as $s)
        Menu::addClassHook($s['servizio']);
User::createMenu(); // Personalizzo il menà in base al gruppo utente.
Menu::callHooks(); // processa le voci di menu dinamiche delle classi
Menu::createURLs(); // crea gli URL a partire dagli id
Menu::setActive($pg2); // imposta pagina corrente nel menu
$page->setTitles($pg2); // imposta i titoli

if (file_exists($pageFile))
    include $pageFile;

if (! in_array($pg, Config::$openPage)) {
    $alias = $pg;
    $id = $page->getId();
    if (! empty($id))
        $alias .= "/" . $id;
    if (Menu::is_hide($alias))
        Page::redirect("notauth", "menu");
}

$leftMenu = Menu::styleMenu("left");
$topMenu = Menu::styleMenu("top");

$page->template = $templateFile;

$modules = array(
    "debug" => Config::$config["debug"] ? "style='background-image:url(\"" . Config::$urlRoot . "/core/templates/img/debug.png\")'" : "",
    "collaudo" => Config::$config["collaudo"] ? "style='background-image:url(\"" . Config::$urlRoot . "/core/templates/img/collaudo.png\")'" : "",
    "offline" => Config::$config["offline"] ? "style='background-image:url(\"" . Config::$urlRoot . "/core/templates/img/offline.png\")'" : "",
    "title" => ! empty($page->title) ? Config::$app . " - " . $page->title : Config::$app,
    "varie" => $page->varie,
    "tecnico" => $page->tecnico,
    "contentTitle" => $page->title,
    "contentSubTitle" => $page->subTitle,
    "pageLabel" => $page->pageLabel,
    "left" => $leftMenu,
    "top" => $topMenu,
    "newspic" => ! empty($news) ? $news->getScrollNews() : ""
);

if (isset($_SESSION["redirect"])) {
    $page->addMessages(! empty($_SESSION["redirect"]["msg"]) ? $_SESSION["redirect"]["msg"] : Language::get("ALERT_SUCCESS_TITLE"));
    unset($_SESSION["redirect"]);
}

echo $page->render($modules);
if (Config::$config["debug"])
    echo ("<pre><code>" . htmlspecialchars(Menu::$tree->asXML()) . "</code></pre>");
                                            
