<?php

namespace App\Entities;

use App\Entities\MyEntity;

class KategoriMenu extends MyEntity
{

  protected $datamap = [
    'id' => 'ktmId',
    'ktgId' => 'ktmKtgId',
    'menuId' => 'ktmMenuId',
    'createdAt' => 'ktmCreatedAt',
    'updatedAt' => 'ktmUpdatedAt',
    'deletedAt' => 'ktmDeletedAt',
  ];

  protected $show = [
    'id',
    'ktgId',
    'menuId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
