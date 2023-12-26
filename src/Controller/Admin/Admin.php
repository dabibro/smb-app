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
            'groups' => $adminService->getAllDepartments(["companyId" => $_SESSION[$cmd->companyId],
                                                          "edit" => $edit]),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $edit = $adminService->getAllDepartments(["companyId" => $_SESSION[$cmd->companyId],
            "id" => $edit])[0];
            if (!empty($edit)) $edit = DataHandlers::convertObj($edit);
            $arg['reference'] = $edit->reference;
            $arg['edit'] = $edit;
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
        $submit = $adminService->createDepartment($params);
        if ($submit['response'] !== '200') {
            die(Responses::displayResponse($submit));
        }
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        die('<script>location.reload()</script>');
    }
}
