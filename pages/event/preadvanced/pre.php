<?php
$obj = new Evento();
$evento = $obj->getParametriEventoByNome();
$isRegistrazionePossibile = $obj->isRegistrazionePossibile($evento);
if (! $isRegistrazionePossibile)
    $page->redirect("notfound", "evento");

$templateFile = $mainTemplateDir . DS . "tpl" . DS . "signup.tpl";
$page->template = $templateFile;
$page->assign("signupContent", $evento->template);
$captcha = $page->addPlugin("Captcha");
$action = isset($_POST['form_action']) ? $_POST['form_action'] : "";

if (! empty($action)) {
    if ($captcha->Validate()) {
        if ($action == "confirm") {

            User::setConfig(true);

            $email = trim($_POST['user_email']);

            $numrows = Database::getCount("utenti", "record_attivo=1 AND user_email=? AND id_evento=?", array(
                $email,
                $evento->id_evento
            ));
            if ($numrows > 0)
                $page->addError("User already registered");

            if (! RegExp::checkEmail($email))
                $page->addError("Email not valid");

            if (empty($page->errors))
                $obj->registraUtente($_POST, $evento);
        }
    } else
        $page->addError(Language::get("CAPTCHA_NOT_VALID", array(
            $_REQUEST['captcha_value'],
            $_SESSION['captcha']
        )));
}

$page->assign("captcha", $captcha->Draw());
$page->assign("evento", $evento);
$page->assign("nazioni", Istat::getNazioni(true));

$sectors = [
    "Crops" => "Crops",
    "Fish and aquaculture" => "Fish and aquaculture",
    "Livestock" => "Livestock",
    "Agroforestry" => "Agroforestry",
    "Environment and ecology e.g. water, land, soils, conservation" => "Environment and ecology e.g. water, land, soils, conservation",
    "Trade and commerce" => "Trade and commerce",
    "Education e.g. school, university, scientific institution" => "Education e.g. school, university, scientific institution",
    "Communication e.g. media, culture, IT" => "Communication e.g. media, culture, IT",
    "Food processing e.g. freezing, cooking" => "Food processing e.g. freezing, cooking",
    "Food retail e.g. supermarkets, markets" => "Food retail e.g. supermarkets, markets",
    "Food industry e.g. hotels, catering, transport, tourism" => "Food industry e.g. hotels, catering, transport, tourism",
    "Financial Services e.g. banking, investment, insurance" => "Financial Services e.g. banking, investment, insurance",
    "Health care e.g. hospitals, maternity, general practice" => "Health care e.g. hospitals, maternity, general practice",
    "National or local government" => "National or local government",
    "Utilities e.g. water, gas, electric" => "Utilities e.g. water, gas, electric",
    "Industrial e.g. engineering, chemical, construction, textiles, extraction" => "Industrial e.g. engineering, chemical, construction, textiles, extraction",
    "other" => "Other (please state)"
];

$groups = [
    "Small-medium enterprise-artisan" => "Small-medium enterprise-artisan",
    "Large national business" => "Large national business",
    "Multinational corporation" => "Multinational corporation",
    "Small-scale farmer" => "Small-scale farmer",
    "Medium-scale farmer" => "Medium-scale farmer",
    "Large-scale farmer" => "Large-scale farmer",
    "Local Non-Governmental Organization" => "Local Non-Governmental Organization",
    "International NGO" => "International NGO",
    "Indigenous people" => "Indigenous people",
    "Science and academia" => "Science and academia",
    "Workers and trade union" => "Workers and trade union",
    "Member of Parliament" => "Member of Parliament",
    "Local authority e.g. local and subnational government" => "Local authority e.g. local and subnational government",
    "Government and national institution" => "Government and national institution",
    "Regional economic community e.g. African Union, European Union" => "Regional economic community e.g. African Union, European Union",
    "United Nations" => "United Nations",
    "International financial institution e.g. World Bank, IMF, regional bank" => "International financial institution e.g. World Bank, IMF, regional bank",
    "Private Foundation- Partnership-Alliance" => "Private Foundation- Partnership-Alliance",
    "Consumer group" => "Consumer group",
    "other" => "Other (please state)"
];

$page->assign("sectors", $sectors);
$page->assign("groups", $groups);