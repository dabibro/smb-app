<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 09:39 PM
 */

namespace App\Handlers;


abstract class DataHandlers
{
    protected $DropDownList;
    protected $DropDownSelect;

    static function convertObj(array $data)
    {
        return json_decode(json_encode($data));
    }

    static function decodeJsonArray($data)
    {
     return  self::convertObj(json_decode(htmlspecialchars_decode($data), true));
       
    }
    static function verify_input($data)
    {
        @$data = trim($data);
        @$data = stripslashes($data);
        @$data = htmlspecialchars($data);
        @$data = self::escape_string($data);
        return $data;
    }

    static function escape_string($value)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    static function generate_random_string($strength = 6, $patter = '')
    {
        if ($patter != '') {
            $input = $patter;
        } else {
            $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    static function DropDownList($array, $key = "", $label = "", $selected = "")
    {
        if (!empty($array)) {
            foreach ($array as $list) {
                echo self::DropDownOptions($list[$key], $list[$label], $selected);
            }
        }


    }

    static function DropDownOptions($key, $label = "", $selected = "")
    {
        if (!empty($key)) {
            if (!empty($label)) {
                if (!empty($selected)) if ($selected === $key) $DropDownSelect = " selected";
                $DropDownList = "<option value='" . $key . "' " . $DropDownSelect . ">" . $label . "</option>";
            } else {
                if ($selected === $key) $DropDownSelect = " selected";
                $DropDownList = "<option value='" . $key . "' " . $DropDownSelect . " >" . $key . "</option>";
            }
            return $DropDownList;
        }
    }

}