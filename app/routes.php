<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 01:23 PM
 */

use App\Controller\Dashboard\Dashboard;
use App\Controller\Login\Login;
use App\Controller\Users\Users;
use App\Lib\Request;
use App\Lib\Response;
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

/* *
 * Users Routes
 * */

Router::get(DASHBOARD . '/users/group', function () {
    Users::UserGroupView();
});
Router::post(DASHBOARD . '/users/group', function () {
    Users::PostUserGroup();
});
Router::get(DASHBOARD . '/users/group/permission/([0-9]*)', function (Request $request, Response $response) {
    Users::UserGroupPermission($request->params[0]);
});
Router::get(DASHBOARD . '/users/group/edit/([0-9]*)', function (Request $request, Response $response) {
    Users::UserGroupView($request->params[0]);
});
Router::post(DASHBOARD . '/users/group/delete', function () {
    Users::DeleteGroup();
});

Router::post(DASHBOARD . '/users/group/permission', function () {
    Users::Permissions();
});

Router::get(DASHBOARD . '/users/create', function () {
    Users::CreateUserView();
});
Router::post(DASHBOARD . '/users/create', function () {
    Users::PostUser();
});
Router::get(DASHBOARD . '/users/list', function () {
    Users::UsersView();
});
Router::get(DASHBOARD . '/users/list/permission/([0-9]*)', function (Request $request, Response $response) {
    Users::UserPermission($request->params[0]);
});
Router::get(DASHBOARD . '/users/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Users::CreateUserView($request->params[0]);
});
Router::post(DASHBOARD . '/users/list/delete', function () {
    Users::DeleteUser();
});

Router::get(DASHBOARD . '/users/log', function (Request $request) {
    Users::LogView($request);
});
Router::post(DASHBOARD . '/users/log', function (Request $request) {
    Users::LogView($request);
});
Router::post(DASHBOARD . '/users/log/delete', function () {
    Users::DeleteLog();
});
//require_once VIEWS . 'shared/403.html';
exit();

