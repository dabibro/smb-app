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

use App\Controller\Customers\Customers;
use App\Lib\Router;

Router::get(DASHBOARD . '/customers/group', function () {
    Customers::UserGroupView();
});
Router::post(DASHBOARD . '/customers/group', function () {
    Users::PostUserGroup();
});

Router::get(DASHBOARD . '/users/group/edit/([0-9]*)', function (Request $request, Response $response) {
    Users::UserGroupView($request->params[0]);
});
Router::post(DASHBOARD . '/customers/group/delete', function () {
    Users::DeleteGroup();
});


Router::get(DASHBOARD . '/customers/create', function () {
    Customers::CreateCustomersView();
});
Router::post(DASHBOARD . '/customers/create', function () {
    Users::PostUser();
});
Router::get(DASHBOARD . '/customers/list', function () {
    Users::UsersView();
});

Router::get(DASHBOARD . '/customers/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Users::CreateUserView($request->params[0]);
});
Router::post(DASHBOARD . '/customers/list/delete', function () {
    Users::DeleteUser();
});

