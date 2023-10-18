<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 03:15 PM
 */

namespace App\Handlers;


use App\SMB\SMB;

abstract class Rendering extends SMB
{
    protected $app;

    public function __construct()
    {
        parent::__construct();

    }

    static function RenderContent($views, $file = "", $arg = "", $path = "")
    {

        if (!empty($arg)) extract($arg);
        try {
            $app = new SMB();
            $content = $views . $file . '.php';
            if (empty($path)) $path = $_SERVER['REQUEST_URI'];
            require $views . 'Layout/index.php';
        } catch (\Exception $error) {
            echo 'Can not find file' . $error;
        }
    }

    static function RenderPage($views, $file = "", $arg = "", $path = "")
    {

        if (!empty($arg)) extract($arg);
        try {
            require $views . $file . '.php';
        } catch (\Exception $error) {
            echo 'Can not find file' . $error;
        }
    }
}