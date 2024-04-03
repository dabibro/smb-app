<?php
namespace App\Repository;
use App\DB\SQLQueryBuilder;
class InventoryRepository extends SQLQueryBuilder
{
    public function createProductCategory(array $data)
    {
        return $this->create($this->productCategories, $data);
    }  

    public function updateProductCategory(array $params)
    {
        return $this->updateRecord($this->productCategories, $params);
    }  
    
    public function getAllProductCategories($params = []): array
    {
        return $this->getAll($this->productCategories, $params);
    }  

    // store
    public function createStorage(array $data)
    {
        return $this->create($this->storages, $data);
    }  

    public function updateStorage(array $params)
    {
        return $this->updateRecord($this->storages, $params);
    }  
    
    public function getAllStorages($params = []): array
    {
        return $this->getAll($this->storages, $params);
    }  

    //unit of measurement
    public function createMeasurementUnit(array $data)
    {
        return $this->create($this->units, $data);
    }  

    public function updateMeasurementUnit(array $params)
    {
        return $this->updateRecord($this->units, $params);
    }  
    
    public function getMeasurementUnit($params = []): array
    {
        return $this->getAll($this->units, $params);
    }  

    //product
    public function createProduct(array $data)
    {
        return $this->create($this->inventory, $data);
    }  

    public function updateProduct(array $params)
    {
        return $this->updateRecord($this->inventory, $params);
    }  
    
    public function getAllProduct($params = []): array
    {
        return $this->getAll($this->inventory, $params);
    }  
   
   
   
   
   
   
   
   
   
   
   
    private function create($table, $data)
    {
        return $this->insert($table, $data)
        ->getQuery();
    }

    private function updateRecord($table, $params)
    {
        $companyId = $params["companyId"];
        unset($params["companyId"]);
        $query = $this->update($table, $params);
        return $query->and("companyId = '$companyId'")
        ->getQuery();
    }

    private function getAll($table, $params)
    {
        $companyId = $params["companyId"];
        $query = $this->select()->from($table)->where("companyId = '$companyId'");
        if(isset($params["id"]) && !empty(trim($params["id"]))){
            $id = $params["id"];
            $query->and("id = $id");
        }
        return $query->and("delete_status = 0")->orderBy("id")->getQueryArray();
        
    }
}
