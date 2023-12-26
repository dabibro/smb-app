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
    
    public function getAllDepartments($params = [])
    {
        $companyId = $params["companyId"];
        $sql = $this->select()->from($this->department)->where("companyId = '$companyId'");
        if(isset($params["edit"]) && !empty(trim($params["edit"]))){
            $id = $params["edit"];
            $sql->and("id = $id");
        }
        return $sql->getQuery();
    }  
}
?>