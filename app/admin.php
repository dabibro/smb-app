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
?>