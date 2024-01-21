<?php
namespace App\Repository;
use App\DB\SQLQueryBuilder;
class InventoryRepository extends SQLQueryBuilder
{
    public function createProductCategory(array $data)
    {
        return $this->insert($this->productCategories, $data)
        ->getQuery();
    }  

    public function updateProductCategory(array $params)
    {
        $companyId = $params["companyId"];
        unset($params["companyId"]);
        $query = $this->update($this->productCategories, $params);
        return $query->and("companyId = '$companyId'")
        ->getQuery();
    }  
    
    public function getAllProductCategories($params = []): array
    {
        $companyId = $params["companyId"];
        $query = $this->select()->from($this->productCategories)->where("companyId = '$companyId'");
        if(isset($params["id"]) && !empty(trim($params["id"]))){
            $id = $params["id"];
            $query->and("id = $id");
        }
        return $query->and("delete_status = 0")->orderBy("id")->getQueryArray();
    }  
}
?>