<?php

namespace App\Controller\Admin;

use App\Controller\Locations\Locations;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Rendering;
use App\Handlers\Responses;
use App\SMB\Auth;
use App\SMB\Client;
use App\Utility\Constants;
use App\Service\AdminService;

abstract class Admin extends Command
{


    public function __construct()
    {
        parent::__construct();
    }

    static function DepartmentView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $cmd = new Command();
        $adminService = new AdminService();
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => $adminService->getAllDepartments(["companyId" => $_SESSION[$cmd->companyId]]),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $department = $adminService->getAllDepartments([
                "companyId" => $_SESSION[$cmd->companyId],
                "id" => $edit
            ])[0];
            if (!empty($department))
                $department = DataHandlers::convertObj($department);
            $arg['reference'] = $department->reference;
            $arg['edit'] = $department;

        }

        Rendering::RenderContent(ADMIN_VIEWS, '/department', $arg, DASHBOARD . '/department');
        exit();
    }

    static function PostDepartment()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        $params['companyId'] = $_SESSION[$cmd->companyId];
        unset($params['Path']);

        $adminService = new AdminService();
        if (empty($params['pk'])) {
            $submit = $adminService->createDepartment($params);
        } else {
            $submit = $adminService->updateDepartment($params);
        }
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }

    static function DeleteDepartment()
    {

        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $adminService = new AdminService();
        $deleteRequest = $adminService->updateDepartment(
            [
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk,
                'companyId' => $_SESSION[$cmd->companyId]
            ]
        );
        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
       // die('<script>location.reload()</script>');

    }
}
