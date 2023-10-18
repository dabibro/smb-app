<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 16/10/2023
 * Time: 04:28 PM
 */

namespace App\Controller\Login;

use App\Handlers\Rendering;
use App\SMB\Auth;

abstract class Login
{

    static function index()
    {
        Rendering::RenderPage(ADMIN_VIEWS, 'Login/index');
        exit();
    }

    static function doLogin()
    {
        $auth = new Auth();
        $auth->Auth($_POST);
    }

    static function doLogout()
    {
        $auth = new Auth();
        $auth->ExitAuth();
    }

}