<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 13/10/2023
 * Time: 03:43 PM
 */

namespace App\Controller\Users;

use App\Controller\Locations\Locations;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Rendering;
use App\Handlers\Responses;
use App\SMB\Auth;
use App\SMB\Client;
use App\Utility\Constants;
use App\Service\AdminService;

abstract class Users extends Command
{


    public function __construct()
    {
        parent::__construct();
    }

    static function UserGroupView($edit = "")
    {
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $arg = [
            'datatable' => 1,
            'locations' => Locations::Locations(),
            'groups' => self::UserGroupList(),
            'reference' => $reference
        ];
        if (!empty($edit)) {
            $edit = self::UserGroupList(['id' => $edit])[0];
            if (!empty($edit)) $edit = DataHandlers::convertObj($edit);
            $arg['reference'] = $edit->reference;
            $arg['edit'] = $edit;
        }

        Rendering::RenderContent(ADMIN_VIEWS, 'Users/group', $arg, DASHBOARD . '/users/group');
        exit();
    }

    static function PostUserGroup()
    {
        $cmd = new Command();
        $auth = new Auth();
      
        extract($_POST);

        $params = [
            'tbl_scheme' => $cmd->users_group,
            'created_by' => $auth->AuthName(),

        ];
        $params += $_POST;
        unset($params['SetPermission']);
        unset($params['Path']);
        if (empty($params['pk'])) {
            @$check = self::UserGroupList(['description' => $description, 'location' => $location]);
            if (!empty($check)) die('<div class="alert alert-danger">Group record with description exist!</div>');
            $params['companyId'] = $_SESSION[$cmd->companyId];
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
            'description' => $action . 'd ' . $description . ' user group record',
            'companyId' => $_SESSION[$cmd->companyId]
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

    static function UserGroupPermission($id = "")
    {
        $cmd = new Command();
        $info = self::UserGroupList(['id' => $id])[0];
        $arg = [
            'type' => 'group',
            'info' => $info,
            'permission' => json_decode(htmlspecialchars_decode($info['permission']), true),
            'pkField' => 'id',
            'pk' => $id,
            'tbl_scheme' => $cmd->users_group,
        ];
        Rendering::RenderContent(ADMIN_VIEWS, 'Users/permission', $arg, DASHBOARD . '/users/group');
        exit();
    }

    static function DeleteGroup()
    {
        $cmd = new Command();

        $pk = base64_decode($_POST['pk']);

        $deleteRequest = $cmd->updateRecord(
            [
                'tbl_scheme' => $cmd->users_group,
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

    static function CreateUserView($edit = "")
    {
        $adminService = new AdminService();
        $cmd = new Command();
        $reference = strtoupper(DataHandlers::generate_random_string(6));
        $arg = [
            'locations' => Locations::Locations(),
            'groups' => self::UserGroupList(),
            'types' => self::AccountTypes(),
            'gender'=> Constants::Gender(),
            'employmentType'=> Constants::EmploymentType(),
            'maritalStatus'=> Constants::MaritalStatus(),
            'reference' =>  $reference,
            'departments' => $adminService->getAllDepartments(['companyId'=> $_SESSION[$cmd->companyId]]),
        ];
        if (!empty($edit)) {
            $edit = self::User(['id' => $edit])[0];
            if (!empty($edit)) $edit = DataHandlers::convertObj($edit);
            $edit->isSoftwareUser = $edit->isSoftwareUser == 0 ? "" : "checked";
            $arg['edit'] = $edit;
            $arg['reference'] = $edit->employeeId;
            print_r($edit->isSoftwareUser);
            if (!is_null($edit->employment_details) && !empty($edit->employment_details))
            { $employment_details = DataHandlers::decodeJsonArray($edit->employment_details);
           $arg['employment_details'] = $employment_details;
        }
            if (!is_null($edit->guarantor) && !empty($edit->guarantor))
            { $guarantor = DataHandlers::decodeJsonArray($edit->guarantor);
            $arg['guarantor'] = $guarantor;}
            if (!is_null($edit->next_of_kin) && !empty($edit->next_of_kin))
            { $next_of_kin = DataHandlers::decodeJsonArray($edit->next_of_kin);
            $arg['next_of_kin'] = $next_of_kin;}

            
        }
        Rendering::RenderContent(ADMIN_VIEWS, 'Users/create', $arg, DASHBOARD . '/users/create');
        exit();
    }

    static function PostUser()
    {
        $cmd = new Command();
        $auth = new Auth();
        extract($_POST);

        $params = [
            'tbl_scheme' => $cmd->users,
            'created_by' => $auth->AuthName(),

        ];

        if (!empty($password)) $_POST['password'] = password_hash($password, PASSWORD_DEFAULT);


        $params += $_POST;
        if (isset($params['isSoftwareUser'])) {
            $params['isSoftwareUser'] = 1;
        } else {
            $params['isSoftwareUser'] = 0;
        }
       

        $params['employment_details'] = json_encode($employment_details);
        $params['next_of_kin'] = json_encode($next_of_kin);
        $params['guarantor'] = json_encode($guarantor);
        unset($params['SetPermission']);
        unset($params['Path']);
        unset($params['AddNew']);
        if (!empty($u_group)) {
            $group_permission = self::UserGroupList(['reference' => $u_group])[0]['permission'];
            if (!empty($group_permission)) {
                $group_permission = htmlspecialchars_decode($group_permission);
                $params['permission'] = $group_permission;
            }
        }
        if (empty($params['pk'])) {
            @$check = self::User(['username' => $username]);
            if (!empty($check)) die('<div class="alert alert-danger">User record with username exist!</div>');
            $params['companyId'] = $_SESSION[$cmd->companyId];
            $submit = $cmd->createRecord($params);
            $action = "Create";
        } else {
            $submit = $cmd->updateRecord($params);
            $_POST['Path'] = DASHBOARD . '/users/list';
            $action = "Update";
        }

        if ($submit['response'] !== '200') die(Responses::displayResponse($submit));
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action . 'd ' . $username . ' user record'
        ]);
        echo '<div class="alert alert-success"> Record successfully saved!</div>';
        if (isset($_POST['isSoftwareUser']) && empty($params['pk'])) {
            $id = self::User(['username' => $username])[0]['id'];
            $link = DASHBOARD . '/users/list/permission/' . $id;
            die('<script>location.replace("' . $link . '")</script>');
        } else {
            if(!empty($AddNew)){
                die('<script>location.reload()</script>');
            }
            die('<script>location.replace("' . $_POST['Path'] . '")</script>');
        }
    }

    static function UsersView()
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
            1 => [
                'code' => '1',
                'description' => 'Administrator'
            ],
            2 => [
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

    static function UserGroupList($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0,
            'companyId' => $_SESSION[$cmd->companyId],
        ];
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->users_group,
                'condition' => $condition,
                'order' => 'description'
            ]
        );
        $resp = $data['dataArray'] ?? [];
        return $resp;

    }

    static function UserGroupName($reference = "")
    {
        $result = self::UserGroupList(['reference' => $reference]);
        return $result[0]['description'] ?? "N/A";
    }

    static function User($params = []): array
    {
        $cmd = new Command();
        $resp = [];
        $condition = [
            'delete_status' => 0,
        ];

        if(isset($_SESSION[$cmd->companyId]) && !empty($_SESSION[$cmd->companyId])){
            $condition['companyId'] = $_SESSION[$cmd->companyId];
        }
        if (!empty($params)) $condition += $params;
        $data = $cmd->getRecord(
            [
                'tbl_scheme' => $cmd->users,
                'condition' => $condition,
                'order' => 'first_name ASC'
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
