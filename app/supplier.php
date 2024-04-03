<?php

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

Router::get(DASHBOARD . '/suppliers/list', function () {
    Suppliers::SuppliersView();
});

Router::get(DASHBOARD . '/suppliers/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Suppliers::CreateSuppliersView($request->params[0]);
});

Router::post(DASHBOARD . '/suppliers/list/delete', function () {
    Suppliers::DeleteSupplier();
});


