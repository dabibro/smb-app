<?php

namespace App\Service;

use App\Repository\InventoryRepository;
use App\SMB\Client;

class InventoryService
{
    protected $inventoryRepo;
    public function __construct()
    {
        $this->inventoryRepo = new InventoryRepository();
    }

    public function createProductCategory(array $data)
    {
        $category = $this->inventoryRepo->createProductCategory($data);
          
        if ($category['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => "create",
                'description' => 'created category record',
                'companyId' => $data['companyId']
            ]);
        }
        return $category;
    }

    public function updateProductCategory(array $data)
    {
         $category = $this->inventoryRepo->updateProductCategory($data);
          
        if ($category['response'] !== '200') {
            Client::logger([
                'class_name' => Client::ClassName(self::class),
                'function_name' => Client::MethodNameExplode(__METHOD__),
                'action' => 'update',
                'description' => 'updated category record',
                'companyId' => $data['companyId']
            ]);
        }
        return $category;
    }

    public function getAllProductCategory($params = []): array
    {
        $categories = $this->inventoryRepo->getAllProductCategories($params);
        $result = $categories['dataArray'] ?? [];
        return $result;
    }

}
?>