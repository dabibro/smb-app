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
          
        if ($category['response'] !== '200') 
        {
            $this->updateLog($data['companyId'], 'create', 'product category');
        }
        return $category;
    }


    public function updateProductCategory(array $data)
    {
         $category = $this->inventoryRepo->updateProductCategory($data);
          
        if ($category['response'] === '200')
        {
           $this->updateLog($data['companyId'], 'update', 'product category');
        }
        return $category;
    }

    public function getAllProductCategory($params = []): array
    {
        $categories = $this->inventoryRepo->getAllProductCategories($params);
        $result = $categories['dataArray'] ?? [];
        return $result;
    }

    public function createStorage(array $data)
    {
        $storage = $this->inventoryRepo->createStorage($data);
        if ($storage['response'] === '200')
        {
            $this->updateLog($data['companyId'], 'create', 'storage');
        }
        return $storage;
    }


    public function updateStorage(array $data)
    {
         $storage = $this->inventoryRepo->updateStorage($data);
          
         if ($storage['response'] === '200')
         {
            $this->updateLog($data['companyId'], 'update', 'storage');
         }
         return $storage;
    }

    public function getAllStorage($params = []): array
    {
        $storages = $this->inventoryRepo->getAllStorages($params);
        $result = $storages['dataArray'] ?? [];
        return $result;
    }

    public function createUnit(array $data)
    {
        $storage = $this->inventoryRepo->createMeasurementUnit($data);
        if ($storage['response'] === '200')
        {
            $this->updateLog($data['companyId'], 'create', 'unit of measurement');
        }
        return $storage;
    }


    public function updateUnit(array $data)
    {
         $storage = $this->inventoryRepo->updateMeasurementUnit($data);
          
         if ($storage['response'] === '200')
         {
            $this->updateLog($data['companyId'], 'update', 'unit of measurement');
         }
         return $storage;
    }

    public function getAllUnit($params = []): array
    {
        $storages = $this->inventoryRepo->getMeasurementUnit($params);
        $result = $storages['dataArray'] ?? [];
        return $result;
    }

    public function createInventory(array $data)
    {
        $storage = $this->inventoryRepo->createProduct($data);
        if ($storage['response'] === '200')
        {
            $this->updateLog($data['companyId'], 'create', 'inventory');
        }
        return $storage;
    }


    public function updateInvenotry(array $data)
    {
         $storage = $this->inventoryRepo->updateProduct($data);
          
         if ($storage['response'] === '200')
         {
            $this->updateLog($data['companyId'], 'update', 'inventory');
         }
         return $storage;
    }

    public function getAllInventory($params = []): array
    {
        $storages = $this->inventoryRepo->getAllProduct($params);
        $result = $storages['dataArray'] ?? [];
        return $result;
    }

    private function updateLog($companyId, $action, $table)
    {
        Client::logger([
            'class_name' => Client::ClassName(self::class),
            'function_name' => Client::MethodNameExplode(__METHOD__),
            'action' => $action,
            'description' => $action.'d '. $table .' record',
            'companyId' => $companyId
        ]);
    }
}
