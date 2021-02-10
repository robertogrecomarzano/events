<?php

class Xls
{

    /**
     *
     * @var string $xls_data Variable that holds the XLS File
     * @access private
     */
    var $xls_data;

    /**
     *
     * @var string $xlsName Output Filename. No extension should be given as the class, as the class automatically attaches the XLS extension
     * @access private
     */
    var $xlsName;

    /**
     * Percorso dove salvare il file creato, da rendere disponibile per il download
     *
     * @var string
     */
    var $path;

    function Xls($filename = 'spreadsheet', $path = null)
    {
        $this->xls_data = "";
        $this->xlsName = $filename;
        $this->path = $path;
        $this->_excelStart();
    }

    /**
     *
     * Writes a value to a cell in the in-memory file
     *
     * @access public
     * @param int $xls_line
     *            Spreadsheet row (zero-based)
     * @param int $xls_col
     *            Spreadsheet column (zero-based)
     * @param mixed $value
     *            Cell value (String or Numeric)
     */
    function WriteValue($xls_row, $xls_col, $value, $type = "")
    {
        switch ($type) {
            case "LONG":
            case "TINY":
            case "SHORT":
            case "NEWDECIMAL":
                $this->WriteCellNumber($xls_row, $xls_col, $value);
                break;
            default:
                $this->WriteCellText($xls_row, $xls_col, $value);
                break;
        }
    }

    /**
     * Generates a XLS File from an SQL Query (and outputs it to the browser)
     *
     * @param string $query
     * @param array $params
     */
    function WriteSQLDump($query, $params = array())
    {
        $xls_line = 0;
        $col = 0;
        $db = Database::getInstance();
        $st = $db->getDb()->prepare($query);
        $res = $st->execute($params);
        if (! $res) {
            $page = Page::getInstance();
            $page->addError("Errore nella query, file non creato.");
            return null;
        }
        
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
        
        $colums = $st->columnCount();
        $lines = count($data);

        $e = 0;
        foreach (array_keys($data[0]) as $key)
            $this->WriteValue(0, $e ++, trim(ucwords(str_replace("_", " ", $key))));
        
        $i = 1;
        foreach ($data as $riga) {
            $col = 0;
            foreach ($riga as $key => $value) {
                $type = $st->getColumnMeta($col);
                $this->WriteValue($i, $col ++, $value, $type["native_type"]);
            }
            $i ++;
        }
        
        return $this->OutputFile();
    }

    /**
     *
     * Closes the XLS File and Sends it to the browser
     *
     * @access public
     */
    function OutputFile()
    {
        $this->_excelEnd();
        
        if (empty($this->path)) {
            $now = gmdate('D, d M Y H:i:s') . ' GMT';
            $USER_BROWSER_AGENT = $this->_get_browser_type();
            
            ob_clean(); // Pulisco il buffer [RGM]
            
            header('Content-Type: ' . $this->_get_mime_type());
            header("Content-Description: IAM Generated Excel File");
            header('Expires: ' . $now);
            
            if ($USER_BROWSER_AGENT == 'IE') {
                header('Content-Disposition: attachment; filename="' . $this->xlsName . ".xls");
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
            } else {
                header('Content-Disposition: attachment; filename="' . $this->xlsName . ".xls");
                header('Pragma: no-cache');
            }
            print($this->xls_data);
        } else {
            $filename = $this->xlsName . ".xls";
            if (! file_exists($this->path))
                mkdir($this->path, 077, true);
            
            file_put_contents($this->path . DS . $filename, $this->xls_data);
            
            return array(
                "path" => $this->path,
                "filename" => $filename
            );
        }
    }

    /**
     *
     * Writes The XLS Header to the in-memory file
     *
     * @access private
     */
    function _excelStart()
    {
        $this->xls_data = pack("vvvvvv", 0x809, 0x08, 0x00, 0x10, 0x0, 0x0);
    }

    /**
     *
     * Writes The XLS End-of-File sequence to the in-memory file
     *
     * @access private
     */
    function _excelEnd()
    {
        $this->xls_data .= pack("vv", 0x0A, 0x00);
    }

    /**
     *
     * Writes a numeric value to a cell in the in-memory file
     *
     * @access public
     * @param int $xls_row
     *            Spreadsheet row (zero-based)
     * @param int $xls_col
     *            Spreadsheet column (zero-based)
     * @param float $value
     *            Cell value
     */
    function WriteCellNumber($xls_row, $xls_col, $value)
    {
        settype($value, 'float');
        settype($row, 'integer');
        settype($col, 'integer');
        
        $this->xls_data .= pack("sssss", 0x0203, 14, $xls_row, $xls_col, 0x00);
        $this->xls_data .= pack("d", $value);
    }

    /**
     *
     * Writes a string value to a cell in the in-memory file
     *
     * @access public
     * @param int $xls_row
     *            Spreadsheet row (zero-based)
     * @param int $xls_col
     *            Spreadsheet column (zero-based)
     * @param float $value
     *            Cell value
     */
    /**
     * Error handling for long strings, added by Robin Newman
     */
    function WriteCellText($xls_row, $xls_col, $value)
    {
        settype($value, 'string');
        settype($row, 'integer');
        settype($col, 'integer');
        
        $len = strlen($value);
        /*
         * if ($len > 255) {
         * $value = "#STRING TOO LONG:" . $len;
         * $len = strlen($value);
         * }
         */
        $this->xls_data .= pack("s*", 0x0204, 8 + $len, $xls_row, $xls_col, 0x00, $len);
        $this->xls_data .= $value;
    }

    /**
     *
     * Define the client's browser type
     *
     * @access private
     * @return String A String containing the Browser's type or brand
     */
    function _get_browser_type()
    {
        $USER_BROWSER_AGENT = "";
        
        if (ereg('OPERA(/| )([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
            $USER_BROWSER_AGENT = 'OPERA';
        } else if (ereg('MSIE ([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
            $USER_BROWSER_AGENT = 'IE';
        } else if (ereg('OMNIWEB/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
            $USER_BROWSER_AGENT = 'OMNIWEB';
        } else if (ereg('MOZILLA/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
            $USER_BROWSER_AGENT = 'MOZILLA';
        } else if (ereg('KONQUEROR/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
            $USER_BROWSER_AGENT = 'KONQUEROR';
        } else {
            $USER_BROWSER_AGENT = 'OTHER';
        }
        
        return $USER_BROWSER_AGENT;
    }

    /**
     *
     * Define MIME-TYPE according to target Browser
     *
     * @access private
     * @return String A string containing the MIME-TYPE String corresponding to the client's browser
     */
    function _get_mime_type()
    {
        $USER_BROWSER_AGENT = $this->_get_browser_type();
        
        $mime_type = ($USER_BROWSER_AGENT == 'IE' || $USER_BROWSER_AGENT == 'OPERA') ? 'application/octetstream' : 'application/octet-stream';
        return $mime_type;
    }
}