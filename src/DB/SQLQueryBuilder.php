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

    public function orderBy($column, $onCondition)
    {
        $this->query .= " ORDER BY $column  $onCondition";
        return $this;
    }

    public function where($condition)
    {
        $this->query .= " WHERE $condition";
        return $this;
    }

    public function and($condition)
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
        $setClause = '';
        foreach ($values as $column => $value) {
            $setClause .= "$column = :$column, ";
        }
        $setClause = rtrim($setClause, ', ');

        $this->query = "UPDATE $table SET $setClause";
        return $this;
    }

    public function delete($table)
    {
        $this->query = "DELETE FROM $table";
        return $this;
    }

    public function getQuery()
    {
       echo $this->query;
       return Queries::query($this->query.PHP_EOL); 
    }
}


