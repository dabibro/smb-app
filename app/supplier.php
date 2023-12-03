<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 18/10/2023
 * Time: 08:41 PM
 */

/* *
 * suppliers Routes
 * */

use App\Controller\Suppliers\Suppliers;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;

Router::get(DASHBOARD . '/suppliers/group', function () {
    Suppliers::SuppliersGroupView();
});

Router::post(DASHBOARD . '/suppliers/group', function () {
    Suppliers::PostSuppliersGroup();
});

Router::get(DASHBOARD . '/suppliers/group/edit/([0-9]*)', function (Request $request, Response $response) {
    Suppliers::SuppliersGroupView($request->params[0]);
});

Router::post(DASHBOARD . '/suppliers/group/delete', function () {
    Suppliers::DeleteGroup();
});

Router::get(DASHBOARD . '/suppliers/create', function () {
    Suppliers::CreateSuppliersView();
});

Router::post(DASHBOARD . '/suppliers/create', function () {
    Suppliers::PostSupplier();
});

Router::get(DASHBOARD . '/Suppliers/list', function () {
    Suppliers::SuppliersView();
});

Router::get(DASHBOARD . '/Suppliers/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Suppliers::CreateSuppliersView($request->params[0]);
});

Router::post(DASHBOARD . '/Suppliers/list/delete', function () {
    Suppliers::DeleteSupplier();
});


