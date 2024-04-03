<?php

use App\Controller\Inventory\Inventory;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;

//category
Router::get(DASHBOARD . '/inventory/category', function () {
    Inventory::CategoryView();
});
Router::post(DASHBOARD . '/inventory/category', function () {
    Inventory::PostCategory();
});

Router::get(DASHBOARD . '/inventory/category/edit/([0-9]*)', function (Request $request, Response $response) {
    Inventory::CategoryView($request->params[0]);
});
Router::post(DASHBOARD . '/inventory/category/delete', function () {
    Inventory::DeleteCategory();
});

//store
Router::get(DASHBOARD . '/inventory/storage', function () {
    Inventory::StorageView();
});
Router::post(DASHBOARD . '/inventory/storage', function () {
    Inventory::PostStorage();
});

Router::get(DASHBOARD . '/inventory/storage/edit/([0-9]*)', function (Request $request, Response $response) {
    Inventory::StorageView($request->params[0]);
});
Router::post(DASHBOARD . '/inventory/storage/delete', function () {
    Inventory::DeleteStorage();
});

//unit of measurement
Router::get(DASHBOARD . '/inventory/measurementunit', function () {
    Inventory::UnitView();
});
Router::post(DASHBOARD . '/inventory/measurementunit', function () {
    Inventory::PostUnit();
});

Router::get(DASHBOARD . '/inventory/measurementunit/edit/([0-9]*)', function (Request $request, Response $response) {
    Inventory::UnitView($request->params[0]);
});
Router::post(DASHBOARD . '/inventory/measurementunit/delete', function () {
    Inventory::DeleteUnit();
});


//product
Router::get(DASHBOARD . '/inventory/product', function () {
    Inventory::ProductView();
});
Router::post(DASHBOARD . '/inventory/product', function () {
    Inventory::PostProduct();
});

Router::get(DASHBOARD . '/inventory/list/edit/([0-9]*)', function (Request $request, Response $response) {
    Inventory::ProductView($request->params[0]);
});

Router::get(DASHBOARD . '/inventory/list', function () {
    Inventory::ProductListView();
});

Router::post(DASHBOARD . '/inventory/product/delete', function () {
    Inventory::DeleteProduct();
});


