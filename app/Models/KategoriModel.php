<?php

namespace App\Models;

use App\Entities\Menu;
use App\Models\MyModel;

class KategoriModel extends MyModel
{
    protected $table = "m_kategori";
    protected $primaryKey = "ktgId";
    protected $createdField = "ktgCreatedAt";
    protected $updatedField = "ktgUpdatedAt";
    protected $returnType = "App\Entities\Kategori";
    protected $allowedFields = ["ktgTitle", "ktgShow", "ktgUrutan", "ktgDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    protected function relationships()
   {
       return [
           'menu' => $this->hasMany('(SELECT * FROM `t_kategori_menu` JOIN `m_menu` m ON `ktmMenuId` = m.`menuId`) as menu', Menu::class, 'ktmMenuId = menuId', 'menu', 'ktmKtgId', 'left'),
       ];
   }
}
