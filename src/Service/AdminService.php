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
        $department = $this->adminRepo->createDepartment($data);
          
        if ($department['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => 'create',
                'description' => 'created department record',
                'companyId' => $data['companyId']
            ]);
        }
        return $department;
        if (empty($data['pk'])) {
            $department = $this->adminRepo->createDepartment($data);
            $action = "Create";
        } else {
            $department = $this->adminRepo->updateDepartment($data);
            $action = "Update";
        }

       

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

    public function updateDepartment(array $data)
    {
         $department = $this->adminRepo->updateDepartment($data);
          
        if ($department['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => 'update',
                'description' => 'updated department record',
                'companyId' => $data['companyId']
            ]);
        }
        return $department;
    }

    public function getAllDepartments($params = []): array
    {
        $departments = $this->adminRepo->getAllDepartments($params);
        $result = $departments['dataArray'] ?? [];
        return $result;
    }

}
?>