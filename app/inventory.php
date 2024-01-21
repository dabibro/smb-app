<?php

use App\Controller\Inventory\Inventory;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;

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
