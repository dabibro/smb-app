<?php

use App\Controller\Admin\Admin;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;

Router::get(DASHBOARD . '/admin/department', function () {
    Admin::DepartmentView();
});
Router::post(DASHBOARD . '/department', function () {
    Admin::PostDepartment();
});

Router::get(DASHBOARD . '/department/edit/([0-9]*)', function (Request $request, Response $response) {
    Admin::DepartmentView($request->params[0]);
});
Router::post(DASHBOARD . '/department/delete', function () {
    Admin::DeleteDepartment();
});

Router::post(DASHBOARD . '/global', function () {
    Admin::GlobalRequest();
});

?>