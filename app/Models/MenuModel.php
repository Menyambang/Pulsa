<?php namespace App\Models;

use App\Models\MyModel;

class MenuModel extends MyModel
{
    protected $table = "m_menu";
    protected $primaryKey = "menuId";
    protected $createdField = "menuCreatedAt";
    protected $updatedField = "menuUpdatedAt";
    protected $returnType = "App\Entities\Menu";
    protected $allowedFields = ["menuLabel","menuIdOperator","menuJenis","menuShowHome","menuUrutan","menuIcon","menuKodeProdukPPOB","menuTargetUrlWeb","menuDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}