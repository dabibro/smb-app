<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 13/10/2023
 * Time: 03:43 PM
 */

namespace App\Controller\Customers;

use App\Controller\Locations\Locations;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Rendering;
use App\Handlers\Responses;
use App\SMB\Auth;
use App\SMB\Client;

abstract class Customers extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    static function CustomerGroupView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => self::CustomerGroupList(),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $edit = self::CustomerGroupList(['id' => $edit])[0];
            if (!empty($edit)) $edit = DataHandlers::convertObj($edit);
            $arg['reference'] = $edit->reference;
            $arg['edit'] = $edit;
        }

        Rendering::RenderContent(ADMIN_VIEWS, 'Customers/group', $arg, DASHBOARD . '/customers/group');
        exit();
    }

    static function PostCustomerGroup()
    {
        echo  'from here';
        $cmd = new Command();
        $auth = new Auth();

        extract($_POST);

        $params = [
            'tbl_scheme' => $cmd->customers_group,
            'created_by' => $auth->AuthName(),

        ];
        $params += $_POST;
        unset($params['SetPermission']);
        unset($params['Path']);
        if (empty($params['pk'])) {
            @$check = self::CustomerGroupList(['name' => $name, 'location' => $location]);
            if (!empty($check)) die('<div class="alert alert-danger">Group record with name exist!</div>');
            $submit = $cmd->createRecord($params);
            $action = "Create";
        } else {
            $submit = $cmd->updateRecord($params);
            $action = "Update";
        }
        if ($submit['response'] !== '200') die(Responses::displayResponse($submit));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action . 'd ' . $name . ' customer group record'
        ]);
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        if (!empty($_POST['SetPermission'])) {
            $id = self::UserGroupList(['reference' => $reference])[0]['id'];
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
                'tbl_scheme' => $cmd->customers_group,
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk
            ]
        );

        if ($deleteRequest['response'] !== '200') die(Responses::displayResponse($deleteRequest));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => 'Delete',
            'description' => 'Deleted user group record ' . $pk,
        ]);

        die('<script>location.replace("' . $_POST['callback'] . '")</script>');

    }

    static function CreateCustomersView($edit = "")
    {
        $arg = [
            'locations' => Locations::Locations(),
            'groups' => self::CustomerGroupList(),
            'types' => self::AccountTypes(),
        ];
        if (!empty($edit)) {
            $edit = self::User(['id' => $edit])[0];
            if (!empty($edit)) $edit = DataHandlers::convertObj($edit);
            $arg['edit'] = $edit;
        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Customers/create', $arg, DASHBOARD . '/customers/create');
        exit();
    }

    static function PostCustomer()
    {
        $cmd = new Command();
        $auth = new Auth();

        extract($_POST);

        $params = [
            'tbl_scheme' => $cmd->customers,
            'created_by' => $auth->AuthName(),

        ];

        $params += $_POST;


        if (!empty($u_group)) {
            $group_permission = self::UserGroupList(['reference' => $u_group])[0]['permission'];
            if (!empty($group_permission)) {
                $group_permission = htmlspecialchars_decode($group_permission);
                $params['permission'] = $group_permission;
            }
        }
        if (!empty($params['pk'])) {
            @$check = self::User(['username' => $username]);
            if (!empty($check)) die('<div class="alert alert-danger">User record with username exist!</div>');
            $submit = $cmd->createRecord($params);
            $action = "Create";
        } else {

            $submit = $cmd->createRecord($params);
            $action = "Create";
            echo "in hear";
        }

        if ($submit['response'] !== '200') die(Responses::displayResponse($submit));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action . 'd ' . $username . ' user record'
        ]);
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        if (!empty($_POST['SetPermission'])) {
            $id = self::User(['username' => $username])[0]['id'];
            $link = DASHBOARD . '/users/list/permission/' . $id;
            die('<script>location.replace("' . $link . '")</script>');
        } else {
            die('<script>location.replace("' . $_POST['Path'] . '")</script>');
        }
    }

    static function CustomersView()
    {
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => self::UserGroupList(),
            'users' => self::User(),
        ];

        Rendering::RenderContent(ADMIN_VIEWS, 'Users/list', $arg);
        exit();
    }

    static function UserPermission($id = "")
    {
        $cmd = new Command();
        $info = self::User(['id' => $id])[0];
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

    static function DeleteUser()
    {
        $cmd = new Command();

        $pk = base64_decode($_POST['pk']);

        $deleteRequest = $cmd->updateRecord(
            [
                'tbl_scheme' => $cmd->users,
                'pkField' => 'id',
                'delete_status' => 1,
                'pk' => $pk
            ]
        );

        if ($deleteRequest['response'] !== '200') die(Responses::displayResponse($deleteRequest));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => 'Delete',
            'description' => 'Deleted user record ' . $pk,
        ]);

        die('<script>location.replace("' . $_POST['callback'] . '")</script>');

    }

    static function Permissions()
    {
        $cmd = new Command();
        extract($_POST);
        if (empty($permission)) die(Responses::alertResponse('No permission(s) selected!', 'danger'));
        $_POST['permission'] = json_encode($permission);
        unset($_POST['type']);
        $update = $cmd->updateRecord($_POST);
        if ($update['response'] !== '200') die(Responses::displayResponse($update));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => 'Update',
            'description' => 'Updated ' . $type . ' permission ' . $pk,
        ]);
        die('<script>location.reload()</script>');
    }

    static function AccountTypes($type = "", $name = 0)
    {
        $types = [
            0 => [
                'code' => '1',
                'description' => 'Administrator'
            ],
            1 => [
                "code" => '2',
                'description' => 'Standard',
            ]
        ];
        if (empty($type)) {
            return $types;
        } else {
            if (!empty($name)) {
                if (isset($types[$type])) return $types[$type]['description'];
            } else {
                return $types[$type];
            }

        }
    }

    static function CustomerGroupList($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0
        ];
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->customers_group,
                'condition' => $condition,
                'order' => 'description'
            ]
        );
        if (!empty($data['dataArray'])) $resp = $data['dataArray'];
        return $resp;

    }

    static function UserGroupName($reference = "")
    {
        if (!empty($reference)) return self::CustomerGroupList(['reference' => $reference])[0]['description'];
    }

    static function User($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0
        ];
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->customers,
                'condition' => $condition,
                'order' => 'customer_name ASC'
            ]
        )['dataArray'];
        if (!empty($data)) $resp = $data;
        return $resp;
    }

    static function UserName($username)
    {
        if (!empty($username)) {
            $user = self::User(['username' => $username])[0];
            return trim($user['first_name'] . ' ' . $user['last_name']);
        }
    }

    static function LogView($request)
    {

        $arg = [
            'datatable' => 1
        ];

        Rendering::RenderContent(ADMIN_VIEWS, 'Users/log', $arg);
    }

    static function DeleteLog()
    {
        $cmd = new Command();
        $pk = base64_decode($_POST['pk']);
        $deleteRequest = $cmd->deleteRecord(
            [
                'tbl_scheme' => $cmd->logger,
                'pk' => ['id' => $pk],
            ]
        );
        if ($deleteRequest['response'] !== '200') die(Responses::displayResponse($deleteRequest));
        if (!empty($_POST['callback'])) die('<script>location.replace("' . $_POST['callback'] . '")</script>');

    }
}
