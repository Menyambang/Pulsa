<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Menu extends MyEntity
{
  protected $casts = [
    'jenisMenu' => 'json',
  ];

  protected $datamap = [
    'id' => 'menuId',
    'label' => 'menuLabel',
    'idOperator' => 'menuIdOperator',
    'jenis' => 'menuJenis',
    'showHome' => 'menuShowHome',
    'urutan' => 'menuUrutan',
    'icon' => 'menuIcon',
    'kodeProdukPPOB' => 'menuKodeProdukPPOB',
    'targetUrlWeb' => 'menuTargetUrlWeb',
    'deskripsi' => 'menuDeskripsi',
    'createdAt' => 'menuCreatedAt',
    'updatedAt' => 'menuUpdatedAt',
    'deletedAt' => 'menuDeletedAt',
  ];

  protected $show = [
    'id',
    'label',
    'idOperator',
    'jenis',
    'showHome',
    'urutan',
    'icon',
    'kodeProdukPPOB',
    'targetUrlWeb',
    'deskripsi',
    'jenisMenu',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
