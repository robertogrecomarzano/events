<?php

class OrmObj
{

    public $orm_record;

    public $orm_pk_value = 0;

    public function readSchema()
    {
        $dbh = Database::getDb();
        $q = $dbh->prepare("DESCRIBE `" . $this->ormTable . "`");
        $q->execute(array(
            $this->ormTable
        ));
        $table_fields = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table_fields as $f) {
            if ($f["Key"] == "PRI") {
                $this->ormPrimaryKey = $f["Field"];
                break;
            }
        }
        $this->ormSchema = $table_fields;
    }

    function orm_get()
    {
        $sql = "SELECT * FROM `$this->orm_table` WHERE `$this->orm_pk_field` = ?";

        $this->orm_record = Database::getRow($sql, array(
            $this->orm_pk_value
        ), PDO::FETCH_OBJ);

        return $this->orm_record;
    }

    /**
     * Restituisce tutte le righe con possibilità di filtro
     *
     * @param array $filter
     */
    function orm_all($filter = null, $condition = "AND")
    {
        $sql = "SELECT * FROM `$this->orm_table`";
        $params = [];
        if (! empty($filter)) {
            $sql .= " WHERE ";
            $fields = array_keys($filter);
            array_walk($fields, function (&$v, $k) {
                $v .= " = ?";
            });
            $sql .= implode(" $condition ", $fields);
            $params = array_values($filter);
        }
        $sql .= " ORDER BY $this->orm_pk_field ASC";
        return Database::getRows($sql, $params, PDO::FETCH_OBJ);
    }

    /**
     * Restituisce tutte le righe con possibilità di filtro
     *
     * @param array $filter
     */
    function orm_all_key_pair($label, $filter = null, $order = null)
    {
        $sql = "SELECT  `$this->orm_pk_field`, $label FROM `$this->orm_table`";
        $params = [];
        if (! empty($filter)) {
            $sql .= " WHERE ";
            $fields = array_keys($filter);
            array_walk($fields, function (&$v, $k) {
                $v .= " = ?";
            });
            $sql .= implode(" AND ", $fields);
            $params = array_values($filter);
        }
        if (empty($order))
            $order = $label;
        $sql .= " ORDER BY $order ASC";

        return Database::getRows($sql, $params, PDO::FETCH_KEY_PAIR);
    }

    function orm_save()
    {
        $isNew = ! ($this->orm_pk_value > 0);
        $params = array();
        $values = array();
        foreach ($this->orm_record as $field => $value) {
            if ($field == $this->orm_pk_field && $isNew)
                continue;
            $params[] = "`$this->orm_table`." . $field . " = ?";
            $values[] = $value;
        }
        $paramList = implode(", ", $params);
        // echo $paramList;

        if ($isNew)
            $sql = "INSERT INTO `$this->orm_table` SET " . $paramList;
        else {
            $sql = "UPDATE `$this->orm_table` SET " . $paramList . " WHERE `$this->orm_pk_field` = ?";
            $values[] = $this->orm_pk_value;
        }

        $ret = Database::query($sql, $values);

        if ($isNew) {
            $db = Database::getDb();
            $this->orm_pk_value = $db->lastInsertId();
        }

        return $ret;
    }

    function orm_delete()
    {
        $sql = "DELETE FROM `$this->orm_table` WHERE `$this->orm_pk_field` = ?";
        $ret = Database::query($sql, [
            $this->orm_pk_value
        ]);
        return $ret;
    }
}