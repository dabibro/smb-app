<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:42 PM
 */

namespace App\SMB;

use App\DB\Command;
use App\DB\MysqliConn;
use App\DB\Queries;

class SMB extends Command
{
    public $auth;

    public function __construct()
    {
        MysqliConn::openConnection();
        parent::__construct();
    }

    public function BizInfo()
    {
        return $this->getRecord(
            [
                'tbl_scheme' => $this->config,
                'limit' => 1
            ]
        )['dataArray'];

    }

    function CurrentTimeStamp()
    {
        $sql = "SELECT CURRENT_TIMESTAMP as cts from " . $this->config . " ";
        return Queries::getArray($sql)['dataArray'][0]['cts'];

    }

}