<?php

namespace App\Controller\Suppliers;

use App\Controller\Locations\Locations;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Rendering;
use App\Handlers\Responses;
use App\SMB\Auth;
use App\SMB\Client;
use App\Lib\Router;

abstract class Suppliers extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    static function SuppliersGroupView($edit = "")
    {
        echo "hiii";
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => self::SupplierGroupList(),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $edit = self::SupplierGroupList(['id' => $edit])[0];
            if (!empty($edit))
                $edit = DataHandlers::convertObj($edit);
            $arg['reference'] = $edit->reference;
            $arg['edit'] = $edit;
        }

        Rendering::RenderContent(ADMIN_VIEWS, 'suppliers/group', $arg, DASHBOARD . '/suppliers/group');
        exit();
    }

    static function PostSuppliersGroup()
    {
               $cmd = new Command();
        $auth = new Auth();
        extract($_POST);
        $params = [
            'tbl_scheme' => $cmd->suppliers_group,
            'created_by' => $auth->AuthName(),
        ];
        $params += $_POST;
        unset($params['Path']);
        if (empty($params['pk'])) {
            @$check = self::SupplierGroupList(['name' => $name, 'location' => $location]);
            if (!empty($check))
                die('<div class="alert alert-danger">Group record with name exist!</div>');
            $params['companyId'] = $_SESSION[$cmd->companyId];
            $submit = $cmd->createRecord($params);
            $action = "Create";
        } else {
            $submit = $cmd->updateRecord($params);
            $action = "Update";
        }
        if ($submit['response'] !== '200')
            die(Responses::displayResponse($submit));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action . 'd ' . $name . ' Supplier group record'
        ]);
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        if (!empty($_POST['SetPermission'])) {
            $id = self::SupplierGroupList(['reference' => $reference])[0]['id'];
            $link = $_POST['Path'] . '/permission/' . $id;
            die('<script>location.replace("' . $link . '")</script>');
        } else {
            die('<script>location.replace("' . $_POST['Path'] . '")</script>');
        }
    }



    static function DeleteGroup()
    {
        $cmd = new Command();

        $pk = base64_decode($_POST['pk']);

        $deleteRequest = $cmd->updateRecord(
            [
                'tbl_scheme' => $cmd->suppliers_group,
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk
            ]
        );

        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => 'Delete',
            'description' => 'Deleted user group record ' . $pk,
        ]);

        die('<script>location.replace("' . $_POST['callback'] . '")</script>');

    }

    static function CreateSuppliersView($edit = "")
    {
        $arg = [
            'locations' => Locations::Locations(),
            'groups' => self::SupplierGroupList()
        ];
        if (!empty($edit)) {
            $edit = self::Supplier(['id' => $edit])[0];
            if (!empty($edit))
                $edit = DataHandlers::convertObj($edit);
            $arg['edit'] = $edit;
        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Suppliers/create', $arg, DASHBOARD . '/Suppliers/create');
        exit();
    }

    static function PostSupplier()
    {
        $cmd = new Command();
        $auth = new Auth();

        extract($_POST);

        $params = [
            'tbl_scheme' => $cmd->Suppliers,
            'created_by' => $auth->AuthName(),

        ];

        $params += $_POST;
        unset($params['Path']);
        if (empty($params['pk'])) {
            @$check = self::Supplier(['username' => $username]);
            if (!empty($check))
                die('<div class="alert alert-danger">Supplier already exist!</div>');
            $params['companyId'] = $_SESSION[$cmd->companyId];
            $submit = $cmd->createRecord($params);
            $action = "Create";
        } else {
            $submit = $cmd->updateRecord($params);
            $_POST['Path'] = DASHBOARD . '/users/list/edit/' . $pk;
            $action = "Update";
        }

        if ($submit['response'] !== '200')
            die(Responses::displayResponse($submit));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action . 'd ' . $first_name . $last_name . ' Supplier record'
        ]);
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        if (!empty($AddNew)) {
            die('<script>location.reload()</script>');
        }
        die('<script>location.replace("' . $_POST['Path'] . '")</script>');
    }

    static function SuppliersView()
    {
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => self::SupplierGroupList(),
            'users' => self::Supplier(),
        ];

        Rendering::RenderContent(ADMIN_VIEWS, 'Suppliers/list', $arg);
        exit();
    }

    static function UserPermission($id = "")
    {
        $cmd = new Command();
        $info = self::Supplier(['id' => $id])[0];
        $arg = [
            'type' => 'user',
            'info' => $info,
            'permission' => json_decode(htmlspecialchars_decode($info['permission']), true),
            'pkField' => 'id',
            'pk' => $id,
            'tbl_scheme' => $cmd->users,
        ];
        Rendering::RenderContent(ADMIN_VIEWS, 'Users/permission', $arg, DASHBOARD . '/users/list');
        exit();
    }

    static function DeleteSupplier()
    {
        $cmd = new Command();

        $pk = base64_decode($_POST['pk']);

        $deleteRequest = $cmd->updateRecord(
            [
                'tbl_scheme' => $cmd->suppliers,
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk
            ]
        );

        if ($deleteRequest['response'] !== '200')
            die(Responses::displayResponse($deleteRequest));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => 'Delete',
            'description' => 'Deleted user record ' . $pk,
        ]);

        die('<script>location.replace("' . $_POST['callback'] . '")</script>');

    }

    static function SupplierGroupList($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0,
            'companyId' => $_SESSION[$cmd->companyId]
        ];
        if (!empty($params))
            $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->suppliers_group,
                'condition' => $condition,
                'order' => 'description'
            ]
        );
        $resp = $data['dataArray'] ?? [];
        return $resp;

    }

    static function SupplierGroupName($reference = "")
    {
        $result = self::SupplierGroupList(['reference' => $reference]);
        return $result[0]['description'] ?? "N/A";
    }

    static function Supplier($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0,
            'companyId' => $_SESSION[$cmd->companyId]
        ];
        if (!empty($params))
            $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->suppliers,
                'condition' => $condition,
                'order' => 'first_name ASC'
            ]
        );
        $resp = $data['dataArray'] ?? [];
        return $resp;
    }
}
