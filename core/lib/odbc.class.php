<?php

class Odbc
{

    var $dns = "Hotel2000";

    var $user = "";

    var $pwd = "";

    var $table = "schede";

    // var $dbRoot= "C:\\Documents and Settings\\Guto\\Os meus documentos\\db1.mdb;";
    var $conn = null;

    // m�todo constructor
    function __construct()
    {
        
        // self::dnsConf(); este metodo n�o est� a funcionar ainda
        self::open_conn();
    }

    // inicia o recurso de liga��o
    function open_conn()
    {
        $this->conn = odbc_connect($this->dns, $this->user, $this->pwd);
        if (! is_resource($this->conn)) {
            $this->conn = odbc_pconnect($this->dns, $this->user, $this->pwd);
        }
        if (is_resource($this->conn))
            return true;
        else
            return false;
    }

    // fecha a liga��o existente com a base de dados
    function close_conn()
    {
        return odbc_close($this->conn);
    }

    /*
     *
     *
     * Attempt to config DSN directly
     *
     * function dnsConf()
     * {
     * $conf = "DRIVER=Microsoft Access Driver (*.mdb);";
     * $conf .= "{$this->dbRoot}";
     * $conf .= "UserCommitSync=Yes;";
     * $conf .= "Threads=3;";
     * $conf .= "SafeTransactions=0;";
     * $conf .= "PageTimeout=5;";
     * $conf .= "MaxScanRows=8;";
     * $conf .= "MaxBufferSize=2048;";
     * $conf .= "DriverId=281;";
     * $conf .= "DefaultDir=C:/Programas/Ficheiros comuns/ODBC/Data Sources";
     * return $conf;
     *
     * echo gettype($conf);
     * }
     *
     */
    
    /**
     * executa um pedido � base de dados
     *
     * @param clausula $sql
     * @return resource query ou bool false
     */
    function exec_query($sql)
    {
        
        if (! empty($sql)) {
            $query = odbc_exec($this->conn, $sql) or die("DATABASE QUERY ERROR " . odbc_errormsg());
            return $query;
            echo gettype($query);
        } else {
            $this->close_conn();
            return false;
        }
    }

    /**
     * Forma como o resultado � apresentado
     *
     * @param resource $query
     * @param marker $marker
     * @param
     *            number of rows $row_number
     * @param array $arr_data
     * @return array/object/bool/int
     */
    function fetch_data($query, $marker = 0, $row_number = NULL, $arr_data = NULL)
    {
        switch ($marker) {
            case 0:
                $line = odbc_fetch_array($query, $row_number);
                break;
            case 1:
                $line = odbc_fetch_object($query, $row_number);
                break;
            case 2:
                if ($res_id == NULL)
                    print "Parameter $ res_id is needed";
                else
                    $line = odbc_fetch_row($query, $row_number);
                break;
            case 3:
                $line = odbc_fetch_into($query, $arr_data);
            default:
                return false;
        }
        return $line;
    }

    /**
     * Fornece o numero de colunas
     *
     * @param resource $query
     * @return int
     */
    function num_rows($query)
    {
        $num = odbc_num_rows($query);
        if ($num > 0)
            return $num;
        else
            return false;
    }

    /**
     * Fornece o numero de campos
     *
     * @param resource $query
     * @return int
     */
    function num_fields($query)
    {
        $fields = odbc_num_fields($query);
        if ($fields > 0)
            return $fields;
        else
            return false;
    }

    /**
     * Rollback a transaction
     *
     * @param
     *            none
     * @return bool
     */
    function rollback()
    {
        if (is_resource($this->conn))
            return odbc_rollback($this->conn);
        else
            return false;
    }

    /**
     * Commit an ODBC transaction
     *
     * @param
     *            none
     * @return bool
     */
    function commit()
    {
        if (is_resource($this->conn))
            return odbc_commit($this->conn);
        else
            return false;
    }

    /**
     * encerra todas as liga��es ODBC existentes
     *
     * @param
     *            none
     * @return void
     */
    function unset_conn()
    {
        return odbc_close_all();
    }

    /**
     * Fornece informa��o sobre a BD actual
     *
     * @param int $fecth_type
     * @return array [db info]
     */
    function db_info($fetch_type = 1)
    {
        $info = odbc_data_source($this->conn, $fetch_type);
        
        foreach ($info as $data) {
            $temp[] = $data;
        }
        return $temp;
    }

    /**
     * Prepara e executa um pedido SQL
     *
     * @param
     *            sql clausule $query
     * @return resource
     */
    function Prepare($query)
    {
        if (! empty($query) && is_resource($this->conn)) {
            
            $preExec = odbc_do($this->conn, $query);
        }
        
        if (is_resource($preExec))
            return $preExec;
        else
            return false;
    }

    function go_next($query)
    {
        if (is_resource($query)) {
            $next = odbc_next_result($query);
        }
        return $next;
    }

    /**
     * Devolve o nome do cursor para o recurso forcecido
     *
     * @param resource $query
     * @return string [cursor_name]
     */
    function get_cursor($query)
    {
        if (! empty($query) && is_resource($query))
            
            return odbc_cursor($query);
        
        else
            return false;
    }

