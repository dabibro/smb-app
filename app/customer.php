<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 18/10/2023
 * Time: 08:41 PM
 */

/* *
 * customers Routes
 * */

use App\Controller\Customers\Customers;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;

Router::get(DASHBOARD . '/customers/group', function () {
    Customers::CustomerGroupView();
});

Router::post(DASHBOARD . '/customers/group', function () {
    Customers::PostCustomerGroup();
});

Router::get(DASHBOARD . '/customers/group/edit/([0-9]*)', function (Request $request, Response $response) {
    Customers::CustomerGroupView($request->params[0]);
});

Router::post(DASHBOARD . '/customers/group/delete', function () {
    Customers::DeleteGroup();
});

Router::get(DASHBOARD . '/customers/create', function () {
    Customers::CreateCustomersView();
});

Router::post(DASHBOARD . '/customers/create', function () {
    Customers::PostCustomer();
});

Router::get(DASHBOARD . '/customers/list', function () {
    Customers::CustomersView();
});

Router::get(DASHBOARD . '/customers/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Customers::CreateCustomersView($request->params[0]);
});

Router::post(DASHBOARD . '/customers/list/delete', function () {
    Customers::DeleteCustomer();
});


