<?php

namespace App\Service;

use App\DB\Command;
use App\Repository\AdminRepository;
use App\SMB\Auth;
use App\SMB\Client;

class AdminService
{
    protected $adminRepo;
    public function __construct()
    {
        $this->adminRepo = new AdminRepository();
    }

    public function createDepartment(array $data)
    {
        if (empty($data['pk'])) {
            $action = "Create";
        } else {
            $action = "Update";
        }

        $department = $this->adminRepo->createDepartment($data);

        if ($department['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => $action,
                'description' => $action . 'd ' . ' department record',
                'companyId' => $data['companyId']
            ]);
        }
        return $department;
    }

    public function getAllDepartments($params = [])
    {
        return $this->adminRepo->getAllDepartments($params);
    }

}
?>