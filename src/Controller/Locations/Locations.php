<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 16/10/2023
 * Time: 03:45 PM
 */

namespace App\Controller\Locations;


use App\DB\Command;

abstract class Locations extends Command
{


    static function Locations($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0
        ];
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->locations,
                'condition' => $condition,
                'order' => 'location_name ASC'
            ]
        )['dataArray'];
        if (!empty($data)) $resp = $data;
        return $resp;
    }

    static function LocationName($reference = "")
    {
        if (!empty($reference)) return self::Locations(['reference' => $reference])[0]['location_name'];
    }
}