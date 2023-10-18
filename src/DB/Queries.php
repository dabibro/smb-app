<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:45 PM
 */

namespace App\DB;


use App\Handlers\DataHandlers;
use App\Handlers\Responses;
use App\SMB\FileHandler;

class Queries extends MysqliConn
{
    protected $conn;
    protected $db_config;
    protected $dbScheme;

    public function __construct()
    {
        $this->conn = MysqliConn::openConnection();
        $fileHandler = new FileHandler();
        $this->db_config = $fileHandler->ParseINI(DB_CONFIG);
        $this->db_config = DataHandlers::convertObj($this->db_config);
        $this->dbScheme = $this->db_config->DBName;
        parent::__construct();

    }


    public function query($SQL)
    {
        $resp = $this->conn->query($SQL);
        if ($this->conn->errno && !empty($this->conn->errno)) {
            $response = Responses::getResponse('500');
            $response['message'] = 'Internal server error. MySQL error: ' . $this->conn->error . ' ' . $this->conn->errno;
        } else {
            $response = Responses::getResponse('200');
            $response['dataArray'] = $resp;
        }
        return $response;
    }

    public function getArray($SQL)
    {
        $resp = $this->query($SQL);
        if (!empty($resp['success'])) {
            $data = $resp['dataArray'];
            $rows = $data->num_rows;
            if (!empty($rows)) {
                $results_array = array();
                $result = $data;
                while ($row = $result->fetch_assoc()) {
                    $results_array[] = $row;
                }
                $rsArray = $results_array;
                $response = Responses::getResponse('200');
                $response['dataArray'] = $rsArray;

            } else {
                $response = Responses::getResponse('204');
                $response['message'] = 'Query did not return any results.';
            }
        } else {
            $response = Responses::getResponse('204');
            $response['message'] = 'Query did not return any results.';
        }
        return $response;
    }

}