<?php
namespace App\Repository;
use App\DB\SQLQueryBuilder;
class AdminRepository extends SQLQueryBuilder
{
    public function createDepartment(array $data)
    {
        return $this->insert($this->department, $data)
        ->getQuery();
    }  

    public function updateDepartment(array $params)
    {
        $companyId = $params["companyId"];
        unset($params["companyId"]);
        $query = $this->update($this->department, $params);
        return $query->and("companyId = '$companyId'")
        ->getQuery();
    }  
    
    public function getAllDepartments($params = []): array
    {
        $companyId = $params["companyId"];
        $query = $this->select()->from($this->department)->where("companyId = '$companyId'");
        if(isset($params["id"]) && !empty(trim($params["id"]))){
            $id = $params["id"];
            $query->and("id = $id");
        }
        return $query->and("delete_status = 0")->orderBy("id")->getQueryArray();
    }  
}
?>