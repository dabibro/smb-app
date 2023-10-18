<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 04:05 PM
 */

namespace App\Controller\Dashboard;

use App\Handlers\Rendering;
use App\SMB\Auth;
use App\SMB\SMB;

abstract class Dashboard extends SMB
{
    protected $getUrl;

    public function __construct()
    {
        parent::__construct();
    }







    static function dashboard()
    {
        // echo $request;

        Rendering::RenderContent(ADMIN_VIEWS, 'Dashboard/index');

    }


}