<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:43 PM
 */

namespace App\DB;


use App\Handlers\DataHandlers;
use App\SMB\FileHandler;
use mysqli;

abstract class MysqliConn extends DBTables
{
    protected $DBHost;
    protected $DBUsername;
    protected $DBPassword;
    protected $DBName;

    protected $db_config;
    protected $conn;

    public function __construct()
    {
        parent::__construct();
    }

    protected function openConnection()
    {
        $fileHandler = new FileHandler();
        $this->db_config = $fileHandler->ParseINI(DB_CONFIG);
        $this->db_config = DataHandlers::convertObj($this->db_config);

        $this->DBHost = $this->db_config->DBHost;
        $this->DBUsername = $this->db_config->DBUsername;
        $this->DBPassword = $this->db_config->DBPassword;
        $this->DBName = $this->db_config->DBName;


        $this->conn = new mysqli($this->DBHost, $this->DBUsername, $this->DBPassword, $this->DBName);
        if (@$this->conn->connect_error) {
            die("There is some problem in connection: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}