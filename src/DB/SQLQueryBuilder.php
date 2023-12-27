<?php

namespace App\DB;

use App\Handlers\DataHandlers;

class SQLQueryBuilder extends Queries
{
    private $query;
    protected $response;
    protected $fields;
    protected $values;


    public function select($columns = ['*'])
    {
        $this->query = "SELECT " . implode(', ', $columns);
        return $this;
    }

    public function from($table)
    {
        $this->query .= " FROM $this->dbScheme.$table";
        return $this;
    }

    public function innerJoin($table, $onCondition)
    {
        $this->query .= " INNER JOIN $table ON $onCondition";
        return $this;
    }

    public function leftJoin($table, $onCondition)
    {
        $this->query .= " LEFT JOIN $table ON $onCondition";
        return $this;
    }

    public function rightJoin($table, $onCondition)
    {
        $this->query .= " RIGHT JOIN $table ON $onCondition";
        return $this;
    }

    public function orderBy($column)
    {
        $this->query .= " ORDER BY $column";
        return $this;
    }

    public function where($condition)
    {
        $this->query .= " WHERE $condition";
        return $this;
    }

    public function and ($condition)
    {
        $this->query .= " AND $condition";
        return $this;
    }

    public function insert($table, $values)
    {
        foreach ($values as $field => $val):
            if ($field != "dbScheme" && $field != "tbl_scheme" && $field !== "pk"):
                $this->fields .= $field . ', ';
                $this->values .= "'" . DataHandlers::verify_input($val) . "'" . ',';
            endif;
        endforeach;
        $this->fields = rtrim($this->fields, ', ');
        $this->values = rtrim($this->values, ', ');

        $this->query = "INSERT INTO " . $this->dbScheme . "." . $table;
        $this->query .= " (" . $this->fields . ") VALUES (" . $this->values . ");";

        // $this->query = "INSERT INTO $this->dbScheme.$table ($columns) VALUES ($placeholders)";
        return $this;
    }

    public function update($table, $values)
    {
        if (!empty($values)) {
            foreach ($values as $field => $val):
                if ($field != "pk" && $field != "pkField")
                    $this->fields .= $field . " = '" . DataHandlers::verify_input($val) . "'" . ', ';
            endforeach;
            $this->fields = rtrim($this->fields, ", ");
            $pk_fields = $values['pkField'] . "='" . $values['pk'] . "'";
        }
        $this->query = "UPDATE " . $this->dbScheme . "." . $table;
        $this->query .= " SET " . $this->fields . " WHERE " . $pk_fields;
        return $this;
    }

    public function delete($table)
    {
        $this->query = "DELETE FROM $table";
        return $this;
    }

    public function getQuery()
    {
        $this->query .= ";";
        return Queries::query($this->query . PHP_EOL);
    }

    public function getQueryArray()
    {
        $this->query .= ";";
        return Queries::getArray($this->query . PHP_EOL);
    }
}


