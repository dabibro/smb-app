<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:39 PM
 */

namespace App\Handlers;

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
            throw new Exception("Error could find file");
        }
        return true;
    }

    public function fileExtension($s)
    {
        $n = strrpos($s, ".");
        if ($n === false)
            return "";
        else
            return substr($s, $n + 1);
    }

    public function fileTempParse($filename, $varParam)
    {
        ob_start();
        if ($varParam != null):
            extract($varParam);
        endif;
        include($filename);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function JsonReader($jsonfile)
    {
        $resp = "";
        if (file_exists($jsonfile)) {
            $data = file_get_contents($jsonfile);
            $data = json_decode($data);
            $resp = $data;
        }
        return $resp;
    }

}