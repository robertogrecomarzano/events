<?php

class PdfUtility
{

    /**
     * Crea un pdf con duplice copia a partire da un file pdf
     *
     * @param string $file
     */
    static function creaDupliceCopiaPdf($file)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 50,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $mpdf->SetImportUse();

        $ow = $mpdf->h;
        $oh = $mpdf->w;
        $pw = $mpdf->w / 2;
        $ph = $mpdf->h;

        $mpdf->SetDisplayMode('fullpage');

        $pagecount = $mpdf->SetSourceFile($file);
        $pp = self::GetBookletPages($pagecount);

        foreach ($pp as $v) {
            $mpdf->AddPage();

            if ($v[0] > 0 && $v[0] <= $pagecount) {
                $tplIdx = $mpdf->ImportPage($v[0], 0, 0, $ow, $oh);
                $mpdf->UseTemplate($tplIdx, 0, 0, $pw, $ph);
            }

            if ($v[1] > 0 && $v[1] <= $pagecount) {
                $tplIdx = $mpdf->ImportPage($v[1], 0, 0, $ow, $oh);
                $mpdf->UseTemplate($tplIdx, $pw, 0, $pw, $ph);
            }
        }
        $dirname = dirname($file);

        copy($file, $dirname . DS . basename($file, '.pdf') . ".ori.pdf");

        $mpdf->Output($file);
    }

    /**
     * Converte un pdf in formato A5
     * 2 pagine per foglio in orizzontale
     *
     * @param string $file
     */
    static function convertToA5($file)
    {
        $dirname = dirname($file);
        $new = $dirname . DS . basename($file, '.pdf') . ".a5.pdf";
        
        
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 50,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $mpdf->SetImportUse();

        $ow = $mpdf->h;
        $oh = $mpdf->w;
        $pw = $mpdf->w / 2;
        $ph = $mpdf->h;

        $mpdf->SetDisplayMode('fullpage');

        $pagecount = $mpdf->SetSourceFile($file);

        for ($i = 1; $i <= $pagecount; $i ++) {
            if ($i % 2 != 0)
                $mpdf->AddPage();

            $tplIdx = $mpdf->ImportPage($i, 0, 0, $ow, $oh);

            if ($i % 2 != 0)
                $mpdf->UseTemplate($tplIdx, 0, 0, $pw, $ph);
            else
                $mpdf->UseTemplate($tplIdx, $pw, 0, $pw, $ph);
        }

        $mpdf->Output($new);
    }

    /**
     * Ritorna l'array con le pagine per la creazione di un documento A5
     *
     * @param int $np
     * @param boolean $backcover
     * @return array
     */
    static function GetBookletPages($np, $backcover = true)
    {
        $lastpage = $np;

        if ($np == 1)
            $np = 2;
        else
            $np = 4 * ceil($np / 4);

        $pp = array();

        for ($i = 1; $i <= $np / 2; $i ++) {

            $p1 = $np - $i + 1;

            if ($backcover) {
                if ($i == 1) {
                    $p1 = $lastpage;
                } elseif ($p1 >= $lastpage) {
                    $p1 = 0;
                }
            }

            $pp[] = ($i % 2 == 1) ? array(
                $p1,
                $i
            ) : array(
                $i,
                $p1
            );
        }

        return $pp;
    }
}