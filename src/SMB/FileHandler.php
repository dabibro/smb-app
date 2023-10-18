<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:39 PM
 */

namespace App\SMB;

use Exception;

class FileHandler
{

    public function ParseINI($path = "")
    {
        try {
            $this->CheckFile($path);
            return parse_ini_file($path);
        } catch (Exception $resp) {
            echo ' ' . $resp->getMessage();
        }
    }

    protected function CheckFile($file_path)
    {
        if (!file_exists($file_path)) {
            throw new Exception("Error could not find database configuration file");
        }
        return true;
    }

    public function fileExtension($s)
    {
        // strrpos() function returns the position
        // of the last occurrence of a string inside
        // another string.
        $n = strrpos($s, ".");

        // The substr() function returns a part of a string.
        if ($n === false)
            return "";
        else
            return substr($s, $n + 1);
    }
}