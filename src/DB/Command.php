<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:44 PM
 */

namespace App\DB;

use App\Handlers\DataHandlers;
use App\Handlers\Responses;

class Command extends Queries
{
    protected $table_name;
    protected $multi_table;
    protected $table_list;

    protected $field_select;
    protected $order;
    protected $limit;


    protected $pk_fields;
    protected $pk;
    protected $fields;
    protected $values;

    protected $response;

    public function __construct()
    {
        parent::__construct();

    }

    public function getRecord($varParam = NULL)
    {
        $condition = "";
        $limit = "";
        $order = "";
        if (!empty($varParam['tbl_scheme'])) {
            if (!empty($varParam['dbScheme'])):
                $this->dbScheme = $varParam['dbScheme'];
            endif;
            $this->table_name = $varParam['tbl_scheme'];
            if (!empty($varParam['field_select'])) {
                $this->field_select = $varParam['field_select'];
            } else {
                $this->field_select = " * ";
            }
            if (!empty($varParam['condition'])) {
                foreach ($varParam['condition'] as $field => $val):
                    if (!empty($val['field'])):
                        $condition .= '(' . $field . "= " . $val['field'] . ")" . ' AND ';
                    elseif (!empty($val['empty'])):
                        $condition .= '(' . $field . ")" . ' AND ';
                    else:
                        $condition .= '(' . $field . "= '" . $val . "')" . ' AND ';
                    endif;
                endforeach;
                $condition = " WHERE " . rtrim($condition, "AND ");
            }
            if (!empty($varParam['order'])) {
                $order = "ORDER BY " . $varParam['order'] . " ";
            }
            if (!empty($varParam['limit'])) {
                $limit = "LIMIT " . $varParam['limit'] . " ";
            }
            $sql = "SELECT " . $this->field_select . " FROM " . $this->dbScheme . "." . $this->table_name;
            $sql .= $condition . " " . $order . " " . $limit . ";";
            $this->response = Queries::getArray($sql);
        }
        return $this->response;
    }

    public function createRecord($varParam = NULL)
    {
        $this->table_name = $varParam['tbl_scheme'];

        if (!empty($varParam['dbScheme'])):
            $this->dbScheme = $varParam['dbScheme'];
        endif;

        if (!empty($varParam['pk'])) {
            $this->pk = $varParam['pk'];
            $pkVal = $varParam[$this->pk];
            $check_record = $this->getRecord([
                "tbl_scheme" => $this->table_name,
                "condition" => [
                    $this->pk => $pkVal
                ]
            ]);
            if ($check_record['response'] === "200"):
                die(Responses::displayResponse($check_record));
            endif;
        }

        foreach ($varParam as $field => $val):
            if ($field != "dbScheme" && $field != "tbl_scheme" && $field !== "pk"):
                $this->fields .= $field . ', ';
                $this->values .= "'" . DataHandlers::verify_input($val) . "'" . ',';
            endif;
        endforeach;
        $this->fields = rtrim($this->fields, ', ');
        $this->values = rtrim($this->values, ', ');

        $sql = "INSERT INTO " . $this->dbScheme . "." . $this->table_name;
        $sql .= " (" . $this->fields . ") VALUES (" . $this->values . ");";
        $this->response = Queries::query($sql);
        return $this->response;
    }

    public function updateRecord($varParam = NULL)
    {
        $this->table_name = $varParam['tbl_scheme'];
        if (!empty($varParam['dbScheme'])):
            $this->dbScheme = $varParam['dbScheme'];
        endif;

        if (!empty($varParam)) {
            foreach ($varParam as $field => $val):
                if ($field != "dbScheme" && $field != "tbl_scheme" && $field != "pk" && $field != "pkField" && $field != "notification" && $field != "confirmed")
                    $this->fields .= $field . " = '" . DataHandlers::verify_input($val) . "'" . ', ';
            endforeach;
            $this->fields = rtrim($this->fields, ", ");
            $this->pk_fields = $varParam['pkField'] . "='" . $varParam['pk'] . "'";
        }
        $sql = "UPDATE " . $this->dbScheme . "." . $this->table_name;
        $sql .= " SET " . $this->fields . " WHERE " . $this->pk_fields . ";";

        $this->response = Queries::query($sql);
        echo $sql;
        return $this->response;
    }

    public function deleteRecord($varParam = NULL)
    {
        $this->table_name = $varParam['tbl_scheme'];
        if (!empty($varParam['dbScheme'])):
            $this->dbScheme = $varParam['dbScheme'];
        endif;
        $pk = "";
        $fk = "";
        if (!empty($varParam['pk'])) {
            foreach ($varParam['pk'] as $pkField => $pkVal):
                $pk .= $pkField . " = '" . $pkVal . "', ";
            endforeach;
            $pk = rtrim($pk, ', ');
            if (!empty($varParam['fk'])) {
                foreach ($varParam['pk'] as $fkField => $fkVal):
                    foreach ($varParam['fk'] as $fk2):
                        $fk .= $fk2 . " = '" . $fkVal . "', ";
                    endforeach;
                endforeach;
                $fk = trim($fk, ', ');
                $fk_query = "DELETE FROM " . $this->dbScheme . "." . $this->table_name;
                $fk_query .= " WHERE (" . $fk . ");";
                //  @$this->deleteTableRecord($fk_query);
            }
            $sql = "DELETE FROM " . $this->dbScheme . "." . $this->table_name;
            $sql .= " WHERE (" . $pk . ");";

            $this->response = Queries::query($sql);
            return $this->response;
        }
    }

    public function DBTables()
    {
        if ($this->conn) {

            $sql = "SHOW TABLES ";
            $this->response = Queries::getArray($sql);

            if ($this->response['response'] !== '200') {

            } else {

                $tables = $this->response['dataArray'];

                foreach ($tables as $key) {
                    echo $key['Tables_in_' . $this->dbScheme] . '<br>';
                }


            }


            //print_r($tables);
            $request = $this->getRecord(
                [
                    'tbl_scheme' => 'config',
                    'condition' => [
                        'id' => 1
                    ]
                ]
            );
            //  print_r($request['dataArray']);
            /*
            foreach ($this->db->query($sql) as $row) {
                echo " ID: " . $row['id'] . "<br>";
                echo " Name: " . $row['biz_name'] . "<br>";
                echo " Last Name: " . $row['last_name'] . "<br>";
                echo " Email: " . $row['email'] . "<br>";
            }
            */
            //
            // $stmt = $this->db->query($sql);
            //return $stmt->fetchAll(PDO::FETCH_COLUMN);
            // $stmt->execute();
            //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            // $query = $this->conn->prepare($sql);
            // $query = $query->execute();
            // $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            //return $query->fetchAll(\PDO::FETCH_COLUMN);

        }
    }

}