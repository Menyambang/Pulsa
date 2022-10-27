<?php namespace App\Models;

use App\Entities\JenisMenu;
use App\Models\MyModel;

class MenuModel extends MyModel
{
    protected $table = "m_menu";
    protected $primaryKey = "menuId";
    protected $createdField = "menuCreatedAt";
    protected $updatedField = "menuUpdatedAt";
    protected $returnType = "App\Entities\Menu";
    protected $allowedFields = ["menuLabel","menuIdOperator","menuJenis","menuShowHome","menuUrutan","menuIcon","menuKodeProdukPPOB","menuTargetUrlWeb","menuDeskripsi","menuDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'jenisMenu' => ['table' => 'r_jenis_menu', 'condition' => 'jnmId = menuJenis', 'entity' => JenisMenu::class, 'type' => 'left'],
        ];
    }

    public function selectMenu(){
        $data = $this->findAll();

        $select= [];
        foreach ($data as $key => $value) {
            $select[$value->menuId] = $value->menuLabel;
        }

        return $select;
    }
}