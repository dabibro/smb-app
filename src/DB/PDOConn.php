<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 12/10/2023
 * Time: 12:07 PM
 */

namespace App\DB;

use PDO;
use PDOException;

class PDOConn
{

    private $server = "mysql:host=localhost;dbname=smb_leyo";

    private $user = "root";

    private $pass = "";

    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);

    protected $con;

    public function openConnection()

    {

        try {

            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);

            return $this->con;

        } catch (PDOException $e) {

            echo "There is some problem in connection: " . $e->getMessage();

        }

    }

    public function closeConnection()
    {

        $this->con = null;

    }

}
