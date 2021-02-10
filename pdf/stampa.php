<?php
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_DEPRECATED & ~ E_WARNING);

// Se è stampa lato server
if (preg_match("/Win/i", PHP_OS)) {
    $gruppo = User::getLoggedUserGroup();
    $idUtente = User::getLoggedUserId();
} else if ($argc > 1) {

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

    $alias = $argv[1];
    $file = $argv[2];
    $id = $argv[3];
    $class = $argv[4];
    $gruppo = $argv[5];
    $idUtente = $argv[6];
    
    // Devo ricaricare l'oggetto qui
    if (class_exists($class)) {
        $obj = new $class($id, false);
        $titolo = $obj->servizio;
    }
}

$path = "$alias/$file.pdf.php";

if (file_exists($path)) {
    $html = $barcode = "";

    $top = 45;
    $bottom = 45;
    $right = 15;
    $left = 15;
    $printHeader = true;
    $printFooter = true;

    $data = date("d/m/Y");
    $elaborazione = "Stampa del $data";

    if (PHP_VERSION >= 5.6) {
        $setting = array(
            'mode' => 'c',
            'format' => 'A4',
            'default_font_size' => 0,
            'default_font' => '',
            'margin_left' => $left,
            'margin_right' => $right,
            'margin_top' => $top,
            'margin_bottom' => $bottom,
            'margin_header' => 1,
            'margin_footer' => 4,
            'orientation' => 'L'
        );
        $pdf = new \Mpdf\Mpdf($setting);
    } else
        $pdf = new mPDF('c', 'A4', '', '', $left, $right, $top, $bottom, 1, 4);

    $_SESSION["pdf"]["id_utente"] = $idUtente;

    $pathEnte = "../core/templates/mg/logo.png";
    if (file_exists($pathEnte))
        $logoEnte = "<img src='$pathEnte' height='90' />";

    /**
     * includo il file specifico
     */
    include $path;

    $pdf->SetTitle($titolo);

    // Ridefinisco i margini in caso in cui all'interno del file $path, vengano cambiati
    $pdf->DeflMargin = $left;
    $pdf->DefrMargin = $right;
    $pdf->SetTopMargin($top);
    $pdf->ResetMargins();

    $pdf->SetDisplayMode('fullpage');
    $pdf->FontSize = 6;
    $stylesheet = file_get_contents("style.css");
    $pdf->WriteHTML($stylesheet, 1);
    $pdf->simpleTables = true;
    $pdf->AliasNbPages('[pagetotal]');

    // ------
    // Header
    // ------
    if ($printHeader) {
        $header = "<div style='width:30%; float:left; padding-top:30px;'>{DATE j/m/Y}</div><div style='padding-top:30px; float:right; width:70%;'>$barcode</div>";
        $pdf->SetHTMLHeader($header);
    }

    // ------
    // Footer
    // ------
    if ($printFooter) {
        if (empty($footer))
            $footer = "<div style='width:70%; float:left;'></div><div style='float:right; width:30%; text-align:right;'>{PAGENO}/[pagetotal]</div>";
        $pdf->SetHTMLFooter($footer);
    }

    $pdf->autoPageBreak = false;
    $pdf->WriteHTML($html);

    // -----------------
    // Visualizzo il PDF
    // -----------------
    $pdf->Output("$file.pdf", 'I');

    // --------------------
    // Salvo su file il PDF
    // se non esiste un file aggiornato agli ultimi 60 minuti
    // --------------------
    $directory = Config::$publicRoot . DS . $class . DS . $id;
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
        $time = date("ymdHis");
        $pdf->Output($directory . DS . $time . ".pdf", "F");
    } else {
        $files = glob("$directory/*.pdf");
        usort($files, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

        $last_file = count($files > 0) ? end($files) : null;
        $diff = time() - 60 * 1 - filemtime($last_file);

        if (empty($files) || empty($last_file) || $diff > 0) {

            $time = date("ymdHis");
            $pdf->Output($directory . DS . $time . ".pdf", "F");
        }
    }
} else
    Page::redirect("notauth", "pdf|$file");