    /**
     * Permite manipular colunas longas
     *
     * @param resource $query
     * @param int $length
     * @return bool
     */
    function handle_columns($query, $length, $mode)
    {
        if (is_resource($query) && is_int($length)) {
            
            switch ($mode) {
                case 'len':
                    $_mode = odbc_longreadlen($query, $length);
                    break;
                case 'bin':
                    $_mode = odbc_binmode($query, $length);
                    break;
                default:
                    return false;
            }
            return $_mode;
        }
    }

    /**
     * Permite obter informa��es acerca dos campos da tabela
     *
     * @param resource $query
     * @param mix $value
     * @param string $mode
     * @return mix [$handle]
     */
    function handle_fields($query, $value, $mode)
    {
        switch ($mode) {
            
            case 'len':
                $handle = odbc_field_len($query, $value);
                break;
            case 'name':
                $handle = odbc_field_name($query, $value);
                break;
            case 'num':
                $handle = odbc_field_num($query, $value);
                break;
            case 'pres':
                $handle = odbc_field_precision($query, $value);
                break;
            case 'scale':
                $handle = odbc_field_scale($query, $value);
                break;
            case 'type':
                $handle = odbc_field_type($query, $value);
                break;
            default:
                return false;
        }
        return $handle;
    }

    /**
     * Permite inserir os dados na tabela
     *
     * @param array $fields
     * @return resource $insert
     */
    function Insert($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $rows => $values) {
                $arrRows[] = "" . $rows . "";
                $arrValues[] = "'" . $values . "'";
            }
            $strRows = implode(", ", $arrRows);
            
            $strValues = implode(", ", $arrValues);
        }
        $query = "INSERT INTO " . $this->table . "($strRows) VALUES ($strValues);";
        
        $insert = $this->exec_query($query);
        
        if ($insert) {
            echo "Data inserted successfully !";
        }
        return $insert;
    }

    /**
     * Executa clausulas personalizadas
     * de actualiza��o da base de dados
     *
     * @param array $set
     * @param array $where
     * @param int $marker
     * @return resource [update] $res
     */
    function Update($set, $where = NULL, $marker)
    {
        foreach ($set as $data => $info) {
            $_data[] = $data . " = " . "'{$info}'";
        }
        $strRows = implode(",", $_data);
        
        switch ($marker) {
            
            case 0:
                $update = "UPDATE $this->table SET	{$strRows}";
                break;
            
            case 1:
                foreach ($where as $rows => $_info) {
                    $Rowsinfo[] = $rows . "=" . "'{$_info}'";
                }
                $strWhere = implode(",", $Rowsinfo);
                
                $update = "UPDATE $this->table SET {$strRows} WHERE {$strWhere}";
                
                break;
            
            default:
                
                return false;
        }
        
        $res = $this->exec_query($update);
        
        if (is_resource($res)) {
            return $res;
        }
    }

    /**
     * Apaga os campos indicados pela clausula sql
     *
     * @param
     *            pos where clausule $sql
     * @return resource [delete]
     */
    function delete($sql)
    {
        if (! empty($sql)) {
            $query = "DELETE FROM " . $this->table . " WHERE " . $sql;
            $del = self::Prepare($query);
        }
        return $del;
    }

    /**
     * Permite obter os resultados da tabela
     *
     * @param string $sql
     * @param array $rows
     * @param int $row_num
     * @return array [results]
     */
    function results($sql)
    {
        $count = 0;
        $data = array();
        
        $res = self::exec_query($sql);
        
        while ($row = @odbc_fetch_array($res)) {
            $data[$count] = $row;
            $count ++;
        }
        @odbc_free_result($res);
        return $data;
    }

    /**
     * Imprime os resultados numa tabela HTML
     *
     * @param string $sql
     * @return unknown
     */
    function TableResults($sql)
    {
        if (! empty($sql) && is_string($sql)) {
            
            $results = self::exec_query($sql);
        }
        return @odbc_result_all($results);
    }

    /**
     * Apaga a tabela informada
     *
     * @return resource [$query]
     */
    function DropTable($table)
    {
        return self::exec_query("DROP TABLE {$table}");
    }

    // {{ Perquisar acerca destes m�todos e implement�los
    /*
     * function Create_Table($values)
     * {
     * foreach($values as $Rows => $Type)
     * {
     * $arrfields[] = $Rows;
     * $dataType[] = $Type;
     * $arrValues[] = "".$Rows." ".$Type."";
     * }
     *
     *
     * $table = $values["TABLE"];
     * $arr_rows = implode(", ",$arrfields);
     * $fields = substr($arr_rows,10,strlen($arr_rows));
     * $strFields = implode(", ",$arrValues);
     * $Fields = substr($strFields,strlen($table)+7,strlen($strFields));
     *
     * #if($this->Check_Table($table)!=true){
     * $gen_table = $this->Exec_Query("CREATE TABLE ".$table." (".$Fields.")");
     * #}
     *
     * return $gen_table;
     * }
     *
     *
     *
     *
     *
     * function Check_Table($table)
     * {
     * $result = $this->exec_query("SELECT name FROM odbc_master WHERE type='table' AND name='".$table."'");
     * if(odbc_conn::num_rows($result) > 0){
     * return true;
     * }
     * }
     *
     *
     */
    // }}}
    
    /**
     * Tipo de dados suportado
     *
     * @return resource [#int]
     */
    function DataType()
    {
        return odbc_gettypeinfo($this->conn);
    }
} // end of class

?>