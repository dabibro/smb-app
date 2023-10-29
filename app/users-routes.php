<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 18/10/2023
 * Time: 08:41 PM
 */

/* *
 * Users Routes
 * */

use App\Controller\Users\Users;
use App\Lib\Router;

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