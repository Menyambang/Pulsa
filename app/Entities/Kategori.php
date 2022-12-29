<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Kategori extends MyEntity
{
  protected $casts = [
    'menu' => 'json',
  ];
  
  protected $datamap = [
    'id' => 'ktgId',
    'title' => 'ktgTitle',
    'show' => 'ktgShow',
    'urutan' => 'ktgUrutan',
    'usrId' => 'ktgUsrId',
    'createdAt' => 'ktgCreatedAt',
    'updatedAt' => 'ktgUpdatedAt',
    'deletedAt' => 'ktgDeletedAt',
  ];

  protected $show = [
    'id',
    'title',
    'show',
    'urutan',
    'menu',
    'usrId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
