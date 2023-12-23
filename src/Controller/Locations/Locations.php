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


    /**
     * @param array $params
     * @return array
     */
    static function Locations($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0,
            'companyId' => $_SESSION[$cmd->companyId]

        ];
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->locations,
                'condition' => $condition,
                'order' => 'location_name ASC'
            ]
        );
        
        if (isset($data['dataArray'])) {
            $resp = $data['dataArray'];
        } else {
            $resp = []; 
        }
        
        return $resp;
    }

    static function LocationName($reference = "")
    {
        $result = self::Locations(['reference' => $reference]);
        return $result[0]['location_name'] ?? "N/A";
    }
}