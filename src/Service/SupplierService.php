<?php

namespace App\Service;

use App\DB\Command;
use App\Repository\AdminRepository;
use App\Repository\SupplierRepository;
use App\SMB\Auth;
use App\SMB\Client;

class SupplierService
{
    protected $supplierRepo;
    public function __construct()
    {
        $this->supplierRepo = new SupplierRepository();
    }

    public function createSupplier(array $data)
    {
        $result = $this->supplierRepo->create($data);
        if ($result['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => "create",
                'description' => 'created supplier record',
                'companyId' => $data['companyId']
            ]);
        }
        return $result;
    }

    public function updateSupplier(array $data)
    {
         $result = $this->supplierRepo->updateSupplier($data);
          
        if ($result['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => 'update',
                'description' => 'updated supplier record',
                'companyId' => $data['companyId']
            ]);
        }
        return $result;
    }

    public function getAllSuppliers($params = []): array
    {
        $suppliers = $this->supplierRepo->get($params);
        $result = $suppliers['dataArray'] ?? [];
        return $result;
    }

}
?>