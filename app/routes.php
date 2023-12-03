<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:23 PM
 */

use App\Controller\Dashboard\Dashboard;
use App\Controller\Login\Login;
use App\Lib\Router;

//use App\Controller\AppController;

//$router = new Router(new SRequest);

/*
Router::get('/', function () {
    RenderP::render(STORE, 'index', [
        'title' => 'SMB Online Store',
        'meta_keyword' => '',
        'meta_description' => '',
    ]);
});
*/

Router::get(DASHBOARD, function () {
    Dashboard::dashboard();
});

Router::get(DASHBOARD . '/login', function () {
    Login::index();
});
Router::post(DASHBOARD . '/login', function () {
    Login::doLogin();
});
Router::get(DASHBOARD . '/logout', function () {
    Login::doLogout();
});

require_once 'users-routes.php';
require_once  'customer.php';
require_once   'supplier.php';
//require_once VIEWS . 'shared/403.html';
exit();

