<?php
namespace App\Repository;
use App\DB\SQLQueryBuilder;
class SupplierRepository extends SQLQueryBuilder
{
    public function create(array $data)
    {
        return $this->insert($this->suppliers, $data)
        ->getQuery();
    }  

    public function updateSupplier(array $params)
    {
        $companyId = $params["companyId"];
        unset($params["companyId"]);
        $query = $this->update($this->suppliers, $params);
        return $query->and("companyId = '$companyId'")
        ->getQuery();
    }  
    
    public function get($params = []): array
    {
        $companyId = $params["companyId"];
        $query = $this->select()->from($this->suppliers)->where("companyId = '$companyId'");
        if(isset($params["id"]) && !empty(trim($params["id"]))){
            $id = $params["id"];
            $query->and("id = $id");
        }
        return $query->and("delete_status = 0")->orderBy("id")->getQueryArray();
    }  
}
?>