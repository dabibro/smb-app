<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 16/10/2023
 * Time: 03:45 PM
 */

namespace App\Utility;




abstract class Constants 
{


    /**
     * @param array $params
     * @return array
     */
    static function Gender(): array
    {
        
        $resp =
        [
             [
                "label" => "MALE",
                "value" => "male",
            ],
            [
                "label" => "FEMALE",
                "value" => "female",
            ],

        ];
        return $resp;
    }

    static function MaritalStatus(): array
    {
        
        $resp =
        [
             [
                "label" => "SINGLE",
                "value" => "single",
            ],
            [
                "label" => "MARRIED",
                "value" => "married",
            ],

        ];
        return $resp;
    }

    static function EmploymentType(): array
    {
        
        $resp =
        [
             [
                "label" => "FULL TIME",
                "value" => "fulltime",
            ],
            [
                "label" => "CONTRACT",
                "value" => "contract",
            ],

        ];
        return $resp;
    }
}