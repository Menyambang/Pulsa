<?php

namespace App\Models;

use App\Entities\JenisMenu;
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
           'menu' => $this->rOrderBy('menuUrutan', 'ASC')->hasMany('(SELECT * FROM `t_kategori_menu` JOIN `m_menu` m ON `ktmMenuId` = m.`menuId`) as menu', Menu::class, 'ktmMenuId = menuId AND ktmKtgId = ktgId', 'menu', 'ktmKtgId', 'left', function(MyModel $rel){
                return $rel->belongsTo('r_jenis_menu', JenisMenu::class, 'jnmId = menuJenis', 'jenisMenu', 'jnmId');
           }),
       ];
   }
}
